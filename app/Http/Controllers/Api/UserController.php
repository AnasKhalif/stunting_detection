<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        if (!$this->canAccess($request->user(), 'users-read')) {
            return response()->json(['message' => 'Tidak memiliki akses untuk melihat pengguna.'], 403);
        }

        $query = User::with('roles.permissions');

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($role = $request->input('role')) {
            $query->whereHas('roles', fn ($q) => $q->where('name', $role));
        }

        $users = $query->latest()->paginate($request->input('limit', 15));

        return response()->json([
            'message' => 'Data pengguna berhasil diambil.',
            'data' => $users->map(fn ($u) => $this->transformUser($u)),
            'meta' => [
                'total'       => $users->total(),
                'page'        => $users->currentPage(),
                'limit'       => $users->perPage(),
                'total_pages' => $users->lastPage(),
            ],
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        if (!$this->canAccess($request->user(), 'users-create')) {
            return response()->json(['message' => 'Tidak memiliki akses untuk membuat pengguna.'], 403);
        }

        $validated = $request->validate([
            'name'         => ['required', 'string', 'max:255'],
            'email'        => ['required', 'email', 'unique:users,email'],
            'password'     => ['required', Password::min(8)],
            'role'         => ['required', 'string'],
            'phone_number' => ['nullable', 'string', 'max:20'],
            'address'      => ['nullable', 'string', 'max:1000'],
        ]);

        $user = User::create([
            'name'         => $validated['name'],
            'email'        => $validated['email'],
            'password'     => Hash::make($validated['password']),
            'phone_number' => $validated['phone_number'] ?? null,
            'address'      => $validated['address'] ?? null,
        ]);

        $role = Role::firstOrCreate(
            ['name' => $validated['role']],
            ['display_name' => ucfirst($validated['role']), 'description' => '']
        );

        $user->addRole($role);

        return response()->json([
            'message' => 'Pengguna berhasil ditambahkan.',
            'data'    => $this->transformUser($user->fresh('roles')),
        ], 201);
    }

    public function show(Request $request, User $user): JsonResponse
    {
        if (!$this->canAccess($request->user(), 'users-read')) {
            return response()->json(['message' => 'Tidak memiliki akses untuk melihat pengguna.'], 403);
        }

        return response()->json([
            'message' => 'Data pengguna berhasil diambil.',
            'data'    => $this->transformUser($user->loadMissing('roles.permissions')),
        ]);
    }

    public function update(Request $request, User $user): JsonResponse
    {
        if (!$this->canAccess($request->user(), 'users-update')) {
            return response()->json(['message' => 'Tidak memiliki akses untuk memperbarui pengguna.'], 403);
        }

        $validated = $request->validate([
            'name'         => ['sometimes', 'string', 'max:255'],
            'email'        => ['sometimes', 'email', 'unique:users,email,' . $user->id],
            'password'     => ['sometimes', 'nullable', Password::min(8)],
            'role'         => ['sometimes', 'string'],
            'phone_number' => ['nullable', 'string', 'max:20'],
            'address'      => ['nullable', 'string', 'max:1000'],
        ]);

        $user->update([
            'name'         => $validated['name'] ?? $user->name,
            'email'        => $validated['email'] ?? $user->email,
            'phone_number' => $validated['phone_number'] ?? $user->phone_number,
            'address'      => $validated['address'] ?? $user->address,
            ...(!empty($validated['password'])
                ? ['password' => Hash::make($validated['password'])]
                : []),
        ]);

        if (!empty($validated['role'])) {
            $user->syncRoles([]);
            $role = Role::firstOrCreate(
                ['name' => $validated['role']],
                ['display_name' => ucfirst($validated['role']), 'description' => '']
            );
            $user->addRole($role);
        }

        return response()->json([
            'message' => 'Pengguna berhasil diperbarui.',
            'data'    => $this->transformUser($user->fresh('roles')),
        ]);
    }

    public function destroy(Request $request, User $user): JsonResponse
    {
        if (!$this->canAccess($request->user(), 'users-delete')) {
            return response()->json(['message' => 'Tidak memiliki akses untuk menghapus pengguna.'], 403);
        }

        $user->delete();

        return response()->json([
            'message' => 'Pengguna berhasil dihapus.',
            'data'    => null,
        ]);
    }

    private function transformUser(User $user): array
    {
        $roles = $user->roles;
        $role = $roles->firstWhere('name', 'superadmin') ?? $roles->first();
        $permissions = $role
            ? $role->permissions->pluck('name')->unique()->values()
            : collect();

        return [
            'id'           => $user->id,
            'uid'          => $user->uid,
            'name'         => $user->name,
            'email'        => $user->email,
            'phone_number' => $user->phone_number,
            'address'      => $user->address,
            'roles'        => $roles->pluck('name')->values(),
            'role'         => $role ? [
                'id' => $role->id,
                'name' => $role->name,
                'display_name' => $role->display_name,
                'permissions' => $permissions,
            ] : null,
            'created_at'   => $user->created_at,
            'updated_at'   => $user->updated_at,
        ];
    }

    private function canAccess(?User $user, string $permission): bool
    {
        if (!$user) {
            return false;
        }

        return $user->isSuperAdmin() || $user->isAbleTo($permission);
    }
}
