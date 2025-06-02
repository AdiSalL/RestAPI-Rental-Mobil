<?php

namespace App\Http\Controllers;

use App\Models\User;
use GuzzleHttp\Psr7\Header;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function register(Request $request) {
        $validated = $request->validate([
            "name" => "required|string|max:255",
            "email" => "required|email|max:255|unique:users,email",
            "password" => "required|string|min:8",
            "phone_number" => "required|string|min:6"
        ]);

        $user = User::create([
            'name' => $validated["name"],
            "email" => $validated["email"],
            "password" => Hash::make($validated["password"]),
            "phone_number" => $validated["phone_number"],
            "role" => "user",
        ]);

        $user->save();

        return response()->json(['message' => 'Registrasi akun berhasil, Silahkan Login.'], 201);
    }
    
public function login(Request $request) {
    $credentials = $request->validate([
        "email" => "required|email|max:255",
        "password" => "required|string|min:8",
    ]);
        $user = User::where("email", $credentials["email"])->first();
    if (!$user || !Hash::check($credentials["password"], $user->password)) {
        return response()->json(["message" => "Login gagal. Cek username dan password."], 401);
    }

        $token = Str::random(60); 

        $userModel = User::find($user->id);
        if ($userModel) {
            $userModel->remember_token = $token;
            $userModel->save();
        }
        return response()->json([
            "message" => "Login berhasil",
            "user" => [
                "nama" => $user->name,
                "email" => $user->email,
                "token" => $token,
            ]
        ], 200);

}


public function logout(Request $request) {
        $token = $request->header('Authorization');
        if (!$token) {
            return response()->json(['message' => 'User Belum Login, Silahkan Login'], 401);
        }
        $user = User::where("remember_token", $token)->first();
        if(!$user) {
        return response()->json([
            'message' => 'User Tidak Ditemukan.',
        ], 400);
        }
        $user->remember_token = null;
        $user->update();
        return response()->json([
            'message' => 'Berhasil Logout Dari Akun.',
        ], 200);
    }


public function profile(Request $request) {
        $token = $request->header("Authorization");
        if (!$token) {
            return response()->json(['message' => 'User Belum Login, Silahkan Login Tidak Ada Token'], 401);
        }
        $userModel = User::where("remember_token", $token)->first();
        if (!$userModel) {
            return response()->json(['message' => 'User tidak ditemukan.'], 404);
        }
        return response()->json([
            "user" => [
                "name" => $userModel->name,
                "phone_number" => $userModel->phone_number,
                "email" => $userModel->email
            ]
        ]);
    }
}   