<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $now = now();

        $permissionNames = [
            'dashboard-read',
            'users-create', 'users-read', 'users-update', 'users-delete',
            'roles-create', 'roles-read', 'roles-update', 'roles-delete',
            'articles-create', 'articles-read', 'articles-update', 'articles-delete',
            'faqs-create', 'faqs-read', 'faqs-update', 'faqs-delete',
            'foods-create', 'foods-read', 'foods-update', 'foods-delete',
            'children-create', 'children-read', 'children-update', 'children-delete',
            'reports-read',
            'stunting-create', 'stunting-read',
            'monitoring-read',
            'consultations-create', 'consultations-read', 'consultations-update', 'consultations-delete',
            'profile-read', 'profile-update',
            'log-system-read',
        ];

        $permissionsPayload = array_map(function (string $name) use ($now) {
            [$module, $action] = array_pad(explode('-', $name), 2, 'read');
            return [
                'name' => $name,
                'display_name' => ucfirst($action) . ' ' . ucwords(str_replace('-', ' ', $module)),
                'description' => ucfirst($action) . ' access for ' . str_replace('-', ' ', $module),
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }, $permissionNames);

        DB::table('permissions')->upsert(
            $permissionsPayload,
            ['name'],
            ['display_name', 'description', 'updated_at']
        );

        $permissionIdByName = DB::table('permissions')
            ->whereIn('name', $permissionNames)
            ->pluck('id', 'name');

        $rolePermissionMatrix = [
            'superadmin' => $permissionNames,
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
            'health_worker' => [
                'dashboard-read',
                'consultations-create', 'consultations-read', 'consultations-update',
                'children-read',
                'monitoring-read',
                'foods-read', 'foods-create', 'foods-update',
                'stunting-read',
                'profile-read', 'profile-update',
            ],
            'tenaga_kesehatan' => [
                'dashboard-read',
                'consultations-create', 'consultations-read', 'consultations-update',
                'children-read',
                'monitoring-read',
                'foods-read',
                'stunting-read',
                'profile-read', 'profile-update',
            ],
            'orang_tua' => [
                'dashboard-read',
                'children-create', 'children-read', 'children-update', 'children-delete',
                'stunting-create', 'stunting-read',
                'monitoring-read',
                'consultations-create', 'consultations-read', 'consultations-update', 'consultations-delete',
                'foods-read',
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

        foreach ($rolePermissionMatrix as $roleName => $rolePermissions) {
            $roleId = DB::table('roles')->where('name', $roleName)->value('id');
            if (!$roleId) {
                continue;
            }

            $rows = collect($rolePermissions)
                ->map(fn (string $permissionName) => $permissionIdByName[$permissionName] ?? null)
                ->filter()
                ->map(fn ($permissionId) => [
                    'permission_id' => $permissionId,
                    'role_id' => $roleId,
                ])
                ->unique(fn (array $row) => $row['permission_id'] . '-' . $row['role_id'])
                ->values()
                ->all();

            if (!empty($rows)) {
                DB::table('permission_role')->upsert($rows, ['permission_id', 'role_id'], ['role_id']);
            }
        }
    }

    public function down(): void
    {
    }
};
