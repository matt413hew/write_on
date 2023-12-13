<?php

namespace App\Http\Controllers;

use App\Http\Requests\loginRequest;
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
        if (!Auth::attempt([
            'username' => $data['username'],
            'password' => $data['password']
        ])) {
            $token = $user->createToken($data['email'])->plainTextToken;
        }
        return response(auth('sanctum')->user());
    }
}
