<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\Docs\AuthDoc;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\LoginRequest;
use App\Http\Requests\API\OtpRequest;
use App\Http\Requests\API\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Mail\SendOtpMail;
use App\Models\User;
use App\Notifications\SendOTPVerification;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller implements AuthDoc, HasMiddleware
{
    /**
     * Define middleware for the controller. This will apply 'auth:api' to all routes except 'login', 'register', and 'verify'.
     */
    public static function middleware(): array
    {
        return [
            // This applies 'auth:api' to everything EXCEPT 'login' and 'register'
            new Middleware('auth:api', except: ['login', 'register', 'verify']),
        ];
    }

    public function register(RegisterRequest $request)
    {
        $data = $request->validated();

        $data["password"] = Hash::make($data["password"]);

        $user = User::create($data);

        // event(new Registered($user));
        $this->sendOtp($user);

        return response()->json(['data' => new UserResource($user)], 200);
    }

    /**
     * Send OTP to user email for verification
     * @param User $user
     */
    public function sendOtp(User $user)
    {
        $otp = rand(100000, 999999);
        $user->otp = $otp;
        $user->otp_expires_at = \Carbon\Carbon::now()->addMinutes(10);
        $user->save();

        Mail::to($user->email)->send(new SendOtpMail($otp, $user->name));
    }

    public function resentOtp()
    {
        $user = Auth::user();

        if ($user->email_verified_at !== null) {
            return response()->json(['message' => 'Account already verified'], 400);
        }

        if ($user->otp_expires_at && now()->parse($user->otp_expires_at)->subMinutes(9)->isFuture()) {
            return response()->json([
                'message' => 'Please wait before requesting a new code.'
            ], 429);
        }

        $this->sendOtp($user);

        return response()->json(['message' => 'OTP resent successfully'], 200);
    }


    public function login(LoginRequest $request)
    {
        $data = $request->validated();

        $user = User::where("email", $data["email"])->first();

        if (!$user || !Hash::check($data["password"], $user->password)) return response()->json(['message' => 'Invalid email or password'], 401);
        // if ($user->email_verified_at === null) return response()->json(['message' => 'Account not verified, please check your email to verify'], 403);
        if (! $token = JWTAuth::attempt($data)) return response()->json(['error' => 'Unauthorized'], 401);

        return response()->json([
            "message" => "Login Successful",
            "data" => [
                "access_token" => $token,
                "user" => new  UserResource($user),
                "is_verified" => $user->email_verified_at != null ? false : true,
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
