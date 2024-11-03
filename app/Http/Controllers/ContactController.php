<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Mail\ContactMessage;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index()
    {
        return view('users.contact');
    }

    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:15',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);


        $contact = Contact::create($validatedData);


        Mail::to('superadmin@app.test')->send(new ContactMessage($validatedData));


        return redirect()->route('kontak')->with('contact_message', 'Pesan Anda telah terkirim.');
    }
}
