<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FaqController extends Controller
{
    public function index(Request $request)
    {
        if (!$this->canReadFaq()) {
            return response()->json(['message' => 'Tidak memiliki akses untuk melihat FAQ.'], 403);
        }

        $query = Faq::query()->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('question', 'like', '%' . $search . '%')
                    ->orWhere('answer', 'like', '%' . $search . '%');
            });
        }

        if ($request->has('published') && $request->published !== '') {
            $query->where('published', filter_var($request->published, FILTER_VALIDATE_BOOLEAN));
        }

        $faqs = $query->get()->map(fn ($faq) => $this->transform($faq));

        return response()->json(['data' => $faqs]);
    }

    public function show($id)
    {
        if (!$this->canReadFaq()) {
            return response()->json(['message' => 'Tidak memiliki akses untuk melihat FAQ.'], 403);
        }

        $faq = Faq::findOrFail($id);

        return response()->json(['data' => $this->transform($faq)]);
    }

    public function store(Request $request)
    {
        if (!$this->canCreateFaq()) {
            return response()->json(['message' => 'Tidak memiliki akses untuk menambah FAQ.'], 403);
        }

        $validated = $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
            'published' => 'nullable|boolean',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['published'] = (bool) ($validated['published'] ?? false);

        $faq = Faq::create($validated);

        return response()->json(['data' => $this->transform($faq)], 201);
    }

    public function update(Request $request, $id)
    {
        if (!$this->canUpdateFaq()) {
            return response()->json(['message' => 'Tidak memiliki akses untuk mengubah FAQ.'], 403);
        }

        $faq = Faq::findOrFail($id);

        $validated = $request->validate([
            'question' => 'sometimes|required|string|max:255',
            'answer' => 'sometimes|required|string',
            'published' => 'nullable|boolean',
        ]);

        if (array_key_exists('published', $validated)) {
            $validated['published'] = (bool) $validated['published'];
        }

        $faq->update($validated);

        return response()->json(['data' => $this->transform($faq->fresh())]);
    }

    public function destroy($id)
    {
        if (!$this->canDeleteFaq()) {
            return response()->json(['message' => 'Tidak memiliki akses untuk menghapus FAQ.'], 403);
        }

        $faq = Faq::findOrFail($id);
        $faq->delete();

        return response()->json(['message' => 'FAQ berhasil dihapus']);
    }

    private function transform(Faq $faq): array
    {
        return [
            'id' => $faq->id,
            'user_id' => $faq->user_id,
            'question' => $faq->question,
            'answer' => $faq->answer,
            'published' => (bool) $faq->published,
            'created_at' => $faq->created_at,
            'updated_at' => $faq->updated_at,
        ];
    }

    private function canReadFaq(): bool
    {
        $user = Auth::user();

        if (!$user) {
            return false;
        }

        return $user->isSuperAdmin() || $user->isAbleTo('faqs-read');
    }

    private function canCreateFaq(): bool
    {
        $user = Auth::user();

        if (!$user) {
            return false;
        }

        return $user->isSuperAdmin() || $user->isAbleTo('faqs-create');
    }

    private function canUpdateFaq(): bool
    {
        $user = Auth::user();

        if (!$user) {
            return false;
        }

        return $user->isSuperAdmin() || $user->isAbleTo('faqs-update');
    }

    private function canDeleteFaq(): bool
    {
        $user = Auth::user();

        if (!$user) {
            return false;
        }

        return $user->isSuperAdmin() || $user->isAbleTo('faqs-delete');
    }
}
