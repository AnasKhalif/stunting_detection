<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Child;
use App\Models\StuntingResult;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StuntingController extends Controller
{
    // WHO Height-for-Age Z-score reference (TB/U) — SD values per month
    // [month => [SD3neg, SD2neg, SD1neg, median, SD1, SD2, SD3]]
    private const WHO_HFA_BOYS = [
        0  => [44.2, 46.1, 48.0, 49.9, 51.8, 53.7, 55.6],
        1  => [48.9, 50.8, 52.8, 54.7, 56.7, 58.6, 60.6],
        2  => [52.4, 54.4, 56.4, 58.4, 60.4, 62.4, 64.4],
        3  => [55.3, 57.3, 59.4, 61.4, 63.5, 65.5, 67.6],
        4  => [57.6, 59.7, 61.8, 63.9, 66.0, 68.0, 70.1],
        5  => [59.6, 61.7, 63.8, 65.9, 68.0, 70.1, 72.2],
        6  => [61.2, 63.3, 65.5, 67.6, 69.8, 71.9, 74.0],
        7  => [62.7, 64.8, 67.0, 69.2, 71.3, 73.5, 75.7],
        8  => [64.0, 66.2, 68.4, 70.6, 72.8, 75.0, 77.2],
        9  => [65.2, 67.5, 69.7, 72.0, 74.2, 76.5, 78.7],
        10 => [66.4, 68.7, 71.0, 73.3, 75.6, 77.9, 80.2],
        11 => [67.6, 69.9, 72.2, 74.5, 76.9, 79.2, 81.5],
        12 => [68.6, 71.0, 73.4, 75.7, 78.1, 80.5, 82.9],
        13 => [69.6, 72.1, 74.5, 76.9, 79.3, 81.8, 84.2],
        14 => [70.6, 73.1, 75.6, 78.0, 80.5, 83.0, 85.5],
        15 => [71.6, 74.1, 76.6, 79.1, 81.7, 84.2, 86.7],
        16 => [72.5, 75.0, 77.6, 80.2, 82.8, 85.4, 88.0],
        17 => [73.3, 76.0, 78.6, 81.2, 83.9, 86.5, 89.2],
        18 => [74.2, 76.9, 79.6, 82.3, 85.0, 87.7, 90.4],
        19 => [75.0, 77.7, 80.5, 83.2, 86.0, 88.8, 91.5],
        20 => [75.8, 78.6, 81.4, 84.2, 87.0, 89.8, 92.6],
        21 => [76.5, 79.4, 82.3, 85.1, 88.0, 90.9, 93.8],
        22 => [77.2, 80.2, 83.1, 86.0, 89.0, 91.9, 94.9],
        23 => [78.0, 81.0, 83.9, 86.9, 89.9, 92.9, 95.9],
        24 => [78.7, 81.7, 84.8, 87.8, 90.9, 93.9, 97.0],
        25 => [79.4, 82.5, 85.6, 88.7, 91.8, 94.9, 98.0],
        26 => [80.2, 83.3, 86.4, 89.6, 92.7, 95.8, 99.0],
        27 => [80.9, 84.0, 87.2, 90.4, 93.6, 96.8, 100.0],
        28 => [81.5, 84.8, 88.0, 91.2, 94.5, 97.7, 101.0],
        29 => [82.2, 85.5, 88.7, 92.0, 95.3, 98.6, 101.9],
        30 => [82.8, 86.1, 89.5, 92.8, 96.1, 99.5, 102.8],
        31 => [83.5, 86.9, 90.2, 93.6, 97.0, 100.3, 103.7],
        32 => [84.1, 87.5, 90.9, 94.4, 97.8, 101.2, 104.6],
        33 => [84.7, 88.2, 91.6, 95.1, 98.6, 102.0, 105.5],
        34 => [85.3, 88.8, 92.3, 95.9, 99.4, 102.9, 106.4],
        35 => [85.9, 89.4, 93.0, 96.6, 100.1, 103.7, 107.3],
        36 => [86.5, 90.1, 93.7, 97.3, 100.9, 104.5, 108.1],
        37 => [87.1, 90.7, 94.4, 98.0, 101.7, 105.3, 109.0],
        38 => [87.7, 91.3, 95.0, 98.7, 102.4, 106.1, 109.8],
        39 => [88.2, 91.9, 95.7, 99.4, 103.1, 106.9, 110.6],
        40 => [88.8, 92.5, 96.3, 100.1, 103.8, 107.6, 111.4],
        41 => [89.3, 93.1, 96.9, 100.8, 104.6, 108.4, 112.2],
        42 => [89.8, 93.7, 97.6, 101.4, 105.3, 109.2, 113.0],
        43 => [90.4, 94.3, 98.2, 102.1, 106.0, 109.9, 113.8],
        44 => [90.9, 94.8, 98.8, 102.7, 106.7, 110.7, 114.6],
        45 => [91.4, 95.4, 99.4, 103.4, 107.4, 111.4, 115.4],
        46 => [91.9, 95.9, 100.0, 104.0, 108.1, 112.1, 116.2],
        47 => [92.4, 96.5, 100.6, 104.6, 108.7, 112.8, 116.9],
        48 => [92.9, 97.0, 101.1, 105.3, 109.4, 113.5, 117.7],
        49 => [93.4, 97.5, 101.7, 105.9, 110.1, 114.2, 118.4],
        50 => [93.9, 98.1, 102.3, 106.5, 110.7, 114.9, 119.2],
        51 => [94.4, 98.6, 102.8, 107.1, 111.3, 115.6, 119.9],
        52 => [94.9, 99.1, 103.4, 107.7, 112.0, 116.3, 120.6],
        53 => [95.3, 99.6, 103.9, 108.3, 112.6, 117.0, 121.3],
        54 => [95.8, 100.1, 104.5, 108.8, 113.2, 117.6, 122.0],
        55 => [96.3, 100.6, 105.0, 109.4, 113.8, 118.3, 122.7],
        56 => [96.7, 101.1, 105.6, 110.0, 114.5, 118.9, 123.4],
        57 => [97.2, 101.6, 106.1, 110.6, 115.1, 119.6, 124.1],
        58 => [97.7, 102.1, 106.6, 111.2, 115.7, 120.2, 124.8],
        59 => [98.1, 102.6, 107.2, 111.7, 116.3, 120.8, 125.4],
        60 => [98.6, 103.1, 107.7, 112.3, 116.9, 121.5, 126.1],
    ];

    private const WHO_HFA_GIRLS = [
        0  => [43.6, 45.4, 47.3, 49.1, 51.0, 52.9, 54.7],
        1  => [47.8, 49.8, 51.7, 53.7, 55.6, 57.6, 59.5],
        2  => [51.0, 53.0, 55.0, 57.1, 59.1, 61.1, 63.2],
        3  => [53.5, 55.6, 57.7, 59.8, 61.9, 64.0, 66.1],
        4  => [55.6, 57.8, 59.9, 62.1, 64.3, 66.4, 68.6],
        5  => [57.4, 59.6, 61.8, 64.0, 66.2, 68.5, 70.7],
        6  => [58.9, 61.2, 63.5, 65.7, 68.0, 70.3, 72.5],
        7  => [60.3, 62.7, 65.0, 67.3, 69.6, 71.9, 74.2],
        8  => [61.7, 64.0, 66.4, 68.7, 71.1, 73.5, 75.8],
        9  => [62.9, 65.3, 67.7, 70.1, 72.6, 75.0, 77.4],
        10 => [64.1, 66.5, 69.0, 71.5, 73.9, 76.4, 78.9],
        11 => [65.2, 67.7, 70.3, 72.8, 75.3, 77.8, 80.3],
        12 => [66.3, 68.9, 71.4, 74.0, 76.6, 79.2, 81.7],
        13 => [67.3, 70.0, 72.6, 75.2, 77.8, 80.5, 83.1],
        14 => [68.3, 71.0, 73.7, 76.4, 79.1, 81.7, 84.4],
        15 => [69.3, 72.0, 74.8, 77.5, 80.3, 83.0, 85.7],
        16 => [70.2, 73.0, 75.8, 78.6, 81.4, 84.2, 87.0],
        17 => [71.1, 74.0, 76.8, 79.7, 82.5, 85.4, 88.2],
        18 => [72.0, 74.9, 77.8, 80.7, 83.6, 86.5, 89.4],
        19 => [72.8, 75.8, 78.8, 81.7, 84.7, 87.6, 90.6],
        20 => [73.7, 76.7, 79.7, 82.7, 85.7, 88.7, 91.7],
        21 => [74.5, 77.5, 80.6, 83.7, 86.7, 89.8, 92.9],
        22 => [75.2, 78.4, 81.5, 84.6, 87.7, 90.8, 94.0],
        23 => [76.0, 79.2, 82.3, 85.5, 88.7, 91.9, 95.0],
        24 => [76.7, 80.0, 83.2, 86.4, 89.6, 92.9, 96.1],
        25 => [77.5, 80.8, 84.0, 87.3, 90.6, 93.9, 97.1],
        26 => [78.2, 81.5, 84.9, 88.2, 91.5, 94.8, 98.2],
        27 => [78.9, 82.3, 85.7, 89.0, 92.4, 95.8, 99.2],
        28 => [79.6, 83.0, 86.4, 89.9, 93.3, 96.7, 100.1],
        29 => [80.3, 83.7, 87.2, 90.7, 94.2, 97.7, 101.1],
        30 => [80.9, 84.5, 88.0, 91.5, 95.0, 98.6, 102.1],
        31 => [81.6, 85.2, 88.7, 92.3, 95.9, 99.4, 103.0],
        32 => [82.2, 85.8, 89.4, 93.1, 96.7, 100.3, 103.9],
        33 => [82.8, 86.5, 90.2, 93.8, 97.5, 101.2, 104.8],
        34 => [83.4, 87.1, 90.9, 94.6, 98.3, 102.0, 105.8],
        35 => [84.0, 87.8, 91.5, 95.3, 99.1, 102.9, 106.7],
        36 => [84.6, 88.4, 92.2, 96.1, 99.9, 103.7, 107.5],
        37 => [85.2, 89.0, 92.9, 96.8, 100.6, 104.5, 108.4],
        38 => [85.7, 89.6, 93.6, 97.5, 101.4, 105.3, 109.3],
        39 => [86.3, 90.2, 94.2, 98.2, 102.2, 106.1, 110.1],
        40 => [86.8, 90.8, 94.8, 98.9, 102.9, 106.9, 111.0],
        41 => [87.4, 91.4, 95.5, 99.5, 103.6, 107.7, 111.8],
        42 => [87.9, 92.0, 96.1, 100.2, 104.3, 108.5, 112.6],
        43 => [88.4, 92.6, 96.7, 100.9, 105.0, 109.2, 113.4],
        44 => [89.0, 93.1, 97.3, 101.5, 105.8, 110.0, 114.2],
        45 => [89.5, 93.7, 97.9, 102.2, 106.5, 110.7, 115.0],
        46 => [90.0, 94.2, 98.5, 102.8, 107.2, 111.5, 115.8],
        47 => [90.5, 94.8, 99.1, 103.5, 107.8, 112.2, 116.6],
        48 => [91.0, 95.3, 99.7, 104.1, 108.5, 112.9, 117.3],
        49 => [91.5, 95.9, 100.3, 104.7, 109.2, 113.6, 118.1],
        50 => [92.0, 96.4, 100.9, 105.3, 109.8, 114.3, 118.8],
        51 => [92.5, 96.9, 101.4, 105.9, 110.5, 115.0, 119.5],
        52 => [93.0, 97.4, 102.0, 106.5, 111.1, 115.7, 120.3],
        53 => [93.4, 97.9, 102.5, 107.1, 111.8, 116.4, 121.0],
        54 => [93.9, 98.5, 103.1, 107.7, 112.4, 117.0, 121.7],
        55 => [94.4, 99.0, 103.6, 108.3, 113.0, 117.7, 122.4],
        56 => [94.9, 99.5, 104.2, 108.9, 113.6, 118.3, 123.1],
        57 => [95.3, 100.0, 104.7, 109.5, 114.2, 119.0, 123.7],
        58 => [95.8, 100.5, 105.3, 110.1, 114.9, 119.6, 124.4],
        59 => [96.3, 101.1, 105.8, 110.7, 115.5, 120.3, 125.1],
        60 => [96.7, 101.6, 106.4, 111.2, 116.1, 120.9, 125.8],
    ];

    public function detect(Request $request)
    {
        $request->validate([
            'child_id'         => 'required|exists:children,id',
            'height'           => 'required|numeric|min:30|max:150',
            'weight'           => 'nullable|numeric|min:1|max:50',
            'measurement_date' => 'required|date',
        ]);

        $child = Child::where('user_id', Auth::id())->findOrFail($request->child_id);

        $ageMonths = (int) \Carbon\Carbon::parse($request->measurement_date)
            ->diffInMonths(\Carbon\Carbon::parse($child->date_of_birth));

        $ageMonths = max(0, min(60, $ageMonths));

        // Call Flask ML API
        $genderNumeric = $child->gender === 'laki-laki' ? 0 : 1;
        $predictionResult = $this->callFlaskPredict($genderNumeric, $ageMonths, $request->height);

        // Calculate Z-score TB/U
        $zScore = $this->calculateZScore($child->gender, $ageMonths, (float) $request->height);
        $whoRef  = $this->getWhoReference($child->gender, $ageMonths);

        $stuntingResult = StuntingResult::create([
            'user_id'          => Auth::id(),
            'child_id'         => $child->id,
            'gender'           => $child->gender,
            'age'              => $ageMonths,
            'height'           => $request->height,
            'weight'           => $request->weight,
            'measurement_date' => $request->measurement_date,
            'z_score'          => $zScore,
            'prediction_result'=> $predictionResult,
            'who_standard_ref' => json_encode($whoRef),
            'notes'            => $request->notes,
        ]);

        $advice = $this->getAdvice($predictionResult, $ageMonths);
        $foods  = $this->getFoodSuggestions($predictionResult, $ageMonths);

        return response()->json([
            'data' => [
                'result'      => $this->transformResult($stuntingResult),
                'child'       => ['id' => $child->id, 'name' => $child->name, 'gender' => $child->gender],
                'age_months'  => $ageMonths,
                'z_score'     => round($zScore, 3),
                'who_ref'     => $whoRef,
                'advice'      => $advice,
                'foods'       => $foods,
            ],
        ], 201);
    }

    public function history(Request $request)
    {
        $query = StuntingResult::where('user_id', Auth::id())
            ->with('child:id,name,gender')
            ->latest('measurement_date');

        if ($request->filled('child_id')) {
            $query->where('child_id', $request->child_id);
        }

        $results = $query->get()->map(fn($r) => $this->transformResult($r));

        return response()->json(['data' => $results]);
    }

    public function show($id)
    {
        $result = StuntingResult::where('user_id', Auth::id())
            ->with('child:id,name,gender,date_of_birth')
            ->findOrFail($id);

        $advice = $this->getAdvice($result->prediction_result, (int) $result->age);
        $foods  = $this->getFoodSuggestions($result->prediction_result, (int) $result->age);
        $whoRef = $result->who_standard_ref ? json_decode($result->who_standard_ref, true) : null;

        return response()->json([
            'data' => array_merge($this->transformResult($result), [
                'advice'  => $advice,
                'foods'   => $foods,
                'who_ref' => $whoRef,
            ])
        ]);
    }

    private function callFlaskPredict(int $gender, int $age, float $height): string
    {
        try {
            $client   = new Client(['timeout' => 10]);
            $response = $client->post(env('ML_API_URL', 'http://127.0.0.1:5000') . '/predict', [
                'json' => [
                    'Jenis Kelamin'     => $gender,
                    'Umur (bulan)'      => (float) $age,
                    'Tinggi Badan (cm)' => $height,
                ],
            ]);
            $data = json_decode($response->getBody(), true);
            return $data['stunting_status'] ?? 'normal';
        } catch (\Exception $e) {
            // Fallback ke z-score jika Flask tidak tersedia
            return 'normal';
        }
    }

    private function calculateZScore(string $gender, int $ageMonths, float $height): float
    {
        $table = $gender === 'laki-laki' ? self::WHO_HFA_BOYS : self::WHO_HFA_GIRLS;
        if (!isset($table[$ageMonths])) return 0;

        [$sd3n, $sd2n, $sd1n, $median, $sd1, $sd2, $sd3] = $table[$ageMonths];

        if ($height >= $median) {
            $sd = ($sd1 - $median);
            return $sd > 0 ? ($height - $median) / $sd : 0;
        } else {
            $sd = ($median - $sd1n);
            return $sd > 0 ? ($height - $median) / $sd : 0;
        }
    }

    private function getWhoReference(string $gender, int $ageMonths): array
    {
        $table = $gender === 'laki-laki' ? self::WHO_HFA_BOYS : self::WHO_HFA_GIRLS;
        if (!isset($table[$ageMonths])) return [];

        [$sd3n, $sd2n, $sd1n, $median, $sd1, $sd2, $sd3] = $table[$ageMonths];
        return [
            'SD3neg' => $sd3n,
            'SD2neg' => $sd2n,
            'SD1neg' => $sd1n,
            'median' => $median,
            'SD1'    => $sd1,
            'SD2'    => $sd2,
            'SD3'    => $sd3,
        ];
    }

    /**
     * Saran tindakan berdasarkan status TB/U dari Buku Bagan SDIDTK Kemenkes 2022 (hal. 11)
     * dan Asuhan Nutrisi Pediatrik (hal. 96-97), dengan stimulasi per kelompok usia (hal. 17-95).
     */
    private function getAdvice(string $status, int $ageMonths): array
    {
        // Stimulasi tumbuh kembang per kelompok usia — SDIDTK Kemenkes 2022
        $stimulasi = $this->getStimulasi($ageMonths);

        $baseSteps = [
            'severely stunted' => [
                'Segera bawa anak ke RS untuk mendapat penanganan dokter spesialis anak.',
                'Konfirmasi parameter status gizi lain: BB/U, BB/PB atau BB/TB, MTBS, SDIDTK, dan Buku KIA.',
                'Lakukan asuhan nutrisi pediatrik: assessment, penentuan kebutuhan kalori berdasarkan berat badan ideal dikalikan RDA menurut umur tinggi (height age).',
                'Bentuk makanan disesuaikan dengan umur: 0–6 bulan (ASI/susu formula), 6 bulan–1 tahun (ASI + MP-ASI), 1–2 tahun (makanan keluarga + ASI/formula), di atas 2 tahun (makanan keluarga).',
                'Tatalaksana gizi buruk mengikuti pedoman pencegahan dan tatalaksana gizi buruk Kemenkes dan guideline WHO (fase stabilisasi, transisi, rehabilitasi, dan tindak lanjut).',
                'Lakukan pemantauan dan evaluasi: akseptabilitas, toleransi (reaksi simpang makanan), dan efektivitas. Evaluasi kenaikan BB dalam 2 minggu.',
                'Jadwalkan kunjungan kontrol untuk memantau perkembangan pertumbuhan.',
            ],
            'stunted' => [
                $ageMonths < 24
                    ? 'Untuk anak umur < 2 tahun: Segera rujuk ke RS.'
                    : 'Konfirmasi parameter status gizi lain (BB/U, BB/PB atau BB/TB), MTBS, SDIDTK, Buku KIA, dan KPSP.',
                'Jika terdapat masalah (indikator antropometri tidak sesuai, masalah perkembangan, infeksi, tidak ada perbaikan setelah penatalaksanaan gizi standar, kecurigaan masalah hormonal), segera rujuk ke RS.',
                'Lakukan asuhan nutrisi pediatrik: tentukan kebutuhan kalori berdasarkan berat badan ideal dikalikan RDA menurut umur tinggi (height age).',
                'Bentuk makanan disesuaikan umur: 6–8 bulan (bubur kental/lumat, 2–3x/hari), 9–11 bulan (makanan cincang halus, 3–4x/hari), 12–23 bulan (makanan keluarga, 3–4x/hari).',
                'Terapkan feeding rules: jadwal makan teratur 3 kali makan utama + 2 kali snack, waktu makan maks 30 menit, tidak memaksa anak.',
                'Evaluasi dan pemantauan setelah 2 minggu. Bila tidak ada perbaikan, segera rujuk ke fasyankes yang lebih tinggi.',
            ],
            'normal' => [
                'Jadwalkan kunjungan pemantauan pertumbuhan berikutnya.',
                'Lanjutkan pola makan bergizi seimbang: makanan pokok, lauk hewani dan nabati, sayuran, dan buah-buahan.',
                'Terapkan feeding rules: jadwal makan teratur, lingkungan menyenangkan tanpa paksaan, tanpa distraksi (TV/gadget) saat makan.',
                'Pastikan anak mendapat imunisasi lengkap sesuai jadwal.',
                'Pantau tren pertumbuhan menggunakan grafik pertumbuhan di Buku KIA setiap bulan.',
            ],
            'tinggi' => [
                'Jadwalkan kunjungan pemantauan pertumbuhan berikutnya.',
                'Lanjutkan pola makan bergizi seimbang sesuai kelompok umur: makanan pokok, lauk hewani dan nabati, sayuran, dan buah-buahan.',
                'Terapkan feeding rules: jadwal makan teratur 3 kali makan utama + 2 kali snack, waktu makan maks 30 menit, lingkungan menyenangkan tanpa paksaan.',
                'Dukung aktivitas fisik yang sesuai usia untuk pertumbuhan tulang dan otot yang optimal.',
                'Pantau tren pertumbuhan menggunakan grafik di Buku KIA setiap bulan.',
                'Jika tinggi badan sangat jauh di atas rata-rata (>+3 SD), konsultasikan dengan dokter untuk memastikan tidak ada kondisi medis yang mendasari.',
            ],
        ];

        $steps = $baseSteps[$status] ?? $baseSteps['normal'];

        $labels = [
            'severely stunted' => 'Sangat Pendek (Severely Stunted)',
            'stunted'          => 'Pendek (Stunted)',
            'normal'           => 'Normal',
            'tinggi'           => 'Tinggi',
        ];
        $messages = [
            'severely stunted' => 'Tinggi badan anak berada di bawah -3 SD. Anak mengalami sangat pendek (severely stunted). Segera rujuk ke RS untuk mendapat penanganan dokter spesialis anak.',
            'stunted'          => 'Tinggi badan anak berada di antara -3 SD hingga < -2 SD. Anak mengalami pendek (stunted). Diperlukan intervensi gizi dan pemantauan ketat.',
            'normal'           => 'Tinggi badan anak berada dalam rentang normal (-2 SD hingga +3 SD). Pertahankan pola makan bergizi dan pemantauan rutin.',
            'tinggi'           => 'Tinggi badan anak berada di atas rata-rata. Ini umumnya merupakan kondisi yang positif. Tetap lakukan pemantauan rutin untuk memastikan pertumbuhan berlangsung sehat.',
        ];
        $colors = [
            'severely stunted' => 'red',
            'stunted'          => 'orange',
            'normal'           => 'green',
            'tinggi'           => 'blue',
        ];

        return [
            'label'     => $labels[$status]   ?? 'Normal',
            'color'     => $colors[$status]   ?? 'green',
            'message'   => $messages[$status] ?? $messages['normal'],
            'steps'     => $steps,
            'stimulasi' => $stimulasi,
        ];
    }

    /**
     * Stimulasi tumbuh kembang per kelompok usia.
     * Sumber: Buku Bagan SDIDTK Kemenkes 2022 — Tabel 3 Intervensi Dini (hal. 17–95)
     * Meliputi: Motorik Kasar, Motorik Halus, Bicara & Bahasa, Sosialisasi & Kemandirian.
     */
    private function getStimulasi(int $ageMonths): array
    {
        if ($ageMonths <= 2) {
            // 0–2 bulan
            return [
                'Stimulasi motorik kasar: Letakkan bayi tengkurap sesaat setelah minum, angkat kepala bayi saat digendong posisi tegak.',
                'Stimulasi motorik halus: Letakkan jari atau benda di telapak tangan bayi agar ia menggenggam.',
                'Stimulasi bicara & bahasa: Ajak bicara, tersenyum, dan buat kontak mata sesering mungkin. Perdengarkan suara lembut dan musik.',
                'Stimulasi sosial: Gendong, peluk, dan usap bayi dengan penuh kasih sayang agar merasa aman dan nyaman.',
            ];
        } elseif ($ageMonths <= 5) {
            // 3–5 bulan
            return [
                'Stimulasi motorik kasar: Latih bayi tengkurap lebih lama, bantu bayi berguling, topang badan saat didudukkan.',
                'Stimulasi motorik halus: Gantungkan mainan berwarna cerah agar bayi meraih dan memegang.',
                'Stimulasi bicara & bahasa: Tirukan suara yang dibuat bayi, ajak berbicara saat menyusui dan merawat.',
                'Stimulasi sosial: Perkenalkan wajah anggota keluarga, buat bayi tertawa dengan ekspresi wajah dan suara lucu.',
            ];
        } elseif ($ageMonths <= 8) {
            // 6–8 bulan
            return [
                'Stimulasi motorik kasar: Latih bayi duduk mandiri dengan ditopang, bantu bayi merangkak dengan meletakkan mainan di depannya.',
                'Stimulasi motorik halus: Berikan mainan yang bisa dipindahkan dari satu tangan ke tangan lain, benda kecil aman untuk digenggam.',
                'Stimulasi bicara & bahasa: Panggil nama bayi, ajari kata-kata sederhana (mama, papa), bacakan buku bergambar.',
                'Stimulasi sosial: Ajak bermain cilukba, perkenalkan bayi pada orang lain secara bertahap untuk mengurangi cemas perpisahan.',
            ];
        } elseif ($ageMonths <= 11) {
            // 9–11 bulan
            return [
                'Stimulasi motorik kasar: Latih bayi berdiri berpegangan, beri ruang aman untuk merangkak dan merambat.',
                'Stimulasi motorik halus: Ajari bayi memungut benda kecil dengan dua jari (pincer grasp), bermain menumpuk balok.',
                'Stimulasi bicara & bahasa: Ajari kata "tidak", namakan benda sehari-hari, dan minta bayi menunjuk gambar di buku.',
                'Stimulasi sosial: Ajari bayi melambaikan tangan dan bertepuk tangan, bermain permainan sederhana bersama.',
            ];
        } elseif ($ageMonths <= 17) {
            // 12–17 bulan
            return [
                'Stimulasi motorik kasar: Beri dukungan saat anak belajar berjalan, ajak bermain bola guling, latih naik turun tangga dengan pegangan.',
                'Stimulasi motorik halus: Ajari memegang krayon/pensil, bermain tumpuk balok 2–3 buah, masukkan benda ke dalam wadah.',
                'Stimulasi bicara & bahasa: Perkaya kosakata dengan menamai benda di sekitar, bacakan buku cerita bergambar setiap hari.',
                'Stimulasi sosial: Ajari anak makan sendiri dengan sendok, meniru kegiatan rumah tangga sederhana (menyapu, menaruh baju).',
            ];
        } elseif ($ageMonths <= 23) {
            // 18–23 bulan
            return [
                'Stimulasi motorik kasar: Ajak berlari, melompat, dan bermain lempar tangkap bola. Latih menendang bola ke depan.',
                'Stimulasi motorik halus: Ajari menggambar garis lurus, menyusun puzzle sederhana, dan membuka halaman buku.',
                'Stimulasi bicara & bahasa: Dorong anak berbicara dalam kalimat 2 kata, ajukan pertanyaan sederhana, dengarkan dengan sabar.',
                'Stimulasi sosial: Ajari anak melepas pakaian sendiri, bermain bersama anak lain, dan membantu pekerjaan rumah ringan.',
            ];
        } elseif ($ageMonths <= 35) {
            // 24–35 bulan
            return [
                'Stimulasi motorik kasar: Ajak berlari, melompat dengan dua kaki, bersepeda roda tiga, dan memanjat tangga.',
                'Stimulasi motorik halus: Ajari menggambar lingkaran, menggunting garis lurus, menyusun 6 buah balok.',
                'Stimulasi bicara & bahasa: Latih anak berbicara kalimat 3–4 kata, ajak berdiskusi tentang gambar di buku, ceritakan dongeng.',
                'Stimulasi sosial: Ajarkan berbagi mainan, bermain peran (masak-masakan, dokter-dokteran), dan konsep malu/maaf.',
            ];
        } elseif ($ageMonths <= 47) {
            // 36–47 bulan
            return [
                'Stimulasi motorik kasar: Ajak melompat dengan satu kaki, berdiri di atas satu kaki, bermain lempar tangkap bola kecil.',
                'Stimulasi motorik halus: Ajari menggambar orang dengan 3 bagian tubuh, menggunting pola sederhana, mewarnai gambar.',
                'Stimulasi bicara & bahasa: Ajak bercakap-cakap tentang kejadian sehari-hari, kenalkan huruf dan angka secara menyenangkan.',
                'Stimulasi sosial: Ajari anak berpakaian sendiri, gosok gigi dengan pantauan, bermain kooperatif dengan teman sebaya.',
            ];
        } elseif ($ageMonths <= 59) {
            // 48–59 bulan
            return [
                'Stimulasi motorik kasar: Ajak bersepeda, bermain lompat tali, berlatih keseimbangan di balok titian.',
                'Stimulasi motorik halus: Ajari menulis nama, menggambar orang lengkap, membuat origami sederhana.',
                'Stimulasi bicara & bahasa: Ajak bercerita tentang pengalaman, kenalkan konsep baca-tulis awal, ajari lagu dan puisi.',
                'Stimulasi sosial: Ajari anak bergantian dan antri, menyelesaikan konflik dengan kata-kata, memahami aturan permainan.',
            ];
        } else {
            // 60–72 bulan
            return [
                'Stimulasi motorik kasar: Ajak olahraga rutin (lari, berenang, bersepeda), latih koordinasi mata-tangan melalui permainan.',
                'Stimulasi motorik halus: Latih menulis dan menggambar dengan detail, membuat kerajinan tangan sederhana.',
                'Stimulasi bicara & bahasa: Dorong anak membaca buku bergambar sendiri, bercerita ulang isi cerita, belajar konsep angka dan huruf.',
                'Stimulasi sosial: Ajarkan tanggung jawab ringan di rumah, bermain dalam kelompok, mengenal konsep benar-salah dan empati.',
            ];
        }
    }

    /**
     * Saran makanan berdasarkan status dan usia.
     * Sumber: Buku Bagan SDIDTK Kemenkes 2022 — Lampiran (hal. 131–148):
     * - Tabel Pemberian Makan Bayi & Anak (hal. 131)
     * - Tabel Standar Menu MP-ASI (hal. 133)
     * - Tabel Menu Makanan Selingan (hal. 134)
     * - Tabel Protein Hewani (hal. 136–137)
     * - Tabel Protein Nabati (hal. 138)
     * - Tabel Sayuran (hal. 139)
     * - Tabel Buah-buahan (hal. 147)
     */
    private function getFoodSuggestions(string $status, int $ageMonths): array
    {
        // Makanan dasar per kelompok usia (semua status)
        if ($ageMonths < 6) {
            // 0–5 bulan: ASI eksklusif
            $base = [
                ['name' => 'ASI Eksklusif', 'benefit' => 'Sumber nutrisi utama bayi 0–6 bulan. Berikan setiap 2–3 jam atau sesuai permintaan bayi.', 'icon' => 'milk'],
                ['name' => 'Susu Formula (jika ASI tidak mencukupi)', 'benefit' => 'Alternatif jika ASI tidak tersedia. Konsultasikan dengan tenaga kesehatan.', 'icon' => 'milk'],
            ];
        } elseif ($ageMonths < 9) {
            // 6–8 bulan: ASI + MP-ASI awal (bubur kental/lumat, 2–3x/hari, 2–3 sdm → ½ mangkok 125 ml, 200 kkal/hari)
            $base = [
                ['name' => 'ASI', 'benefit' => 'Tetap berikan ASI sebagai sumber nutrisi utama.', 'icon' => 'milk'],
                ['name' => 'Bubur Beras / Nasi Tim (30 g)', 'benefit' => 'Karbohidrat sumber energi. Mulai dengan tekstur bubur kental, tingkatkan bertahap ke nasi tim.', 'icon' => 'rice'],
                ['name' => 'Hati Ayam (30 g)', 'benefit' => 'Sumber protein hewani, zat besi, dan vitamin A tinggi. Sangat baik untuk pertumbuhan.', 'icon' => 'meat'],
                ['name' => 'Telur Ayam (35 g / 1 butir)', 'benefit' => 'Protein lengkap, mudah dicerna. Berikan sebagai dadar atau ceplok lunak.', 'icon' => 'egg'],
                ['name' => 'Ikan Kembung / Gurame (15–30 g)', 'benefit' => 'Protein dan asam lemak omega-3 untuk perkembangan otak.', 'icon' => 'fish'],
                ['name' => 'Bayam / Buncis / Wortel (10–15 g)', 'benefit' => 'Sayuran sumber zat besi, folat, dan vitamin. Masak hingga lunak.', 'icon' => 'vegetable'],
                ['name' => 'Tempe (10–25 g)', 'benefit' => 'Protein nabati dan kalsium. Dapat diberikan sebagai tim atau puree.', 'icon' => 'food'],
            ];
        } elseif ($ageMonths < 12) {
            // 9–11 bulan: ASI + makanan cincang halus, 3–4x/hari, ½–¾ mangkok (125–200 ml), 300 kkal/hari
            $base = [
                ['name' => 'ASI', 'benefit' => 'Tetap berikan ASI sebagai pelengkap nutrisi.', 'icon' => 'milk'],
                ['name' => 'Nasi Tim / Nasi Lembek (45 g)', 'benefit' => 'Karbohidrat utama. Tekstur sudah bisa lebih kasar (tim/lembek).', 'icon' => 'rice'],
                ['name' => 'Daging Ayam Cincang (40 g)', 'benefit' => 'Protein hewani untuk pertumbuhan otot dan perkembangan otak.', 'icon' => 'meat'],
                ['name' => 'Hati Ayam (30 g / 1 buah)', 'benefit' => 'Sumber zat besi, vitamin A, dan protein sangat tinggi.', 'icon' => 'meat'],
                ['name' => 'Telur Ayam (55 g / 1 butir)', 'benefit' => 'Protein lengkap, praktis disiapkan sebagai dadar atau ceplok.', 'icon' => 'egg'],
                ['name' => 'Ikan Segar (30–40 g)', 'benefit' => 'Protein dan omega-3. Bisa berupa ikan kembung, gurame, atau lele.', 'icon' => 'fish'],
                ['name' => 'Tempe (25 g / 1 potong)', 'benefit' => 'Protein nabati, mudah didapat dan terjangkau.', 'icon' => 'food'],
                ['name' => 'Tahu (50 g / 1 buah sedang)', 'benefit' => 'Protein nabati dan kalsium. Bisa dikukus atau ditumis.', 'icon' => 'food'],
                ['name' => 'Bayam / Kangkung / Wortel (15–25 g)', 'benefit' => 'Sayuran sumber zat besi dan vitamin. Cincang halus.', 'icon' => 'vegetable'],
                ['name' => 'Kacang Hijau (15 g)', 'benefit' => 'Protein nabati, zat besi, dan serat. Berikan sebagai bubur kacang hijau.', 'icon' => 'nuts'],
                ['name' => 'Pisang / Pepaya / Mangga', 'benefit' => 'Buah sumber vitamin C dan serat. Berikan sebagai puree atau potongan kecil.', 'icon' => 'fruit'],
            ];
        } elseif ($ageMonths < 24) {
            // 12–23 bulan: makanan keluarga, 3–4x/hari, ¾–1 mangkok (250 ml), 550 kkal/hari
            $base = [
                ['name' => 'Nasi (55–100 g / ¾ gelas)', 'benefit' => 'Karbohidrat sumber energi utama. Sudah bisa diberikan nasi biasa.', 'icon' => 'rice'],
                ['name' => 'Daging Sapi / Ayam (35–40 g / 1 potong sedang)', 'benefit' => 'Protein hewani dan zat besi heme untuk pertumbuhan optimal.', 'icon' => 'meat'],
                ['name' => 'Hati Sapi / Hati Ayam (30–50 g)', 'benefit' => 'Sumber zat besi, vitamin A, dan protein sangat tinggi. Direkomendasikan 2–3x/minggu.', 'icon' => 'meat'],
                ['name' => 'Telur Ayam (55 g / 1 butir)', 'benefit' => 'Protein lengkap. Mudah disiapkan dan disukai anak.', 'icon' => 'egg'],
                ['name' => 'Ikan Segar (40 g)', 'benefit' => 'Protein dan omega-3. Dapat diberikan setiap hari.', 'icon' => 'fish'],
                ['name' => 'Tempe (25 g) + Tahu (50 g)', 'benefit' => 'Protein nabati terjangkau. Berikan bervariasi setiap hari.', 'icon' => 'food'],
                ['name' => 'Kacang Hijau / Kacang Merah / Kacang Kedelai (25 g)', 'benefit' => 'Protein nabati, zat besi, dan serat.', 'icon' => 'nuts'],
                ['name' => 'Bayam / Brokoli / Buncis / Wortel', 'benefit' => 'Sayuran kaya zat besi, kalsium, dan vitamin.', 'icon' => 'vegetable'],
                ['name' => 'Pisang / Pepaya / Jeruk Manis / Mangga', 'benefit' => 'Buah sumber vitamin C, kalium, dan serat.', 'icon' => 'fruit'],
                ['name' => 'Susu (1–2 gelas @250 ml/hari)', 'benefit' => 'Kalsium untuk pertumbuhan tulang. Berikan jika tidak mendapat ASI.', 'icon' => 'milk'],
            ];
        } else {
            // ≥ 24 bulan: makanan keluarga lengkap
            $base = [
                ['name' => 'Nasi (100 g / ¾ gelas)', 'benefit' => 'Sumber karbohidrat dan energi utama.', 'icon' => 'rice'],
                ['name' => 'Daging Sapi / Ayam (35–40 g)', 'benefit' => 'Protein hewani dan zat besi heme.', 'icon' => 'meat'],
                ['name' => 'Ikan Segar (40 g)', 'benefit' => 'Protein, omega-3, dan mineral penting untuk otak.', 'icon' => 'fish'],
                ['name' => 'Telur Ayam (55 g / 1 butir)', 'benefit' => 'Protein lengkap dan mudah disiapkan.', 'icon' => 'egg'],
                ['name' => 'Tempe (25 g) + Tahu (50 g)', 'benefit' => 'Protein nabati, kalsium, dan isoflavon.', 'icon' => 'food'],
                ['name' => 'Kacang-kacangan (20–25 g)', 'benefit' => 'Protein, serat, dan mineral penting.', 'icon' => 'nuts'],
                ['name' => 'Sayuran (100 g / 1 gelas)', 'benefit' => 'Pilih bayam, brokoli, wortel, buncis, kangkung — sumber zat besi dan vitamin.', 'icon' => 'vegetable'],
                ['name' => 'Buah-buahan (satu porsi/hari)', 'benefit' => 'Jeruk, mangga, pepaya, pisang — sumber vitamin C dan serat.', 'icon' => 'fruit'],
                ['name' => 'Susu (1–2 gelas @250 ml/hari)', 'benefit' => 'Kalsium untuk pertumbuhan tulang dan gigi.', 'icon' => 'milk'],
            ];
        }

        // Tambahan khusus untuk stunted/severely stunted
        if ($status === 'severely stunted' || $status === 'stunted') {
            $extra = [
                ['name' => 'Hati Ayam / Hati Sapi (prioritas)', 'benefit' => 'Sangat tinggi zat besi, vitamin A, dan protein. Direkomendasikan SDIDTK untuk anak stunting. Berikan 2–3x/minggu.', 'icon' => 'meat'],
                ['name' => 'Udang Segar (35 g / 5 ekor sedang)', 'benefit' => 'Protein hewani, zinc, dan mineral penting untuk pertumbuhan.', 'icon' => 'fish'],
                ['name' => 'Kerang (90 g / ½ gelas)', 'benefit' => 'Sumber zinc sangat tinggi, penting untuk pertumbuhan dan sistem imun.', 'icon' => 'fish'],
                ['name' => 'Teri Kering (20 g / 1 sdm)', 'benefit' => 'Kalsium sangat tinggi, protein, dan mudah ditambahkan ke masakan.', 'icon' => 'fish'],
                ['name' => 'Susu Tinggi Kalsium (1–2 gelas/hari)', 'benefit' => 'Kalsium untuk pertumbuhan tulang dan tinggi badan. Tambahkan 1–2 gelas/hari jika tidak mendapat ASI.', 'icon' => 'milk'],
                ['name' => 'Bubur Sumsum Kacang Hijau (75 g)', 'benefit' => 'Menu selingan bernutrisi dari buku SDIDTK. Protein nabati, zat besi, dan karbohidrat.', 'icon' => 'food'],
                ['name' => 'Nugget Ikan (35 g)', 'benefit' => 'Menu selingan berprotein tinggi dari buku SDIDTK. Disukai anak dan mudah diterima.', 'icon' => 'fish'],
            ];
            return array_merge($base, $extra);
        }

        return $base;
    }

    private function transformResult(StuntingResult $r): array
    {
        $label = [
            'severely stunted' => 'Sangat Pendek',
            'stunted'          => 'Pendek',
            'normal'           => 'Normal',
            'tinggi'           => 'Tinggi',
        ];

        return [
            'id'               => $r->id,
            'child_id'         => $r->child_id,
            'child'            => $r->child ? ['id' => $r->child->id, 'name' => $r->child->name, 'gender' => $r->child->gender] : null,
            'gender'           => $r->gender,
            'age'              => $r->age,
            'height'           => $r->height,
            'weight'           => $r->weight,
            'measurement_date' => $r->measurement_date?->toDateString(),
            'z_score'          => $r->z_score,
            'prediction_result'=> $r->prediction_result,
            'prediction_label' => $label[$r->prediction_result] ?? $r->prediction_result,
            'notes'            => $r->notes,
            'created_at'       => $r->created_at,
        ];
    }
}
