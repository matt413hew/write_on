<?php

namespace App\Http\Controllers;

use App\Http\Requests\loginRequest;
use App\Http\Requests\logoutRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(loginRequest $request)
    {
        $data = $request->validated();
        $user = User::where('username', $data['username'])->first();
        $token = null;
        $user->tokens()->delete();
        if (Auth::attempt([
            'username' => $data['username'],
            'password' => $data['password']
        ])) {
            $token = $user->createToken($data['username'])->plainTextToken;
            $role = $user->roles->pluck('name')->first();
            return response(['user' => $user, 'role' => $role, 'token' => $token, 'token_type' => 'Bearer', 'message' => 'success'], 200);
        } else {
            return response(['message' => 'Bad credentials'], 422);
        }
    }

    public function logout(logoutRequest $request)
    {
        $user = auth('sanctum')->user();
        $user->tokens()->delete();
        return response()->json([
            'message' => 'success'
        ], 200);
    }
}
