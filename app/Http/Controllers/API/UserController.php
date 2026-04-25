<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\Docs\UserDoc;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller implements UserDoc, HasMiddleware
{

    public static function middleware(): array
    {
        return [
            new Middleware('auth:api', except: []),
        ];
    }

    public function index()
    {
        $user = Auth::user();
        $data = new UserResource($user);

        return response()->json([
            "message" => "Success get data user",
            "data" => $data
        ], 200);
    }

    public function getAllUser()
    {
        $user = User::all();
        return response()->json([
            "message" => "Success get all user",
            "data" =>  UserResource::collection($user),
        ], 200);
    }
}
