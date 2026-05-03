<?php

namespace App\Console\Commands;

use App\Http\Controllers\Api\StuntingController;
use App\Models\Child;
use App\Models\ChildVaccination;
use App\Models\StuntingResult;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

/**
 * Seed data dummy realistis untuk anak demo (default: Radit, child_id=3).
 * Cerita:
 *  - Lahir 12 April 2024, laki-laki, ASI Eksklusif penuh 0-6 bulan
 *  - Pengukuran setiap bulan dari usia 0 sampai 24 bulan (25 titik)
 *  - Pola pertumbuhan: awalnya borderline stunted (-2 SD) sampai 6 bulan,
 *    lalu catch-up growth setelah MP-ASI baik, normal di 12-24 bulan
 *  - Imunisasi mengikuti jadwal Permenkes No. 2/2020 secara tepat waktu
 */
class SeedRaditDemoData extends Command
{
    protected $signature = 'demo:seed-radit {--child-id=3 : ID anak yang akan di-seed} {--fresh : Hapus data lama dulu}';
    protected $description = 'Seed data dummy realistis (pengukuran 24 bulan + imunisasi lengkap) untuk demo.';

    public function handle(): int
    {
        $childId = (int) $this->option('child-id');
        $fresh   = (bool) $this->option('fresh');

        $child = Child::find($childId);
        if (!$child) {
            $this->error("Anak dengan ID {$childId} tidak ditemukan.");
            return self::FAILURE;
        }

        $this->info("Seeding demo data untuk: {$child->name} (id={$child->id}, lahir {$child->date_of_birth->toDateString()})");

        if ($fresh) {
            $this->warn('Menghapus data lama...');
            StuntingResult::where('child_id', $child->id)->delete();
            ChildVaccination::where('child_id', $child->id)->delete();
        }

        // Pastikan ASI Eksklusif = true untuk demo cerita
        if ($child->asi_eksklusif !== true) {
            $child->asi_eksklusif = true;
            $child->save();
            $this->line('  ✓ ASI Eksklusif: true');
        }

        $dob = Carbon::parse($child->date_of_birth);
        $gender = $child->gender;

        // ===== Pertumbuhan =====
        // Pola TB & BB realistis untuk laki-laki (smooth growth dengan sedikit variance)
        // Awal: borderline stunted lalu recovery setelah MP-ASI
        $growthByMonth = $this->generateGrowthPattern($gender);

        DB::beginTransaction();
        try {
            $createdMeasurements = 0;
            foreach ($growthByMonth as $age => [$height, $weight]) {
                $measureDate = $dob->copy()->addMonths($age)->addDays(rand(0, 3));

                // Hindari tanggal future
                if ($measureDate->isFuture()) {
                    continue;
                }

                // Hindari duplikat
                $exists = StuntingResult::where('child_id', $child->id)
                    ->where('age', $age)
                    ->whereDate('measurement_date', $measureDate->toDateString())
                    ->exists();
                if ($exists) continue;

                $z      = StuntingController::calculateZScore($gender, $age, $height);
                $whoH   = array_map(fn ($v) => round((float) $v, 2), StuntingController::getWhoReference($gender, $age));
                $whoW   = array_map(fn ($v) => round((float) $v, 2), StuntingController::getWhoWfaReference($gender, $age));
                $status = $this->statusFromZ($z);

                StuntingResult::create([
                    'user_id'           => $child->user_id,
                    'child_id'          => $child->id,
                    'gender'            => $gender,
                    'age'               => $age,
                    'height'            => $height,
                    'weight'            => $weight,
                    'measurement_date'  => $measureDate->toDateString(),
                    'z_score'           => round($z, 3),
                    'prediction_result' => $status,
                    'who_standard_ref'  => json_encode(['hfa' => $whoH, 'wfa' => $whoW]),
                    'notes'             => $this->getNote($age, $status),
                ]);
                $createdMeasurements++;
            }

            $this->line("  ✓ Pengukuran dibuat: {$createdMeasurements} bulan");

            // ===== Imunisasi =====
            $vaccineSchedule = $this->getVaccineSchedule();
            $createdVaccines = 0;
            $now = Carbon::now();

            foreach ($vaccineSchedule as $vac) {
                $givenDate = $dob->copy()->addMonths($vac['recommended_age'])->addDays(rand(0, 7));

                // Skip vaksin yang seharusnya diberi di masa depan
                if ($givenDate->isFuture()) continue;

                // Skip kalau sudah ada (avoid dup)
                $exists = ChildVaccination::where('child_id', $child->id)
                    ->where('vaccine_code', $vac['code'])
                    ->exists();
                if ($exists) continue;

                ChildVaccination::create([
                    'child_id'     => $child->id,
                    'vaccine_code' => $vac['code'],
                    'given_date'   => $givenDate->toDateString(),
                    'batch_no'     => 'BAT-' . $givenDate->format('Y') . '-' . str_pad((string) rand(1, 999), 3, '0', STR_PAD_LEFT),
                    'given_by'     => $child->user_id, // dummy, idealnya petugas
                    'notes'        => null,
                ]);
                $createdVaccines++;
            }

            $this->line("  ✓ Imunisasi dicatat: {$createdVaccines} vaksin");

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            $this->error('Gagal: ' . $e->getMessage());
            return self::FAILURE;
        }

        $this->newLine();
        $this->info('Selesai! Buka halaman Monitoring & Imunisasi untuk anak ' . $child->name);
        return self::SUCCESS;
    }

