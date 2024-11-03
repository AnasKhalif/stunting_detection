<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\StuntingResult;
use App\Traits\FlashAlert;
use Laratrust\Traits\HasRolesAndPermissions;

class StatusController extends Controller
{
    use FlashAlert;
    use HasRolesAndPermissions;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = request()->user();


        if ($user->hasRole('superadmin') || $user->isAbleTo('status-read')) {

            $stuntingResults = StuntingResult::with('city')
                ->orderBy('created_at', 'desc')
                ->paginate(6);

            return view('status.index', compact('stuntingResults'));
        } else {
            return redirect()->route('dashboard')->with($this->permissionDenied());
        }
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
