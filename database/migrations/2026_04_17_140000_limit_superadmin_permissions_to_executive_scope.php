<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $superAdminRoleId = DB::table('roles')->where('name', 'superadmin')->value('id');

        if (!$superAdminRoleId) {
            return;
        }

        $superAdminPermissionNames = [
            'users-create',
            'users-read',
            'users-update',
            'users-delete',
            'roles-create',
            'roles-read',
            'roles-update',
            'roles-delete',
            'log-system-read',
        ];

        $permissionIds = DB::table('permissions')
            ->whereIn('name', $superAdminPermissionNames)
            ->pluck('id')
            ->values();

        DB::table('permission_role')
            ->where('role_id', $superAdminRoleId)
            ->delete();

        if ($permissionIds->isEmpty()) {
            return;
        }

        $rows = $permissionIds
            ->map(fn ($permissionId) => [
                'permission_id' => $permissionId,
                'role_id' => $superAdminRoleId,
            ])
            ->all();

        DB::table('permission_role')->insert($rows);
    }

    public function down(): void
    {
    }
};
