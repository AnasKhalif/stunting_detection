<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Traits\FlashAlert;
use Laratrust\Traits\HasRolesAndPermissions;

class MessageController extends Controller
{
    public function index()
    {
        $user = request()->user();

        if ($user->hasRole('superadmin') || $user->isAbleTo('message-read')) {
            $messages = Contact::paginate(6);

            return view('message.index', compact('messages'));
        } else {
            return redirect()->route('dashboard')->with($this->permissionDenied());
        }
    }

    public function show($id)
    {
        $user = request()->user();

        if ($user->hasRole('superadmin') || $user->isAbleTo('message-read')) {
            $message = Contact::findOrFail($id);

            return view('message.detail', compact('message'));
        } else {
            return redirect()->route('dashboard')->with($this->permissionDenied());
        }
    }
}
