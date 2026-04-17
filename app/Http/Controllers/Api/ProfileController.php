<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user()->loadMissing('roles.permissions');
        return response()->json(['data' => $this->transform($user)]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'         => 'sometimes|string|max:255',
            'phone_number' => 'sometimes|string|max:20',
            'address'      => 'sometimes|string|max:1000',
            'date_of_birth' => 'sometimes|date',
            'gender'       => 'sometimes|in:laki-laki,perempuan',
            'email'        => 'sometimes|email|unique:users,email,' . $user->id,
        ]);

        $user->update($request->only(['name', 'phone_number', 'address', 'date_of_birth', 'gender', 'email']));

        return response()->json(['data' => $this->transform($user->fresh('roles.permissions'))]);
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'password'         => ['required', 'confirmed', Password::min(8)],
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'message' => 'Password lama tidak sesuai.',
                'errors'  => ['current_password' => ['Password lama tidak sesuai.']],
            ], 422);
        }

        $user->update(['password' => Hash::make($request->password)]);

        return response()->json(['message' => 'Password berhasil diubah.']);
    }

    public function syncRoles(Request $request)
    {
        $user = Auth::user()->loadMissing('roles.permissions');

        if (!$user || !$user->isSuperAdmin()) {
            return response()->json([
                'message' => 'Tidak memiliki akses untuk sinkronisasi role.',
            ], 403);
        }

        $validated = $request->validate([
            'roles' => ['required', 'array', 'min:1'],
            'roles.*' => ['required', 'string'],
        ]);

        $aliases = [
            'super_admin' => 'superadmin',
            'orang_tua' => 'user',
            'orangtua' => 'user',
            'health_worker' => 'dokter',
            'healthworker' => 'dokter',
        ];

        $normalizedRoles = collect($validated['roles'])
            ->map(fn ($roleName) => strtolower(trim($roleName)))
            ->map(fn ($roleName) => $aliases[$roleName] ?? $roleName)
            ->push('superadmin')
            ->unique()
            ->values();

        $roles = Role::whereIn('name', $normalizedRoles)->pluck('id')->toArray();

        if (empty($roles)) {
            return response()->json([
                'message' => 'Role tidak ditemukan.',
            ], 422);
        }

        $user->syncRoles($roles);

        return response()->json([
            'message' => 'Role akun berhasil disinkronkan.',
            'data' => $this->transform($user->fresh('roles.permissions')),
        ]);
    }

    private function transform($user): array
    {
        $roles = $user->roles;
        $role = $roles->firstWhere('name', 'superadmin') ?? $roles->first();
        $permissions = $role
            ? $role->permissions->pluck('name')->unique()->values()
            : collect();

        return [
            'id'            => $user->id,
            'uid'           => $user->uid,
            'name'          => $user->name,
            'email'         => $user->email,
            'phone_number'  => $user->phone_number,
            'address'       => $user->address,
            'date_of_birth' => $user->date_of_birth?->toDateString(),
            'gender'        => $user->gender,
            'roles'         => $roles->pluck('name')->values(),
            'role'          => $role ? [
                'id' => $role->id,
                'name' => $role->name,
                'display_name' => $role->display_name,
                'permissions' => $permissions,
            ] : null,
            'created_at'    => $user->created_at,
        ];
    }
}
