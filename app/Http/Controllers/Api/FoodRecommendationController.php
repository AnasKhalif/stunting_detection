<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FoodRecommendation;
use Illuminate\Http\Request;

class FoodRecommendationController extends Controller
{
    public function index(Request $request)
    {
        $query = FoodRecommendation::query();

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $foods = $query->get()->map(fn($f) => $this->transform($f));

        return response()->json(['data' => $foods]);
    }

    public function show($id)
    {
        $food = FoodRecommendation::findOrFail($id);
        return response()->json(['data' => $this->transform($food)]);
    }

    public function byStatus(Request $request)
    {
        $request->validate(['status' => 'required|string']);
        $category = $this->statusToCategory($request->status);

        $foods = FoodRecommendation::where('category', $category)
            ->orWhere('category', 'umum')
            ->get()
            ->map(fn($f) => $this->transform($f));

        return response()->json(['data' => $foods]);
    }

    private function statusToCategory(string $status): string
    {
        return match($status) {
            'severely stunted', 'stunted' => 'stunting',
            'tinggi' => 'tinggi',
            default => 'umum',
        };
    }

    private function transform(FoodRecommendation $f): array
    {
        return [
            'id'               => $f->id,
            'name'             => $f->name,
            'category'         => $f->category,
            'nutritional_info' => $f->nutritional_info,
            'recipe'           => $f->recipe,
            'image'            => $f->image,
        ];
    }
}
