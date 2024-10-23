<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\StuntingResult;
use App\Models\Article;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $stuntingResults = StuntingResult::with('city')
            ->orderBy('created_at', 'desc')
            ->paginate(4);
        $articles = Article::orderBy('created_at', 'desc')->paginate(6);

        $totalStunting = StuntingResult::count();
        $stuntingCount = StuntingResult::where('prediction_result', 'Stunting')->count();
        $notStuntingCount = StuntingResult::where('prediction_result', 'Tidak Stunting')->count();

        // Ambil data harian selama 7 hari terakhir
        $data = StuntingResult::selectRaw('DATE(created_at) as date, 
                SUM(CASE WHEN prediction_result = "Stunting" THEN 1 ELSE 0 END) as stunting,
                SUM(CASE WHEN prediction_result = "Tidak Stunting" THEN 1 ELSE 0 END) as not_stunting')
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        // Ubah data ke format yang diperlukan
        $dates = [];
        $stuntingData = [];
        $notStuntingData = [];

        foreach ($data as $item) {
            $dates[] = $item->date;
            $stuntingData[] = $item->stunting;
            $notStuntingData[] = $item->not_stunting;
        }

        return view('dashboard', compact('user', 'stuntingResults', 'articles', 'totalStunting', 'stuntingCount', 'notStuntingCount', 'dates', 'stuntingData', 'notStuntingData'));
    }
}
