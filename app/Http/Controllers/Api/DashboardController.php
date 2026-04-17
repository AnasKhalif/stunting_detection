<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Child;
use App\Models\Consultation;
use App\Models\StuntingResult;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    // Dashboard untuk orang tua
    public function parent(): JsonResponse
    {
        if (!$this->canAccess('dashboard-read')) {
            return response()->json(['message' => 'Tidak memiliki akses dashboard.'], 403);
        }

        $userId = Auth::id();

        $children = Child::where('user_id', $userId)->get();
        $childIds = $children->pluck('id');

        $totalDetections = StuntingResult::where('user_id', $userId)->count();

        $latestResults = StuntingResult::where('user_id', $userId)
            ->with('child:id,name,gender')
            ->latest('measurement_date')
            ->take(5)
            ->get()
            ->map(fn ($r) => [
                'id'               => $r->id,
                'child_name'       => $r->child?->name ?? '-',
                'measurement_date' => $r->measurement_date?->toDateString(),
                'prediction_result' => $r->prediction_result,
                'prediction_label' => $this->statusLabel($r->prediction_result),
                'z_score'          => $r->z_score,
                'height'           => $r->height,
                'age'              => $r->age,
            ]);

        $statusCounts = StuntingResult::where('user_id', $userId)
            ->selectRaw('prediction_result, count(*) as total')
            ->groupBy('prediction_result')
            ->pluck('total', 'prediction_result');

        $activeConsultations = Consultation::where('parent_id', $userId)
            ->whereIn('status', ['pending', 'ongoing'])
            ->count();

        $childSummaries = $children->map(function ($c) {
            $latest = StuntingResult::where('child_id', $c->id)
                ->latest('measurement_date')
                ->first();
            return [
                'id'             => $c->id,
                'name'           => $c->name,
                'gender'         => $c->gender,
                'age_in_months'  => $c->age_in_months,
                'latest_status'  => $latest?->prediction_result,
                'latest_label'   => $this->statusLabel($latest?->prediction_result),
                'latest_height'  => $latest?->height,
                'latest_date'    => $latest?->measurement_date?->toDateString(),
            ];
        });

        return response()->json([
            'data' => [
                'total_children'        => $children->count(),
                'total_detections'      => $totalDetections,
                'active_consultations'  => $activeConsultations,
                'status_counts'         => $statusCounts,
                'latest_results'        => $latestResults,
                'children_summary'      => $childSummaries,
            ],
        ]);
    }

    // Dashboard untuk dokter
    public function doctor(): JsonResponse
    {
        if (!$this->canAccess('dashboard-read')) {
            return response()->json(['message' => 'Tidak memiliki akses dashboard.'], 403);
        }

        $userId = Auth::id();

        $totalConsultations   = Consultation::where('health_worker_id', $userId)->count();
        $pendingConsultations  = Consultation::where('health_worker_id', $userId)->where('status', 'pending')->count();
        $ongoingConsultations  = Consultation::where('health_worker_id', $userId)->where('status', 'ongoing')->count();
        $completedConsultations = Consultation::where('health_worker_id', $userId)->where('status', 'completed')->count();

        $recentConsultations = Consultation::where('health_worker_id', $userId)
            ->with('parent:id,name,email')
            ->latest()
            ->take(5)
            ->get()
            ->map(fn ($c) => [
                'id'          => $c->id,
                'parent_name' => $c->parent?->name ?? '-',
                'subject'     => $c->subject,
                'status'      => $c->status,
                'created_at'  => $c->created_at,
            ]);

        // Unique patients (distinct parent_ids)
        $totalPatients = Consultation::where('health_worker_id', $userId)
            ->distinct('parent_id')
            ->count('parent_id');

        return response()->json([
            'data' => [
                'total_consultations'    => $totalConsultations,
                'pending_consultations'  => $pendingConsultations,
                'ongoing_consultations'  => $ongoingConsultations,
                'completed_consultations' => $completedConsultations,
                'total_patients'         => $totalPatients,
                'recent_consultations'   => $recentConsultations,
            ],
        ]);
    }

    // Dashboard untuk admin/superadmin
    public function admin(): JsonResponse
    {
        if (!$this->canAccess('dashboard-read')) {
            return response()->json(['message' => 'Tidak memiliki akses dashboard.'], 403);
        }

        $totalUsers         = \App\Models\User::count();
        $totalChildren      = Child::count();
        $totalDetections    = StuntingResult::count();
        $totalConsultations = Consultation::count();

        $statusCounts = StuntingResult::selectRaw('prediction_result, count(*) as total')
            ->groupBy('prediction_result')
            ->pluck('total', 'prediction_result');

        $monthlyDetections = StuntingResult::selectRaw('DATE_FORMAT(measurement_date, "%Y-%m") as month, count(*) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->take(12)
            ->get();

        return response()->json([
            'data' => [
                'total_users'         => $totalUsers,
                'total_children'      => $totalChildren,
                'total_detections'    => $totalDetections,
                'total_consultations' => $totalConsultations,
                'status_counts'       => $statusCounts,
                'monthly_detections'  => $monthlyDetections,
            ],
        ]);
    }

    private function statusLabel(?string $status): string
    {
        return match ($status) {
            'severely stunted' => 'Sangat Pendek',
            'stunted'          => 'Pendek',
            'normal'           => 'Normal',
            'tinggi'           => 'Tinggi',
            default            => '-',
        };
    }

    private function canAccess(string $permission): bool
    {
        $user = Auth::user();

        if (!$user) {
            return false;
        }

        return $user->isSuperAdmin() || $user->isAbleTo($permission);
    }
}
