<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class MonitoringDemoSeeder extends Seeder
{
    public function run(): void
    {
        $user = DB::table('users')->where('email', 'anas@example.com')->first();

        if (!$user) {
            $this->command->warn('Tidak ada user orang tua ditemukan. Tambah user terlebih dahulu.');
            return;
        }

        $this->command->info("Menggunakan user: {$user->name} (id: {$user->id})");

        // Buat anak demo — lahir 24 bulan lalu (2 tahun)
        $dob = Carbon::now()->subMonths(24)->startOfDay();

        $childId = DB::table('children')->insertGetId([
            'uuid'         => Str::uuid(),
            'user_id'      => $user->id,
            'name'         => 'Demo Anak',
            'gender'       => 'laki-laki',
            'date_of_birth'=> $dob->toDateString(),
            'birth_weight' => 3.2,
            'birth_height' => 50.0,
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);

        $this->command->info("Anak dibuat dengan id: {$childId}");

        // Data pertumbuhan 6 bulan terakhir
        // Mulai dari usia 18 bulan, tiap bulan naik ~1-1.5 cm
        $measurements = [
            ['months_ago' => 5, 'age' => 19, 'height' => 76.5, 'weight' => 9.2,  'z' => -1.8,  'status' => 'normal'],
            ['months_ago' => 4, 'age' => 20, 'height' => 78.1, 'weight' => 9.6,  'z' => -1.5,  'status' => 'normal'],
            ['months_ago' => 3, 'age' => 21, 'height' => 79.8, 'weight' => 9.9,  'z' => -1.2,  'status' => 'normal'],
            ['months_ago' => 2, 'age' => 22, 'height' => 81.0, 'weight' => 10.2, 'z' => -1.0,  'status' => 'normal'],
            ['months_ago' => 1, 'age' => 23, 'height' => 82.3, 'weight' => 10.5, 'z' => -0.75, 'status' => 'normal'],
            ['months_ago' => 0, 'age' => 24, 'height' => 83.5, 'weight' => 10.8, 'z' => -0.5,  'status' => 'normal'],
        ];

        // WHO reference untuk usia 24 bulan laki-laki (contoh)
        $whoRef = [
            'SD3neg' => 78.0,
            'SD2neg' => 80.8,
            'SD1neg' => 83.6,
            'median' => 86.4,
            'SD1'    => 89.2,
            'SD2'    => 92.0,
            'SD3'    => 94.9,
        ];

        foreach ($measurements as $m) {
            $date = Carbon::now()->subMonths($m['months_ago'])->startOfMonth()->addDays(12);
            DB::table('stunting_results')->insert([
                'user_id'          => $user->id,
                'child_id'         => $childId,
                'gender'           => 'laki-laki',
                'age'              => $m['age'],
                'height'           => $m['height'],
                'weight'           => $m['weight'],
                'measurement_date' => $date->toDateString(),
                'z_score'          => $m['z'],
                'prediction_result'=> $m['status'],
                'who_standard_ref' => json_encode($whoRef),
                'notes'            => null,
                'created_at'       => $date,
                'updated_at'       => $date,
            ]);
        }

        $this->command->info('6 data pengukuran demo berhasil dibuat!');
        $this->command->info("Buka monitoring: /monitoring?child_id={$childId}");
    }
}
