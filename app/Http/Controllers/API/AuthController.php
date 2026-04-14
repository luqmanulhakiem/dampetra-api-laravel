<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\Docs\AuthDoc;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\LoginRequest;
use App\Http\Requests\API\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller implements AuthDoc, HasMiddleware
{

    public static function middleware(): array
    {
        return [
            // This applies 'auth:api' to everything EXCEPT 'login' and 'register'
            new Middleware('auth:api', except: ['login', 'register']),
        ];
    }

    public function register(RegisterRequest $request)
    {
        $data = $request->validated();

        $data["password"] = Hash::make($data["password"]);

        $user = User::create($data);

        return new UserResource($user);
    }

    public function login(LoginRequest $request)
    {
        $data = $request->validated();

        $user = User::where("email", $data["email"])->first();

        if (!$user || !Hash::check($data["password"], $user->password)) return response()->json(['message' => 'Invalid email or password'], 401);
        if ($user->email_verified_at === null) return response()->json(['message' => 'Account not verified, please check your email to verify'], 403);
        if (! $token = JWTAuth::attempt($data)) return response()->json(['error' => 'Unauthorized'], 401);

        return response()->json([
            "message" => "Login Successful",
            "access_token" => $token,
            "data" => [
                "user" => new  UserResource($user),
            ],
        ], 200);
    }

    public function logout()
    {
        JWTAuth::logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(JWTAuth::refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' =>
            JWTAuth::factory()->getTTL() * 60,
        ]);
    }
}
