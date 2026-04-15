<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user()->loadMissing('roles');
        return response()->json(['data' => $this->transform($user)]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'         => 'sometimes|string|max:255',
            'phone_number' => 'sometimes|string|max:20',
            'address'      => 'sometimes|string|max:1000',
            'date_of_birth'=> 'sometimes|date',
            'gender'       => 'sometimes|in:laki-laki,perempuan',
            'email'        => 'sometimes|email|unique:users,email,' . $user->id,
        ]);

        $user->update($request->only(['name', 'phone_number', 'address', 'date_of_birth', 'gender', 'email']));

        return response()->json(['data' => $this->transform($user->fresh('roles'))]);
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'password'         => ['required', 'confirmed', Password::min(8)],
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'message' => 'Password lama tidak sesuai.',
                'errors'  => ['current_password' => ['Password lama tidak sesuai.']],
            ], 422);
        }

        $user->update(['password' => Hash::make($request->password)]);

        return response()->json(['message' => 'Password berhasil diubah.']);
    }

    private function transform($user): array
    {
        return [
            'id'            => $user->id,
            'uid'           => $user->uid,
            'name'          => $user->name,
            'email'         => $user->email,
            'phone_number'  => $user->phone_number,
            'address'       => $user->address,
            'date_of_birth' => $user->date_of_birth?->toDateString(),
            'gender'        => $user->gender,
            'role'          => $user->roles->first()?->name,
            'created_at'    => $user->created_at,
        ];
    }
}
