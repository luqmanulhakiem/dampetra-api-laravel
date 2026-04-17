<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\Docs\DailyEmotionDoc;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\DailyEmotionStoreRequest;
use App\Http\Resources\DailyEmotionResource;
use App\Models\Couple;
use App\Models\DailyEmotion;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Auth;

class DailyEmotionController extends Controller implements DailyEmotionDoc, HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth:api', except: []),
        ];
    }

    public function getSelfDailyEmotion(Request $request)
    {
        $user = Auth::user();
        $date = $request->query('date');
        $data = DailyEmotion::where('user_id', $user->id)
            ->when($date, function ($query) use ($date) {
                return $query->whereDate('log_date', $date);
            })
            ->get();


        return response()->json([
            "message" => "Success get self daily emotion",
            "data" => DailyEmotionResource::collection($data),
        ], 200);
    }

    public function getPartnerDailyEmotion(Request $request)
    {
        $date = $request->query('date');
        $user = User::findorfail(Auth::user()->id);

        $partnerId = Couple::where('man_id', $user->id)->value('woman_id')
            ?? Couple::where('woman_id', $user->id)->value('man_id');

        if (!$partnerId) {
            return response()->json(["message" => "You don't have a partner"], 400);
        }

        $data = DailyEmotion::where('user_id', $partnerId)
            ->when($date, fn($q) => $q->whereDate('log_date', $date))
            ->get();

        return response()->json([
            "message" => "Success get partner daily emotion",
            "data" => DailyEmotionResource::collection($data),
        ], 200);
    }

    public function store(DailyEmotionStoreRequest $request)
    {
        $auth = Auth::user();
        $data = $request->validated();
        $dataExist = DailyEmotion::where('user_id', $auth->id)
            ->whereDate('log_date', Carbon::today())
            ->exists();
        if ($dataExist) {
            return response()->json(["message" => "You have already logged your daily emotion today"], 400);
        }
        $now = Carbon::now();
        $now->format('yyyy-mm-dd hh:mm:ss');
        $data['user_id'] = $auth->id;
        $data['log_date'] = $now;

        $emotion =   DailyEmotion::create($data);

        return response()->json([
            "message" => "Success store daily emotion",
            "data" => new DailyEmotionResource($emotion)
        ], 200);
    }
}
