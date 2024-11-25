<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravolt\Indonesia\Models\City;
use App\Models\StuntingResult;
use GuzzleHttp\Client;

class KalkulatorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cities = City::where('province_code', 35)
            ->get();

        return view('users.kalkulator', compact('cities'));
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {

        $validated = $request->validate([
            'gender' => 'required',
            'age' => 'required|numeric|min:0|max:60',
            'height' => 'required',
            'city_id' => 'required',
            'district_name' => 'required',
        ]);

        list($cityId, $cityCode) = explode(':', $validated['city_id']);

        $genderNumeric = $validated['gender'] === 'laki-laki' ? 0 : 1;


        $client = new Client();
        $response = $client->post('http://127.0.0.1:5000/predict', [
            'json' => [
                'Jenis Kelamin' => $genderNumeric,
                'Umur (bulan)' => floatval($validated['age']),
                'Tinggi Badan (cm)' => floatval($validated['height']),
            ]
        ]);


        $prediction = json_decode($response->getBody(), true);
        $predictionResult = $prediction['stunting_status'];

        $city = City::find($cityId);

        $stuntingResult = StuntingResult::create([
            'gender' => $validated['gender'],
            'age' => $validated['age'],
            'height' => $validated['height'],
            'city_id' => $cityId,
            'district_name' => $validated['district_name'],
            'prediction_result' => $predictionResult,
        ]);


        // return redirect()->back()->with('message', 'Hasil Prediksi: ' . $predictionResult);
        $advice = $this->getAdviceBasedOnStatus($predictionResult);

        return view('users.prediction_result', [
            'status' => $predictionResult,
            'advice' => $advice,
            'result' => $stuntingResult,
            'city' => $city->name,
            'district' => $validated['district_name'],
        ]);
    }

    private function getAdviceBasedOnStatus($status)
    {
        switch ($status) {
            case 'severely stunted':
                return [
                    'message' => 'Anak sangat pendek. Segera rujuk ke rumah sakit untuk pemeriksaan lebih lanjut.',
                    'steps' => [
                        'Segera rujuk ke rumah sakit untuk evaluasi dan penanganan lebih lanjut.',
                        'Lakukan pemeriksaan mendalam untuk mendeteksi penyebab (misalnya, penyakit penyerta atau red flags).',
                        'Berikan intervensi gizi pediatrik segera.',
                    ],
                ];
            case 'stunted':
                return [
                    'message' => 'Anak memiliki pertumbuhan pendek. Perhatikan asupan gizi dan konsultasi lebih lanjut.',
                    'steps' => [
                        'Evaluasi parameter status gizi lainnya (berat badan dan indeks massa tubuh).',
                        'Berikan intervensi gizi standar serta stimulasi sesuai umur.',
                        'Rujuk jika tidak ada perubahan dalam waktu yang ditentukan.',
                    ],
                ];
            case 'normal':
                return [
                    'message' => 'Pertumbuhan anak normal. Lanjutkan pemantauan rutin.',
                    'steps' => [
                        'Lanjutkan stimulasi dan pola makan yang seimbang sesuai tahapan umur.',
                        'Jadwalkan kunjungan berikutnya untuk pemantauan rutin.',
                    ],
                ];
            case 'tinggi':
                return [
                    'message' => 'Pertumbuhan anak tinggi. Pastikan tidak ada masalah medis.',
                    'steps' => [
                        'Lakukan pemeriksaan jika diperlukan.',
                        'Pantau pola pertumbuhan secara berkala.',
                    ],
                ];
            default:
                return [
                    'message' => 'Status tidak diketahui.',
                    'steps' => [],
                ];
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
