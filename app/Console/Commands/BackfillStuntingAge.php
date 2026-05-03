<?php

namespace App\Console\Commands;

use App\Http\Controllers\Api\StuntingController;
use App\Models\StuntingResult;
use Carbon\Carbon;
use Illuminate\Console\Command;

/**
 * Backfill kolom age, z_score, dan who_standard_ref untuk stunting_results lama
 * yang tersimpan dengan age=0 akibat bug urutan diffInMonths di controller.
 */
class BackfillStuntingAge extends Command
{
    protected $signature = 'stunting:backfill-age {--dry-run : Tampilkan perubahan tanpa menyimpan} {--force : Recompute z_score & who_ref untuk SEMUA record, bukan hanya yang age-nya salah} {--sync-status : Sinkronkan prediction_result agar konsisten dengan z_score (rule WHO)}';
    protected $description = 'Recompute age + z_score + who_standard_ref untuk record stunting_results yang age-nya salah (atau semua dengan --force). Tambahkan --sync-status untuk sinkronkan label.';

    public function handle(): int
    {
        $dry        = (bool) $this->option('dry-run');
        $force      = (bool) $this->option('force');
        $syncStatus = (bool) $this->option('sync-status');

        $results = StuntingResult::with('child:id,date_of_birth,gender')
            ->whereHas('child')
            ->get();

        $updated = 0;
        $skipped = 0;

        foreach ($results as $r) {
            $child = $r->child;
            if (!$child || !$child->date_of_birth || !$r->measurement_date) {
                $skipped++;
                continue;
            }

            $correctAge = (int) Carbon::parse($child->date_of_birth)
                ->diffInMonths(Carbon::parse($r->measurement_date));
            $correctAge = max(0, min(60, $correctAge));

            $gender   = $child->gender;
            $newZ     = StuntingController::calculateZScore($gender, $correctAge, (float) $r->height);
            $newWhoH  = array_map(fn ($v) => round((float) $v, 2), StuntingController::getWhoReference($gender, $correctAge));
            $newWhoW  = array_map(fn ($v) => round((float) $v, 2), StuntingController::getWhoWfaReference($gender, $correctAge));
            $newZRounded = round($newZ, 3);
            $newStatus = $this->statusFromZ($newZRounded);

            $ageWrong    = (int) $r->age !== $correctAge;
            $zWrong      = abs((float) $r->z_score - $newZRounded) > 0.01;
            $statusWrong = $r->prediction_result !== $newStatus;

            $needsFix = $ageWrong
                || ($force && $zWrong)
                || ($syncStatus && $statusWrong);

            if (!$needsFix) {
                continue;
            }

            $this->line(sprintf(
                '#%d  child=%d  age %d → %d  z_score %s → %s  status %s → %s  height=%s',
                $r->id,
                $r->child_id,
                $r->age,
                $correctAge,
                number_format((float) $r->z_score, 3),
                number_format($newZ, 3),
                $r->prediction_result,
                $newStatus,
                $r->height,
            ));

            if (!$dry) {
                $r->age              = $correctAge;
                $r->z_score          = $newZRounded;
                $r->who_standard_ref = json_encode(['hfa' => $newWhoH, 'wfa' => $newWhoW]);
                if ($syncStatus) {
                    $r->prediction_result = $newStatus;
                }
                $r->save();
            }

            $updated++;
        }

        $this->newLine();
        $this->info(($dry ? '[DRY-RUN] ' : '') . "Selesai. Diperbarui: {$updated}, dilewati: {$skipped}, total dicek: " . $results->count());

        return self::SUCCESS;
    }

    /**
     * Klasifikasi WHO TB/U:
     *  z < -3        : severely stunted (Sangat Pendek)
     *  -3 ≤ z < -2   : stunted (Pendek)
     *  -2 ≤ z ≤ +3   : normal
     *  z > +3        : tinggi
     * Catatan: enum di DB hanya menerima ['Normal','Berisiko','Stunting'] di migration awal,
     * tapi data eksisting menyimpan lowercase 'severely stunted','stunted','normal','tinggi' — tetap dipakai.
     */
    private function statusFromZ(float $z): string
    {
        if ($z < -3) return 'severely stunted';
        if ($z < -2) return 'stunted';
        if ($z > 3)  return 'tinggi';
        return 'normal';
    }
}
