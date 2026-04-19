<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Child;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChildController extends Controller
{
    public function index()
    {
        if (!$this->canReadChildren()) {
            return response()->json(['message' => 'Tidak memiliki akses untuk melihat data anak.'], 403);
        }

        $children = $this->childrenQueryForCurrentUser()
            ->with('parent:id,name,email')
            ->latest()
            ->get()
            ->map(fn ($c) => $this->transform($c));

        return response()->json(['data' => $children]);
    }

    public function store(Request $request)
    {
        if (!$this->canCreateChildren()) {
            return response()->json([
                'message' => 'Role ini tidak diizinkan menambahkan data anak.',
            ], 403);
        }

        $request->validate([
            'name'          => 'required|string|max:255',
            'gender'        => 'required|in:laki-laki,perempuan',
            'date_of_birth' => 'required|date',
            'birth_weight'  => 'nullable|numeric|min:0',
            'birth_height'  => 'nullable|numeric|min:0',
        ]);

        $child = Child::create([
            'user_id'       => Auth::id(),
            'name'          => $request->name,
            'gender'        => $request->gender,
            'date_of_birth' => $request->date_of_birth,
            'birth_weight'  => $request->birth_weight,
            'birth_height'  => $request->birth_height,
        ]);

        return response()->json(['data' => $this->transform($child)], 201);
    }

    public function show($uuid)
    {
        if (!$this->canReadChildren()) {
            return response()->json(['message' => 'Tidak memiliki akses untuk melihat data anak.'], 403);
        }

        $child = $this->childrenQueryForCurrentUser()
            ->with('parent:id,name,email')
            ->where('uuid', $uuid)
            ->firstOrFail();
        return response()->json(['data' => $this->transform($child)]);
    }

    public function update(Request $request, $uuid)
    {
        if (!$this->canUpdateChildren()) {
            return response()->json(['message' => 'Tidak memiliki akses untuk mengubah data anak.'], 403);
        }

        $child = $this->childrenQueryForCurrentUser()->where('uuid', $uuid)->firstOrFail();

        $request->validate([
            'name'          => 'sometimes|string|max:255',
            'gender'        => 'sometimes|in:laki-laki,perempuan',
            'date_of_birth' => 'sometimes|date',
            'birth_weight'  => 'nullable|numeric|min:0',
            'birth_height'  => 'nullable|numeric|min:0',
        ]);

        $child->update($request->only(['name', 'gender', 'date_of_birth', 'birth_weight', 'birth_height']));

        return response()->json(['data' => $this->transform($child->fresh(['parent:id,name,email']))]);
    }

    public function destroy($uuid)
    {
        if (!$this->canDeleteChildren()) {
            return response()->json(['message' => 'Tidak memiliki akses untuk menghapus data anak.'], 403);
        }

        $child = $this->childrenQueryForCurrentUser()->where('uuid', $uuid)->firstOrFail();
        $child->delete();
        return response()->json(['message' => 'Data anak berhasil dihapus']);
    }

    private function childrenQueryForCurrentUser()
    {
        $query = Child::query();

        if (!$this->canManageAllChildren()) {
            $query->where('user_id', Auth::id());
        }

        return $query;
    }

    private function canManageAllChildren(): bool
    {
        $user = Auth::user();

        if (!$user) {
            return false;
        }

        return $user->hasRole(['admin', 'superadmin', 'dokter', 'health_worker']);
    }

    private function canReadChildren(): bool
    {
        $user = Auth::user();

        if (!$user) {
            return false;
        }

        return $user->isSuperAdmin() || $user->isAbleTo('children-read');
    }

    private function canCreateChildren(): bool
    {
        $user = Auth::user();

        if (!$user) {
            return false;
        }

        return $user->isSuperAdmin() || $user->isAbleTo('children-create');
    }

    private function canUpdateChildren(): bool
    {
        $user = Auth::user();

        if (!$user) {
            return false;
        }

        return $user->isSuperAdmin() || $user->isAbleTo('children-update');
    }

    private function canDeleteChildren(): bool
    {
        $user = Auth::user();

        if (!$user) {
            return false;
        }

        return $user->isSuperAdmin() || $user->isAbleTo('children-delete');
    }

    private function transform(Child $c): array
    {
        return [
            'id'             => $c->id,
            'uuid'           => $c->uuid,
            'user_id'        => $c->user_id,
            'name'           => $c->name,
            'gender'         => $c->gender,
            'date_of_birth'  => $c->date_of_birth?->toDateString(),
            'birth_weight'   => $c->birth_weight,
            'birth_height'   => $c->birth_height,
            'age_in_months'  => $c->age_in_months,
            'photo'          => $c->photo,
            'parent'         => $c->parent ? [
                'id'    => $c->parent->id,
                'name'  => $c->parent->name,
                'email' => $c->parent->email,
            ] : null,
            'created_at'     => $c->created_at,
        ];
    }
}
