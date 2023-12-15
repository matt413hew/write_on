<?php

namespace App\Http\Controllers;

use App\Http\Requests\addUserRequest;
use App\Http\Requests\getRolesRequest;
use App\Http\Requests\loginRequest;
use App\Http\Requests\logoutRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AuthController extends Controller
{
    public function login(loginRequest $request)
    {
        $data = $request->validated();
        $user = User::where('username', $data['username'])->first();
        $token = null;
        $user->tokens()->delete();
        if (!$user->active) {
            return response(['message' => 'Entered credentials of a deactivated account'], 422);
        }
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

    public function addUser(addUserRequest $request)
    {
        $data = $request->validated();
        $user = User::create([
            'username' => $data['username'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'password' => Hash::make($data['username']),
        ]);
        if ($user) {
            $user->assignRole($data['role']);
        }
        return response(['message' => 'success', 'data' => $user]);
    }

    public function getRoles(getRolesRequest $request)
    {
        return Role::all();
    }
}
