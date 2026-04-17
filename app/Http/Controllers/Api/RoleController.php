<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    private const EXECUTIVE_ROLE_PERMISSION_TEMPLATES = [
        'superadmin' => [
            'users-create',
            'users-read',
            'users-update',
            'users-delete',
            'roles-create',
            'roles-read',
            'roles-update',
            'roles-delete',
            'log-system-read',
        ],
        'admin' => [
            'dashboard-read',
            'users-create', 'users-read', 'users-update', 'users-delete',
            'articles-create', 'articles-read', 'articles-update', 'articles-delete',
            'faqs-create', 'faqs-read', 'faqs-update', 'faqs-delete',
            'foods-create', 'foods-read', 'foods-update', 'foods-delete',
            'children-read', 'children-update',
            'reports-read',
            'monitoring-read',
            'profile-read', 'profile-update',
        ],
        'dokter' => [
            'dashboard-read',
            'consultations-create', 'consultations-read', 'consultations-update',
            'children-read',
            'monitoring-read',
            'foods-read', 'foods-create', 'foods-update',
            'stunting-read',
            'profile-read', 'profile-update',
        ],
        'user' => [
            'dashboard-read',
            'children-create', 'children-read', 'children-update', 'children-delete',
            'stunting-create', 'stunting-read',
            'monitoring-read',
            'consultations-create', 'consultations-read', 'consultations-update', 'consultations-delete',
            'foods-read',
            'profile-read', 'profile-update',
        ],
    ];

    public function index(Request $request): JsonResponse
    {
        if (!$this->canAccess($request->user(), 'roles-read')) {
            return response()->json(['message' => 'Tidak memiliki akses untuk melihat role.'], 403);
        }

        $roles = Role::with('permissions')
            ->select('id', 'name', 'display_name', 'description', 'created_at')
            ->get()
            ->map(fn ($r) => $this->transform($r));

        return response()->json([
            'message' => 'Data role berhasil diambil.',
            'data'    => $roles,
        ]);
    }

    public function show(Request $request, Role $role): JsonResponse
    {
        if (!$this->canAccess($request->user(), 'roles-read')) {
            return response()->json(['message' => 'Tidak memiliki akses untuk melihat role.'], 403);
        }

        $role->loadMissing('permissions');

        return response()->json([
            'message' => 'Data role berhasil diambil.',
            'data'    => $this->transform($role),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        if (!$this->canAccess($request->user(), 'roles-create')) {
            return response()->json(['message' => 'Tidak memiliki akses untuk membuat role.'], 403);
        }

        $validated = $request->validate([
            'name'         => ['required', 'string', 'max:100', 'unique:roles,name'],
            'display_name' => ['required', 'string', 'max:100'],
            'description'  => ['nullable', 'string', 'max:500'],
            'permissions'  => ['nullable', 'array'],
            'permissions.*' => ['string', 'exists:permissions,name'],
            'exclusive_roles' => ['nullable', 'array'],
            'exclusive_roles.*' => ['string', 'exists:roles,name'],
        ]);

        $role = Role::create([
            'name'         => $validated['name'],
            'display_name' => $validated['display_name'],
            'description'  => $validated['description'] ?? null,
        ]);

        if (array_key_exists('permissions', $validated)) {
            $permissionNames = $this->reconcilePermissionNames($role, $validated);
            $perms = Permission::whereIn('name', $permissionNames)->get();
            $role->syncPermissions($perms);
        }

        return response()->json([
            'message' => 'Role berhasil dibuat.',
            'data'    => $this->transform($role->load('permissions')),
        ], 201);
    }

    public function update(Request $request, Role $role): JsonResponse
    {
        if (!$this->canAccess($request->user(), 'roles-update')) {
            return response()->json(['message' => 'Tidak memiliki akses untuk memperbarui role.'], 403);
        }

        $validated = $request->validate([
            'name'         => ['sometimes', 'string', 'max:100', 'unique:roles,name,' . $role->id],
            'display_name' => ['sometimes', 'string', 'max:100'],
            'description'  => ['nullable', 'string', 'max:500'],
            'permissions'  => ['nullable', 'array'],
            'permissions.*' => ['string', 'exists:permissions,name'],
            'exclusive_roles' => ['nullable', 'array'],
            'exclusive_roles.*' => ['string', 'exists:roles,name'],
        ]);

        $role->update([
            'name'         => $validated['name'] ?? $role->name,
            'display_name' => $validated['display_name'] ?? $role->display_name,
            'description'  => $validated['description'] ?? $role->description,
        ]);

        if (array_key_exists('permissions', $validated)) {
            $permissionNames = $this->reconcilePermissionNames($role, $validated);
            $perms = Permission::whereIn('name', $permissionNames)->get();
            $role->syncPermissions($perms);
        }

        return response()->json([
            'message' => 'Role berhasil diperbarui.',
            'data'    => $this->transform($role->fresh('permissions')),
        ]);
    }

    public function destroy(Request $request, Role $role): JsonResponse
    {
        if (!$this->canAccess($request->user(), 'roles-delete')) {
            return response()->json(['message' => 'Tidak memiliki akses untuk menghapus role.'], 403);
        }

        $role->syncPermissions([]);
        $role->delete();

        return response()->json([
            'message' => 'Role berhasil dihapus.',
            'data'    => null,
        ]);
    }

    // GET /api/v1/permissions — list all available permissions
    public function permissions(Request $request): JsonResponse
    {
        if (!$this->canAccess($request->user(), 'roles-read')) {
            return response()->json(['message' => 'Tidak memiliki akses untuk melihat permission.'], 403);
        }

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

    private function reconcilePermissionNames(Role $role, array $validated): array
    {
        $requestedPermissionNames = collect($validated['permissions'] ?? [])->values();

        if ($role->name !== 'superadmin' || !array_key_exists('exclusive_roles', $validated)) {
            return $requestedPermissionNames->all();
        }

        $exclusiveRoleNames = collect($validated['exclusive_roles'] ?? [])
            ->filter(fn ($name) => is_string($name) && $name !== '')
            ->map(fn ($name) => $this->normalizeExecutiveRoleName(trim($name)))
            ->unique()
            ->values();

        if (!$exclusiveRoleNames->contains('superadmin')) {
            $exclusiveRoleNames->prepend('superadmin');
        }

        $templatePermissionNames = $exclusiveRoleNames
            ->flatMap(fn (string $roleName) => self::EXECUTIVE_ROLE_PERMISSION_TEMPLATES[$roleName] ?? [])
            ->filter(fn (string $permissionName) => Permission::where('name', $permissionName)->exists())
            ->unique()
            ->values();

        return $requestedPermissionNames
            ->intersect($templatePermissionNames)
            ->values()
            ->all();
    }

    private function normalizeExecutiveRoleName(string $roleName): string
    {
        $normalized = strtolower($roleName);

        return match ($normalized) {
            'orang_tua', 'orangtua', 'parent' => 'user',
            'health_worker', 'healthworker', 'tenaga_kesehatan' => 'dokter',
            default => $normalized,
        };
    }

    private function canAccess(?User $user, string $permission): bool
    {
        if (!$user) {
            return false;
        }

        return $user->isSuperAdmin() || $user->isAbleTo($permission);
    }
}