    /**
     * Pola tumbuh kembang demo untuk laki-laki:
     *  0-6 bulan: borderline stunted (~-2 SD), masih dalam pengamatan
     *  6-12 bulan: catch-up growth, naik ke -1 SD
     *  12-24 bulan: stabil di sekitar median (-0.5 SD)
     * BB mengikuti pertumbuhan tinggi (rasio sehat)
     *
     * Returns: [age_in_months => [height_cm, weight_kg]]
     */
    private function generateGrowthPattern(string $gender): array
    {
        // Laki-laki — base dari WHO median, lalu offset cerita
        // Format: [age => [tb, bb]]
        if ($gender === 'laki-laki') {
            return [
                0  => [49.5, 3.3],
                1  => [54.2, 4.4],
                2  => [57.8, 5.4],
                3  => [60.8, 6.2],
                4  => [63.2, 6.9],
                5  => [65.0, 7.5],   // -2 SD borderline
                6  => [66.8, 7.9],
                7  => [68.5, 8.3],
                8  => [70.1, 8.7],
                9  => [71.6, 9.0],
                10 => [73.0, 9.3],
                11 => [74.4, 9.6],   // mulai catch-up
                12 => [75.8, 9.9],
                13 => [77.1, 10.2],
                14 => [78.3, 10.5],
                15 => [79.4, 10.7],
                16 => [80.5, 11.0],
                17 => [81.5, 11.3],
                18 => [82.5, 11.5],
                19 => [83.4, 11.8],
                20 => [84.3, 12.0],
                21 => [85.1, 12.3],
                22 => [85.9, 12.5],
                23 => [86.7, 12.7],
                24 => [87.5, 13.0],
            ];
        }

        // Perempuan
        return [
            0  => [49.0, 3.2],
            1  => [53.5, 4.2],
            2  => [57.0, 5.1],
            3  => [59.8, 5.8],
            4  => [62.0, 6.4],
            5  => [63.8, 6.9],
            6  => [65.5, 7.3],
            7  => [67.2, 7.6],
            8  => [68.7, 8.0],
            9  => [70.0, 8.3],
            10 => [71.4, 8.5],
            11 => [72.7, 8.8],
            12 => [74.0, 9.0],
            13 => [75.2, 9.3],
            14 => [76.4, 9.5],
            15 => [77.5, 9.8],
            16 => [78.6, 10.0],
            17 => [79.6, 10.2],
            18 => [80.6, 10.5],
            19 => [81.5, 10.7],
            20 => [82.4, 10.9],
            21 => [83.2, 11.1],
            22 => [84.1, 11.4],
            23 => [84.9, 11.6],
            24 => [85.7, 11.8],
        ];
    }

    private function statusFromZ(float $z): string
    {
        if ($z < -3) return 'severely stunted';
        if ($z < -2) return 'stunted';
        if ($z > 3)  return 'tinggi';
        return 'normal';
    }

    private function getNote(int $age, string $status): ?string
    {
        $notes = [
            0  => 'Pemeriksaan saat lahir, kondisi sehat',
            1  => 'Kontrol bulanan, ASI eksklusif lancar',
            6  => 'Mulai MP-ASI, pengenalan bubur lumat',
            12 => 'Anak mulai berjalan, pola makan keluarga',
            18 => 'Catch-up growth terlihat baik',
            24 => 'Pemeriksaan rutin posyandu',
        ];

        return $notes[$age] ?? null;
    }

    /**
     * Master jadwal vaksin (Permenkes No. 2/2020) — sub-set untuk seed.
     * Hanya tanggal pemberian sesuai recommended_age.
     */
    private function getVaccineSchedule(): array
    {
        return [
            ['code' => 'hepb_0',                  'recommended_age' => 0],
            ['code' => 'bcg',                     'recommended_age' => 1],
            ['code' => 'polio_1',                 'recommended_age' => 1],
            ['code' => 'dpt_hb_hib_1',            'recommended_age' => 2],
            ['code' => 'polio_2',                 'recommended_age' => 2],
            ['code' => 'rotavirus_1',             'recommended_age' => 2],
            ['code' => 'pcv_1',                   'recommended_age' => 2],
            ['code' => 'dpt_hb_hib_2',            'recommended_age' => 3],
            ['code' => 'polio_3',                 'recommended_age' => 3],
            ['code' => 'rotavirus_2',             'recommended_age' => 3],
            ['code' => 'pcv_2',                   'recommended_age' => 3],
            ['code' => 'dpt_hb_hib_3',            'recommended_age' => 4],
            ['code' => 'polio_4',                 'recommended_age' => 4],
            ['code' => 'ipv_1',                   'recommended_age' => 4],
            ['code' => 'rotavirus_3',             'recommended_age' => 4],
            ['code' => 'campak_rubella',          'recommended_age' => 9],
            ['code' => 'ipv_2',                   'recommended_age' => 9],
            ['code' => 'pcv_3',                   'recommended_age' => 12],
            ['code' => 'dpt_hb_hib_lanjutan',     'recommended_age' => 18],
            ['code' => 'campak_rubella_lanjutan', 'recommended_age' => 18],
        ];
    }
}
