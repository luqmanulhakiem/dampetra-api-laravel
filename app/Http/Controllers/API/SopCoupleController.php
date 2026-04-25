<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\Docs\SopCoupleDoc;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SopCoupleStoreRequest;
use App\Http\Requests\Api\SopCoupleUpdateRequest;
use App\Http\Resources\SopCoupleResource;
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
            return response()->json($couple, 200);
            return response()->json(['message' => "You need to connect with your partner first"], 200);
        }

        $data = SopCouple::where('couple_id', $couple->id)->with(['category'])->get();
        return response()->json(['message' => "Success get partner sop", "data" => SopCoupleResource::collection($data)], 200);
    }

    public function storeSop(SopCoupleStoreRequest $request)
    {
        $data = $request->validated();
        $auth = Auth::user();
        $couple = Couple::where('man_id', $auth->id)->orWhere('woman_id', $auth->id)->first();
        if (!$couple) {
            return response()->json(['message' => "You need to connect with your partner first"], 200);
        }
        $data['couple_id'] = $couple->id;

        SopCouple::create($data);
        return response()->json(['message' => 'Sop Couple stored successfully'], 200);
    }

    public function editSop(SopCoupleUpdateRequest $request, string $id)
    {
        $data = $request->validated();
        $auth = Auth::user();
        $couple = Couple::where('man_id', $auth->id)->orWhere('woman_id', $auth->id)->first();
        if (!$couple) {
            return response()->json(['message' => "You need to connect with your partner first"], 200);
        }
        $sopCouple = SopCouple::findorfail($id);
        $sopCouple->update($data);

        return response()->json(['message' => 'Sop Couple Updated successfully'], 200);
    }
}
