<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FoodRecommendation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FoodRecommendationController extends Controller
{
    public function index(Request $request)
    {
        if (!$this->canReadFoods()) {
            return response()->json(['message' => 'Tidak memiliki akses untuk melihat makanan.'], 403);
        }

        $query = FoodRecommendation::query();

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $foods = $query->get()->map(fn ($f) => $this->transform($f));

        return response()->json(['data' => $foods]);
    }

    public function show($id)
    {
        if (!$this->canReadFoods()) {
            return response()->json(['message' => 'Tidak memiliki akses untuk melihat makanan.'], 403);
        }

        $food = FoodRecommendation::findOrFail($id);
        return response()->json(['data' => $this->transform($food)]);
    }

    public function byStatus(Request $request)
    {
        if (!$this->canReadFoods()) {
            return response()->json(['message' => 'Tidak memiliki akses untuk melihat makanan.'], 403);
        }

        $request->validate(['status' => 'required|string']);
        $category = $this->statusToCategory($request->status);

        $foods = FoodRecommendation::where('category', $category)
            ->orWhere('category', 'umum')
            ->get()
            ->map(fn ($f) => $this->transform($f));

        return response()->json(['data' => $foods]);
    }

    public function store(Request $request)
    {
        if (!$this->canCreateFoods()) {
            return response()->json(['message' => 'Tidak memiliki akses untuk menambah makanan.'], 403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:umum,stunting,tinggi',
            'nutritional_info' => 'required|string',
            'recipe' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('foods', 'public');
        }

        $food = FoodRecommendation::create($validated);

        return response()->json(['data' => $this->transform($food)], 201);
    }

    public function update(Request $request, $id)
    {
        if (!$this->canUpdateFoods()) {
            return response()->json(['message' => 'Tidak memiliki akses untuk mengubah makanan.'], 403);
        }

        $food = FoodRecommendation::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'category' => 'sometimes|required|in:umum,stunting,tinggi',
            'nutritional_info' => 'sometimes|required|string',
            'recipe' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($food->image && !str_starts_with($food->image, 'http')) {
                Storage::disk('public')->delete($food->image);
            }
            $validated['image'] = $request->file('image')->store('foods', 'public');
        }

        $food->update($validated);

        return response()->json(['data' => $this->transform($food->fresh())]);
    }

    public function destroy($id)
    {
        if (!$this->canDeleteFoods()) {
            return response()->json(['message' => 'Tidak memiliki akses untuk menghapus makanan.'], 403);
        }

        $food = FoodRecommendation::findOrFail($id);

        if ($food->image && !str_starts_with($food->image, 'http')) {
            Storage::disk('public')->delete($food->image);
        }

        $food->delete();

        return response()->json(['message' => 'Makanan berhasil dihapus']);
    }

    private function statusToCategory(string $status): string
    {
        return match ($status) {
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
            'image'            => $this->resolveImageUrl($f->image),
        ];
    }

    private function canReadFoods(): bool
    {
        $user = Auth::user();

        if (!$user) {
            return false;
        }

        return $user->isSuperAdmin() || $user->isAbleTo('foods-read');
    }

    private function canCreateFoods(): bool
    {
        $user = Auth::user();

        if (!$user) {
            return false;
        }

        return $user->isSuperAdmin() || $user->isAbleTo('foods-create');
    }

    private function canUpdateFoods(): bool
    {
        $user = Auth::user();

        if (!$user) {
            return false;
        }

        return $user->isSuperAdmin() || $user->isAbleTo('foods-update');
    }

    private function canDeleteFoods(): bool
    {
        $user = Auth::user();

        if (!$user) {
            return false;
        }

        return $user->isSuperAdmin() || $user->isAbleTo('foods-delete');
    }

    private function resolveImageUrl(?string $image): ?string
    {
        if (!$image) {
            return null;
        }

        if (str_starts_with($image, 'http://') || str_starts_with($image, 'https://')) {
            return $image;
        }

        return asset('storage/' . ltrim($image, '/'));
    }
}
