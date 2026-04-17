<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        if (!$this->canReadArticle()) {
            return response()->json(['message' => 'Tidak memiliki akses untuk melihat artikel.'], 403);
        }

        $query = Article::query()->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                    ->orWhere('body', 'like', '%' . $search . '%')
                    ->orWhere('excerpt', 'like', '%' . $search . '%')
                    ->orWhere('category', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->has('published') && $request->published !== '') {
            $query->where('published', filter_var($request->published, FILTER_VALIDATE_BOOLEAN));
        }

        $articles = $query->get()->map(fn ($article) => $this->transform($article));

        return response()->json(['data' => $articles]);
    }

    public function show($id)
    {
        if (!$this->canReadArticle()) {
            return response()->json(['message' => 'Tidak memiliki akses untuk melihat artikel.'], 403);
        }

        $article = Article::findOrFail($id);

        return response()->json(['data' => $this->transform($article)]);
    }

    public function store(Request $request)
    {
        if (!$this->canCreateArticle()) {
            return response()->json(['message' => 'Tidak memiliki akses untuk menambah artikel.'], 403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:articles,slug',
            'category' => 'nullable|string|max:100',
            'excerpt' => 'nullable|string',
            'body' => 'required|string',
            'published' => 'nullable|boolean',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $validated['user_id'] = Auth::id();

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('article', 'public');
        }

        $article = Article::create($validated);

        return response()->json(['data' => $this->transform($article)], 201);
    }

    public function update(Request $request, $id)
    {
        $article = Article::findOrFail($id);

        if (!$this->canUpdateArticle()) {
            return response()->json(['message' => 'Tidak memiliki akses untuk mengubah artikel.'], 403);
        }

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:articles,slug,' . $article->id,
            'category' => 'nullable|string|max:100',
            'excerpt' => 'nullable|string',
            'body' => 'sometimes|required|string',
            'published' => 'nullable|boolean',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($article->image && !str_starts_with($article->image, 'http')) {
                Storage::disk('public')->delete($article->image);
            }
            $validated['image'] = $request->file('image')->store('article', 'public');
        }

        $article->update($validated);

        return response()->json(['data' => $this->transform($article->fresh())]);
    }

    public function destroy($id)
    {
        $article = Article::findOrFail($id);

        if (!$this->canDeleteArticle()) {
            return response()->json(['message' => 'Tidak memiliki akses untuk menghapus artikel.'], 403);
        }

        if ($article->image && !str_starts_with($article->image, 'http')) {
            Storage::disk('public')->delete($article->image);
        }

        $article->delete();

        return response()->json(['message' => 'Artikel berhasil dihapus']);
    }

    public function uploadImage(Request $request, $id)
    {
        $article = Article::findOrFail($id);

        if (!$this->canUpdateArticle()) {
            return response()->json(['message' => 'Tidak memiliki akses untuk upload gambar artikel.'], 403);
        }

        $validated = $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($article->image && !str_starts_with($article->image, 'http')) {
            Storage::disk('public')->delete($article->image);
        }

        $article->image = $validated['image']->store('article', 'public');
        $article->save();

        return response()->json(['data' => $this->transform($article->fresh())]);
    }

    private function transform(Article $article): array
    {
        return [
            'id' => $article->id,
            'user_id' => $article->user_id,
            'title' => $article->title,
            'slug' => $article->slug,
            'category' => $article->category,
            'excerpt' => $article->excerpt,
            'body' => $article->body,
            'image' => $this->resolveImageUrl($article->image),
            'published' => (bool) $article->published,
            'created_at' => $article->created_at,
            'updated_at' => $article->updated_at,
        ];
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

    private function canReadArticle(): bool
    {
        $user = Auth::user();

        if (!$user) {
            return false;
        }

        return $user->isSuperAdmin() || $user->isAbleTo('articles-read');
    }

    private function canCreateArticle(): bool
    {
        $user = Auth::user();

        if (!$user) {
            return false;
        }

        return $user->isSuperAdmin() || $user->isAbleTo('articles-create');
    }

    private function canUpdateArticle(): bool
    {
        $user = Auth::user();

        if (!$user) {
            return false;
        }

        return $user->isSuperAdmin() || $user->isAbleTo('articles-update');
    }

    private function canDeleteArticle(): bool
    {
        $user = Auth::user();

        if (!$user) {
            return false;
        }

        return $user->isSuperAdmin() || $user->isAbleTo('articles-delete');
    }
}
