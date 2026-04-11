<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index(): JsonResponse
    {
        $roles = Role::with('permissions')
            ->select('id', 'name', 'display_name', 'description', 'created_at')
            ->get()
            ->map(fn($r) => $this->transform($r));

        return response()->json([
            'message' => 'Data role berhasil diambil.',
            'data'    => $roles,
        ]);
    }

    public function show(Role $role): JsonResponse
    {
        $role->loadMissing('permissions');

        return response()->json([
            'message' => 'Data role berhasil diambil.',
            'data'    => $this->transform($role),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name'         => ['required', 'string', 'max:100', 'unique:roles,name'],
            'display_name' => ['required', 'string', 'max:100'],
            'description'  => ['nullable', 'string', 'max:500'],
            'permissions'  => ['nullable', 'array'],
            'permissions.*'=> ['string', 'exists:permissions,name'],
        ]);

        $role = Role::create([
            'name'         => $validated['name'],
            'display_name' => $validated['display_name'],
            'description'  => $validated['description'] ?? null,
        ]);

        if (!empty($validated['permissions'])) {
            $perms = Permission::whereIn('name', $validated['permissions'])->get();
            $role->syncPermissions($perms);
        }

        return response()->json([
            'message' => 'Role berhasil dibuat.',
            'data'    => $this->transform($role->load('permissions')),
        ], 201);
    }

    public function update(Request $request, Role $role): JsonResponse
    {
        $validated = $request->validate([
            'name'         => ['sometimes', 'string', 'max:100', 'unique:roles,name,' . $role->id],
            'display_name' => ['sometimes', 'string', 'max:100'],
            'description'  => ['nullable', 'string', 'max:500'],
            'permissions'  => ['nullable', 'array'],
            'permissions.*'=> ['string', 'exists:permissions,name'],
        ]);

        $role->update([
            'name'         => $validated['name'] ?? $role->name,
            'display_name' => $validated['display_name'] ?? $role->display_name,
            'description'  => $validated['description'] ?? $role->description,
        ]);

        if (array_key_exists('permissions', $validated)) {
            $perms = Permission::whereIn('name', $validated['permissions'] ?? [])->get();
            $role->syncPermissions($perms);
        }

        return response()->json([
            'message' => 'Role berhasil diperbarui.',
            'data'    => $this->transform($role->fresh('permissions')),
        ]);
    }

    public function destroy(Role $role): JsonResponse
    {
        $role->syncPermissions([]);
        $role->delete();

        return response()->json([
            'message' => 'Role berhasil dihapus.',
            'data'    => null,
        ]);
    }

    // GET /api/v1/permissions — list all available permissions
    public function permissions(): JsonResponse
    {
        $permissions = Permission::select('id', 'name', 'display_name', 'description')->get();

        return response()->json([
            'message' => 'Data permission berhasil diambil.',
            'data'    => $permissions,
        ]);
    }

    private function transform(Role $role): array
    {
        return [
            'id'           => $role->id,
            'name'         => $role->name,
            'display_name' => $role->display_name,
            'description'  => $role->description,
            'permissions'  => $role->permissions->pluck('name'),
            'created_at'   => $role->created_at,
        ];
    }
}
