<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\Docs\AuthDoc;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller implements AuthDoc
{

    public function register(RegisterRequest $request)
    {
        $data = $request->validated();

        $data["password"] = Hash::make($data["password"]);

        $user = User::create($data);

        return new UserResource($user);
    }

    // public function login(Request $request)
    // {
    //     //TODO: Implement login logic
    // }

    // public function logout(Request $request)
    // {
    //     // TODO: Implement logout logic
    // }
}
