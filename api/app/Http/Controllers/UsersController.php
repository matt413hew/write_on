<?php

namespace App\Http\Controllers;

use App\Http\Requests\activateUserRequest;
use App\Http\Requests\getUsersRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function getUsers(getUsersRequest $request)
    {
        return User::with('roles')->orderBy('id', 'desc')->paginate(5);
    }

    public function activateUser(activateUserRequest $request)
    {
        $data = $request->validated();
        $user = User::find($data['id']);
        $user->update(['active' => !$user['active']]);
        return response(['message' => 'success'], 200);
    }
}
