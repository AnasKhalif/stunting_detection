<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request): JsonResponse
    {
        $fullName = $request->input('full_name')
            ?? trim(implode(' ', array_filter([
                $request->input('first_name'),
                $request->input('last_name'),
            ])))
            ?? $request->input('company_name');

        $phoneNumber = $request->input('phone_number')
            ?? $request->input('phone')
            ?? $request->input('company_npwp');

        $address = $request->input('address')
            ?? $request->input('company_address');

        $preparedPayload = [
            'full_name' => $fullName,
            'phone_number' => $phoneNumber,
            'address' => $address,
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'password_confirmation' => $request->input('password_confirmation')
                ?? $request->input('confirm_password'),
        ];

        $validated = validator($preparedPayload, [
            'full_name' => ['required', 'string', 'max:255'],
            'phone_number' => ['required', 'string', 'max:20'],
            'address' => ['required', 'string', 'max:1000'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ])->validate();

        $user = User::create([
            'name' => $validated['full_name'],
            'phone_number' => $validated['phone_number'],
            'address' => $validated['address'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        $defaultRole = Role::firstOrCreate(
            ['name' => 'user'],
            [
                'display_name' => 'Orang Tua',
                'description' => 'Orang Tua',
            ]
        );

        $user->addRole($defaultRole);

        return response()->json([
            'message' => 'Registrasi berhasil.',
            'data' => [
                'user' => $this->transformUser($user->fresh('roles')),
            ],
        ], 201);
    }

    /**
     * @throws ValidationException
     */
    public function login(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        $user = User::where('email', $validated['email'])->first();

        if (!$user || !Hash::check($validated['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Email atau password tidak valid.'],
            ]);
        }

        $user->tokens()->delete();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login berhasil.',
            'data' => [
                'token' => $token,
                'user' => $this->transformUser($user->fresh('roles')),
                'expires_at' => null,
            ],
        ]);
    }

    public function profile(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();

        return response()->json([
            'message' => 'Profil user berhasil diambil.',
            'data' => $this->transformUser($user->loadMissing('roles')),
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();

        $user->currentAccessToken()?->delete();

        return response()->json([
            'message' => 'Logout berhasil.',
            'data' => null,
        ]);
    }

    private function transformUser(User $user): array
    {
        return [
            'id' => $user->id,
            'uid' => $user->uid,
            'name' => $user->name,
            'email' => $user->email,
            'phone_number' => $user->phone_number,
            'address' => $user->address,
            'role' => $user->roles->first()?->name,
            'email_verified_at' => $user->email_verified_at,
            'created_at' => $user->created_at,
            'updated_at' => $user->updated_at,
        ];
    }
}
