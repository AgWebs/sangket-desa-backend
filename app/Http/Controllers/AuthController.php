<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Daftar akun baru, langsung mengembalikan token supaya user tidak perlu
     * login manual lagi setelah register.
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            // 'confirmed' berarti wajib ada field 'password_confirmation' yang sama
            'password' => 'required|string|min:8|confirmed',
        ]);

        // TIDAK perlu Hash::make() manual — kolom 'password' di model User
        // sudah pakai cast 'hashed' yang otomatis meng-hash saat disimpan.
        // Kalau di-hash manual di sini, passwordnya akan double-hashed dan
        // login jadi selalu gagal.
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
        ], 201);
    }

    /**
     * Login dan kembalikan personal access token (Bearer token) yang dipakai
     * frontend untuk setiap request selanjutnya.
     */
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $validated['email'])->first();

        if (!$user || !Hash::check($validated['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Email atau password salah.'],
            ]);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
        ]);
    }

    /**
     * Cabut token yang sedang dipakai (logout dari device/browser ini saja).
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Berhasil logout']);
    }
}
