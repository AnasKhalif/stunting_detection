<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\StuntingResult;
use App\Models\Article;
use Carbon\Carbon;

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
        $countHigh = StuntingResult::where('prediction_result', 'tinggi')->count();
        $countNormal = StuntingResult::where('prediction_result', 'normal')->count();
        $countStunted = StuntingResult::where('prediction_result', 'stunted')->count();
        $countSeverelyStunted = StuntingResult::where('prediction_result', 'severely stunted')->count();

        $categories = [
            'tinggi' => $countHigh,
            'normal' => $countNormal,
            'stunted' => $countStunted,
            'severely stunted' => $countSeverelyStunted
        ];

        $mostFrequentCategory = array_keys($categories, max($categories))[0];
        $mostFrequentCount = max($categories);

        $dates = [];
        for ($i = 6; $i >= 0; $i--) {
            $dates[] = Carbon::today()->subDays($i)->format('Y-m-d');
        }

        $data = [];
        foreach ($dates as $date) {
            $data['tinggi'][] = StuntingResult::where('prediction_result', 'tinggi')->whereDate('created_at', $date)->count();
            $data['normal'][] = StuntingResult::where('prediction_result', 'normal')->whereDate('created_at', $date)->count();
            $data['stunted'][] = StuntingResult::where('prediction_result', 'stunted')->whereDate('created_at', $date)->count();
            $data['severely_stunted'][] = StuntingResult::where('prediction_result', 'severely stunted')->whereDate('created_at', $date)->count();
        }

        return view('dashboard', compact(
            'user',
            'stuntingResults',
            'articles',
            'totalStunting',
            'countHigh',
            'countNormal',
            'countStunted',
            'countSeverelyStunted',
            'mostFrequentCategory',
            'mostFrequentCount',
            'dates',
            'data'
        ));
    }
}
