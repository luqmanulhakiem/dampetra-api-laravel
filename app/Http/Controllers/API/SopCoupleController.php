<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\Docs\SopCoupleDoc;
use App\Http\Controllers\Controller;
use App\Models\Couple;
use App\Models\SopCouple;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Auth;

class SopCoupleController extends Controller implements SopCoupleDoc, HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth:api', except: []),
        ];
    }

    public function getSops()
    {
        $auth = Auth::user();
        $couple = Couple::where('man_id', $auth->id)->orWhere('woman_id', $auth->id)->first();
        if (!$couple) {
            return response()->json(['message' => "You need to connect with your partner first"], 200);
        }

        $data = SopCouple::where('couple_id', $couple->id)->get();
        return response()->json(['message' => "Success get partner sop", "data" => $data], 200);
    }
    public function storeSop()
    {
        //
    }
    public function editSop()
    {
        //
    }
}
