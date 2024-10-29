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
        $cities = City::where('province_code', 35) // 35 adalah code untuk Jawa Timur
            ->get();

        return view('users.kalkulator', compact('cities'));
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        // Validasi data input dari request
        $validated = $request->validate([
            'gender' => 'required',
            'age' => 'required|numeric|min:0|max:60',
            'height' => 'required',
            'city_id' => 'required|exists:indonesia_cities,id',
        ]);

        $genderNumeric = $validated['gender'] === 'laki-laki' ? 0 : 1;

        // Kirim data ke API Python untuk prediksi
        $client = new Client();
        $response = $client->post('http://127.0.0.1:5000/predict', [
            'json' => [
                'Jenis Kelamin' => $genderNumeric,
                'Umur (bulan)' => floatval($validated['age']),
                'Tinggi Badan (cm)' => floatval($validated['height']),
            ]
        ]);

        // Mendapatkan hasil prediksi dari Flask API
        $prediction = json_decode($response->getBody(), true);
        $predictionResult = $prediction['stunting_status'];


        // Simpan hasil prediksi ke database
        StuntingResult::create([
            'gender' => $validated['gender'],
            'age' => $validated['age'],
            'height' => $validated['height'],
            'city_id' => $validated['city_id'],
            'prediction_result' => $predictionResult, // Simpan hasil sebagai string
        ]);


        return redirect()->back()->with('message', 'Hasil Prediksi: ' . $predictionResult);
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
