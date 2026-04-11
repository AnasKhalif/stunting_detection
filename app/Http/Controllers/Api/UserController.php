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
        $query = User::with('roles');

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

    public function show(User $user): JsonResponse
    {
        return response()->json([
            'message' => 'Data pengguna berhasil diambil.',
            'data'    => $this->transformUser($user->loadMissing('roles')),
        ]);
    }

    public function update(Request $request, User $user): JsonResponse
    {
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

    public function destroy(User $user): JsonResponse
    {
        $user->delete();

        return response()->json([
            'message' => 'Pengguna berhasil dihapus.',
            'data'    => null,
        ]);
    }

    private function transformUser(User $user): array
    {
        return [
            'id'           => $user->id,
            'uid'          => $user->uid,
            'name'         => $user->name,
            'email'        => $user->email,
            'phone_number' => $user->phone_number,
            'address'      => $user->address,
            'role'         => $user->roles->first()?->name,
            'created_at'   => $user->created_at,
            'updated_at'   => $user->updated_at,
        ];
    }
}
