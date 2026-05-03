<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Child;
use App\Models\ChildVaccination;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Pengelolaan jadwal & catatan imunisasi anak.
 * Sumber jadwal: Permenkes No. 2 Tahun 2020 — Buku KIA hal. 72.
 */
class VaccinationController extends Controller
{
    /**
     * Master jadwal imunisasi nasional (Permenkes No. 2/2020).
     * Setiap entry: code, name, recommended_age (bulan tepat pemberian),
     * catch_up_until (bulan, batas akhir kejar)
     */
    private const SCHEDULE = [
        ['code' => 'hepb_0',                  'name' => 'Hepatitis B (<24 Jam)',         'recommended_age' => 0,  'catch_up_until' => 1,  'group' => 'Bayi 0-1 bulan'],
        ['code' => 'bcg',                     'name' => 'BCG',                           'recommended_age' => 1,  'catch_up_until' => 12, 'group' => 'Bayi 1 bulan'],
        ['code' => 'polio_1',                 'name' => 'Polio Tetes 1',                 'recommended_age' => 1,  'catch_up_until' => 12, 'group' => 'Bayi 1 bulan'],
        ['code' => 'dpt_hb_hib_1',            'name' => 'DPT-HB-Hib 1',                  'recommended_age' => 2,  'catch_up_until' => 12, 'group' => 'Bayi 2 bulan'],
        ['code' => 'polio_2',                 'name' => 'Polio Tetes 2',                 'recommended_age' => 2,  'catch_up_until' => 12, 'group' => 'Bayi 2 bulan'],
        ['code' => 'rotavirus_1',             'name' => 'Rotavirus 1',                   'recommended_age' => 2,  'catch_up_until' => 6,  'group' => 'Bayi 2 bulan'],
        ['code' => 'pcv_1',                   'name' => 'PCV 1',                         'recommended_age' => 2,  'catch_up_until' => 12, 'group' => 'Bayi 2 bulan'],
        ['code' => 'dpt_hb_hib_2',            'name' => 'DPT-HB-Hib 2',                  'recommended_age' => 3,  'catch_up_until' => 12, 'group' => 'Bayi 3 bulan'],
        ['code' => 'polio_3',                 'name' => 'Polio Tetes 3',                 'recommended_age' => 3,  'catch_up_until' => 12, 'group' => 'Bayi 3 bulan'],
        ['code' => 'rotavirus_2',             'name' => 'Rotavirus 2',                   'recommended_age' => 3,  'catch_up_until' => 6,  'group' => 'Bayi 3 bulan'],
        ['code' => 'pcv_2',                   'name' => 'PCV 2',                         'recommended_age' => 3,  'catch_up_until' => 12, 'group' => 'Bayi 3 bulan'],
        ['code' => 'dpt_hb_hib_3',            'name' => 'DPT-HB-Hib 3',                  'recommended_age' => 4,  'catch_up_until' => 12, 'group' => 'Bayi 4 bulan'],
        ['code' => 'polio_4',                 'name' => 'Polio Tetes 4',                 'recommended_age' => 4,  'catch_up_until' => 12, 'group' => 'Bayi 4 bulan'],
        ['code' => 'ipv_1',                   'name' => 'Polio Suntik (IPV) 1',          'recommended_age' => 4,  'catch_up_until' => 12, 'group' => 'Bayi 4 bulan'],
        ['code' => 'rotavirus_3',             'name' => 'Rotavirus 3',                   'recommended_age' => 4,  'catch_up_until' => 6,  'group' => 'Bayi 4 bulan'],
        ['code' => 'campak_rubella',          'name' => 'Campak-Rubella (MR)',           'recommended_age' => 9,  'catch_up_until' => 18, 'group' => 'Bayi 9 bulan'],
        ['code' => 'ipv_2',                   'name' => 'Polio Suntik (IPV) 2',          'recommended_age' => 9,  'catch_up_until' => 18, 'group' => 'Bayi 9 bulan'],
        ['code' => 'je',                      'name' => 'Japanese Encephalitis (JE)',    'recommended_age' => 10, 'catch_up_until' => 36, 'group' => 'Bayi 10 bulan (provinsi tertentu)'],
        ['code' => 'pcv_3',                   'name' => 'PCV 3',                         'recommended_age' => 12, 'catch_up_until' => 24, 'group' => 'Baduta 12 bulan'],
        ['code' => 'dpt_hb_hib_lanjutan',     'name' => 'DPT-HB-Hib Lanjutan',           'recommended_age' => 18, 'catch_up_until' => 36, 'group' => 'Baduta 18 bulan'],
        ['code' => 'campak_rubella_lanjutan', 'name' => 'Campak-Rubella (MR) Lanjutan',  'recommended_age' => 18, 'catch_up_until' => 36, 'group' => 'Baduta 18 bulan'],
    ];

    public function schedule()
    {
        if (!$this->canRead()) {
            return response()->json(['message' => 'Tidak memiliki akses untuk melihat jadwal imunisasi.'], 403);
        }
        return response()->json(['data' => self::SCHEDULE]);
    }

