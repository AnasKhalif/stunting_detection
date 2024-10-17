<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravolt\Indonesia\Models\City;

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
        $validated = $request->validate([
            'gender' => 'required',
            'age' => 'required|numeric|min:0|max:60',
            'weight' => 'required|numeric|min:0',
            'height' => 'required|numeric|min:0',
            'birth_length' => 'required|numeric|min:0',
            'city_id' => 'required|exists:indonesia_cities,id',
        ]);


        $cityName = \DB::table('indonesia_cities')
            ->where('id', $validated['city_id'])
            ->value('name');


        dd([
            $validated,
            'city_id' => $validated['city_id'],
            'city_name' => $cityName,
        ]);
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
