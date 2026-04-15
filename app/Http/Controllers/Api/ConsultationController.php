<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Consultation;
use App\Models\ConsultationMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConsultationController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $authId = (int) $user->id;

        $query = Consultation::with([
            'parent:id,name,email',
            'healthWorker:id,name,email',
            'child:id,name',
        ])
        ->withCount('messages')
        ->withCount(['messages as unread_count' => function ($q) use ($authId) {
            $q->where('sender_id', '!=', $authId)->where('is_read', false);
        }]);

        // Filter by role: orang_tua sees only their own, dokter sees theirs
        if ($user->hasRole('orang_tua') || $user->hasRole('user')) {
            $query->where('parent_id', $user->id);
        } elseif ($user->hasRole('dokter')) {
            $query->where('health_worker_id', $user->id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $consultations = $query->latest()->get()->map(fn($c) => $this->transform($c));

        return response()->json(['data' => $consultations]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'health_worker_id' => 'required|exists:users,id',
            'child_id'         => 'nullable|exists:children,id',
            'subject'          => 'nullable|string|max:255',
        ]);

        $consultation = Consultation::create([
            'parent_id'       => Auth::id(),
            'health_worker_id'=> $request->health_worker_id,
            'child_id'        => $request->child_id,
            'subject'         => $request->subject,
            'status'          => 'pending',
        ]);

        $consultation->load(['parent:id,name,email', 'healthWorker:id,name,email', 'child:id,name']);

        return response()->json(['data' => $this->transform($consultation)], 201);
    }

    public function show($id)
    {
        $consultation = Consultation::with([
            'parent:id,name,email',
            'healthWorker:id,name,email',
            'child:id,name',
            'messages.sender:id,name',
        ])->findOrFail($id);

        return response()->json(['data' => $this->transform($consultation)]);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,ongoing,completed',
        ]);

        $consultation = Consultation::findOrFail($id);
        $consultation->update(['status' => $request->status]);

        return response()->json(['data' => $this->transform($consultation)]);
    }

    public function messages($id)
    {
        $consultation = Consultation::findOrFail($id);

        $authId = (int) Auth::id();
        $parentId = (int) $consultation->parent_id;
        $healthWorkerId = (int) $consultation->health_worker_id;

        // Only mark as read when the RECIPIENT opens the chat:
        // - If current user is the health_worker → mark messages sent by parent as read
        // - If current user is the parent → mark messages sent by health_worker as read
        // - Never mark your own sent messages as read via polling
        if ($authId === $healthWorkerId) {
            $consultation->messages()
                ->where('sender_id', $parentId)
                ->where('is_read', false)
                ->update(['is_read' => true]);
        } elseif ($authId === $parentId) {
            $consultation->messages()
                ->where('sender_id', $healthWorkerId)
                ->where('is_read', false)
                ->update(['is_read' => true]);
        }

        $messages = $consultation->messages()->with('sender:id,name')->oldest()->get()
            ->map(fn($m) => $this->transformMessage($m));

        return response()->json(['data' => $messages]);
    }

    public function sendMessage(Request $request, $id)
    {
        $request->validate([
            'message'    => 'required|string',
            'attachment' => 'nullable|string',
        ]);

        $consultation = Consultation::findOrFail($id);

        $msg = ConsultationMessage::create([
            'consultation_id' => $consultation->id,
            'sender_id'       => Auth::id(),
            'message'         => $request->message,
            'attachment'      => $request->attachment,
            'is_read'         => false,
        ]);

        $msg->load('sender:id,name');

        return response()->json(['data' => $this->transformMessage($msg)], 201);
    }

    private function transformMessage(ConsultationMessage $m): array
    {
        return [
            'id'              => $m->id,
            'consultation_id' => $m->consultation_id,
            'sender_id'       => $m->sender_id,
            'message'         => $m->message,
            'attachment'      => $m->attachment,
            'is_read'         => (bool) $m->is_read,
            'sender'          => $m->sender ? ['id' => $m->sender->id, 'name' => $m->sender->name] : null,
            'created_at'      => $m->created_at,
            'updated_at'      => $m->updated_at,
        ];
    }

    private function transform(Consultation $c): array
    {
        return [
            'id'               => $c->id,
            'parent_id'        => $c->parent_id,
            'health_worker_id' => $c->health_worker_id,
            'child_id'         => $c->child_id,
            'status'           => $c->status,
            'subject'          => $c->subject,
            'parent'           => $c->parent ? ['id' => $c->parent->id, 'name' => $c->parent->name, 'email' => $c->parent->email] : null,
            'health_worker'    => $c->healthWorker ? ['id' => $c->healthWorker->id, 'name' => $c->healthWorker->name, 'email' => $c->healthWorker->email] : null,
            'child'            => $c->child ? ['id' => $c->child->id, 'name' => $c->child->name] : null,
            'messages_count'   => $c->messages_count ?? $c->messages()->count(),
            'unread_count'     => (int) ($c->unread_count ?? 0),
            'latest_message'   => null,
            'created_at'       => $c->created_at,
            'updated_at'       => $c->updated_at,
        ];
    }
}