    /**
     * Daftar imunisasi untuk anak tertentu: master schedule + status pemberian.
     */
    public function indexForChild(Request $request, $childId)
    {
        if (!$this->canRead()) {
            return response()->json(['message' => 'Tidak memiliki akses untuk melihat data imunisasi.'], 403);
        }
        $child = $this->resolveChild($childId);
        if (!$child) {
            return response()->json(['message' => 'Anak tidak ditemukan atau tidak memiliki akses.'], 404);
        }

        $given = ChildVaccination::where('child_id', $child->id)
            ->orderBy('given_date')
            ->get()
            ->groupBy('vaccine_code');

        $ageMonths = $this->ageInMonths($child->date_of_birth);

        $items = collect(self::SCHEDULE)->map(function ($vac) use ($given, $ageMonths) {
            $records = $given->get($vac['code'], collect());
            $isGiven = $records->isNotEmpty();
            $latest  = $isGiven ? $records->first() : null;

            // Status: given / due / overdue / upcoming
            $status = 'upcoming';
            if ($isGiven) {
                $status = 'given';
            } elseif ($ageMonths > $vac['catch_up_until']) {
                $status = 'overdue';
            } elseif ($ageMonths >= $vac['recommended_age']) {
                $status = 'due';
            }

            return array_merge($vac, [
                'status'     => $status,
                'given_date' => $latest?->given_date?->toDateString(),
                'batch_no'   => $latest?->batch_no,
                'notes'      => $latest?->notes,
                'record_id'  => $latest?->id,
            ]);
        })->values();

        return response()->json([
            'data' => [
                'child' => [
                    'id'            => $child->id,
                    'name'          => $child->name,
                    'gender'        => $child->gender,
                    'date_of_birth' => $child->date_of_birth?->toDateString(),
                    'age_months'    => $ageMonths,
                ],
                'items'   => $items,
                'summary' => [
                    'total'    => count(self::SCHEDULE),
                    'given'    => $items->where('status', 'given')->count(),
                    'due'      => $items->where('status', 'due')->count(),
                    'overdue'  => $items->where('status', 'overdue')->count(),
                    'upcoming' => $items->where('status', 'upcoming')->count(),
                ],
            ],
        ]);
    }

    public function record(Request $request, $childId)
    {
        if (!$this->canCreate()) {
            return response()->json(['message' => 'Tidak memiliki akses untuk mencatat imunisasi.'], 403);
        }
        $child = $this->resolveChild($childId);
        if (!$child) {
            return response()->json(['message' => 'Anak tidak ditemukan atau tidak memiliki akses.'], 404);
        }

        $request->validate([
            'vaccine_code' => 'required|string|in:' . collect(self::SCHEDULE)->pluck('code')->implode(','),
            'given_date'   => 'required|date|before_or_equal:today',
            'batch_no'     => 'nullable|string|max:50',
            'notes'        => 'nullable|string',
        ]);

        $rec = ChildVaccination::create([
            'child_id'     => $child->id,
            'vaccine_code' => $request->vaccine_code,
            'given_date'   => $request->given_date,
            'batch_no'     => $request->batch_no,
            'given_by'     => Auth::id(),
            'notes'        => $request->notes,
        ]);

        return response()->json(['data' => $rec], 201);
    }

    public function destroy($childId, $recordId)
    {
        if (!$this->canDelete()) {
            return response()->json(['message' => 'Tidak memiliki akses untuk menghapus catatan imunisasi.'], 403);
        }
        $child = $this->resolveChild($childId);
        if (!$child) {
            return response()->json(['message' => 'Anak tidak ditemukan atau tidak memiliki akses.'], 404);
        }

        $rec = ChildVaccination::where('child_id', $child->id)->findOrFail($recordId);
        $rec->delete();
        return response()->json(['message' => 'Catatan imunisasi dihapus.']);
    }

    private function canRead(): bool
    {
        $user = Auth::user();
        if (!$user) return false;
        return $user->isSuperAdmin() || $user->hasRole('admin') || $user->isAbleTo('vaccinations-read');
    }

    private function canCreate(): bool
    {
        $user = Auth::user();
        if (!$user) return false;
        return $user->isSuperAdmin() || $user->isAbleTo('vaccinations-create');
    }

    private function canDelete(): bool
    {
        $user = Auth::user();
        if (!$user) return false;
        return $user->isSuperAdmin() || $user->isAbleTo('vaccinations-delete');
    }

    private function resolveChild($childId): ?Child
    {
        $user = Auth::user();
        $query = Child::query();

        // Admin/dokter/health_worker boleh akses semua, parent hanya anaknya
        if (!$user || !$user->hasRole(['admin', 'superadmin', 'dokter', 'health_worker'])) {
            $query->where('user_id', Auth::id());
        }

        return $query->find($childId);
    }

    private function ageInMonths($dob): int
    {
        if (!$dob) return 0;
        return (int) Carbon::parse($dob)->diffInMonths(Carbon::now());
    }
}
