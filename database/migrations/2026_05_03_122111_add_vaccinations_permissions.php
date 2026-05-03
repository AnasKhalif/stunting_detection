<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $now = now();

        $permissionNames = [
            'vaccinations-create',
            'vaccinations-read',
            'vaccinations-update',
            'vaccinations-delete',
        ];

        $payload = array_map(function (string $name) use ($now) {
            [, $action] = explode('-', $name);
            return [
                'name' => $name,
                'display_name' => ucfirst($action) . ' Vaccinations',
                'description' => ucfirst($action) . ' access for child vaccinations (imunisasi)',
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }, $permissionNames);

        DB::table('permissions')->upsert($payload, ['name'], ['display_name', 'description', 'updated_at']);

        $idsByName = DB::table('permissions')
            ->whereIn('name', $permissionNames)
            ->pluck('id', 'name');

        $matrix = [
            'superadmin'        => $permissionNames,
            'admin'             => ['vaccinations-read'],
            'dokter'            => $permissionNames,
            'health_worker'     => $permissionNames,
            'tenaga_kesehatan'  => $permissionNames,
            'orang_tua'         => ['vaccinations-create', 'vaccinations-read', 'vaccinations-update', 'vaccinations-delete'],
            'user'              => ['vaccinations-create', 'vaccinations-read', 'vaccinations-update', 'vaccinations-delete'],
        ];

        foreach ($matrix as $roleName => $perms) {
            $roleId = DB::table('roles')->where('name', $roleName)->value('id');
            if (!$roleId) {
                continue;
            }

            $rows = collect($perms)
                ->map(fn ($name) => $idsByName[$name] ?? null)
                ->filter()
                ->map(fn ($pid) => ['permission_id' => $pid, 'role_id' => $roleId])
                ->unique(fn ($r) => $r['permission_id'] . '-' . $r['role_id'])
                ->values()
                ->all();

            if (!empty($rows)) {
                DB::table('permission_role')->upsert($rows, ['permission_id', 'role_id'], ['role_id']);
            }
        }
    }

    public function down(): void
    {
        DB::table('permissions')->whereIn('name', [
            'vaccinations-create',
            'vaccinations-read',
            'vaccinations-update',
            'vaccinations-delete',
        ])->delete();
    }
};
