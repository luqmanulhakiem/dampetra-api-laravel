<?php

namespace App\Http\Controllers\API;

use Illuminate\Routing\Controllers\Middleware;
use App\Http\Controllers\API\Docs\CouplesDoc;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\CoupleInviteRequest;
use App\Models\Couple;
use App\Models\CoupleRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Auth;

class CouplesController extends Controller implements CouplesDoc, HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth:api', except: []),
        ];
    }

    public function getCoupleRequestsStatus()
    {
        //
    }
    public function inviteCouple(CoupleInviteRequest $request)
    {
        $data = $request->validated();
        $partner = User::where('unix_id', $data['partner_unix_id'])->first();
        $user = Auth::user();

        if ($user->preference === 'opposite' && $user->gender == $partner->gender) {
            return response()->json([
                "message" => "This user does not match your gender preferences."
            ], 422);
        }

        if (!$partner) {
            return response()->json([
                "message" => "Partner Not Found"
            ], 404);
        }

        $partnerHasCouple = Couple::where('man_id', $partner->id)->value('woman_id')
            ?? Couple::where('woman_id', $partner->id)->value('man_id');
        if ($partnerHasCouple) {
            return response()->json([
                "message" => "User Already Have Partner"
            ], 400);
        }

        CoupleRequest::create([
            "requested_id" => $user->id,
            "invited_id" => $partner->id,
        ]);

        return response()->json([
            "message" => "Invitation send to partner"
        ], 200);
    }
    public function acceptCouple()
    {
        //
    }
}
