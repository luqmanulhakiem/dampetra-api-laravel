<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\Docs\DailyEmotionDoc;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\DailyEmotionStoreRequest;
use App\Http\Resources\DailyEmotionResource;
use App\Models\DailyEmotion;
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

    public function getSelfDailyEmotion()
    {
        //
    }

    public function getPartnerDailyEmotion()
    {
        //
    }

    public function store(DailyEmotionStoreRequest $request)
    {
        $auth = Auth::user();
        $data = $request->validated();
        $now = Carbon::now();
        $now->format('yyyy-mm-dd hh:mm:ss');
        $data['user_id'] = $auth->id;
        $data['log_date'] = $now;

        DailyEmotion::create($data);

        return response()->json([
            "message" => "Success store daily emotion",
            "data" => new DailyEmotionResource($data)
        ], 200);
    }
}
