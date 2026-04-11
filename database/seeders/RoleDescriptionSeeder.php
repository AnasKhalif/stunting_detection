<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleDescriptionSeeder extends Seeder
{
    public function run(): void
    {
        $descriptions = [
            'superadmin' => 'Super Administrator dengan akses penuh ke seluruh sistem',
            'admin'      => 'Administrator yang mengelola konten dan data aplikasi',
            'dokter'     => 'Tenaga kesehatan yang menangani konsultasi dan pemantauan gizi',
            'orang_tua'  => 'Orang tua yang memantau perkembangan dan deteksi stunting anak',
        ];

        foreach ($descriptions as $name => $description) {
            Role::where('name', $name)->update(['description' => $description]);
        }
    }
}
