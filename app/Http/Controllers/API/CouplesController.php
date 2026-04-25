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
        $authUser = Auth::user();
        $coupleReq = CoupleRequest::where("requested_id", $authUser->id)->orWhere("invited_id", $authUser->id)->first();
        if (! $coupleReq) return response()->json(['message' => "Still flying solo? Invite your partner and get connected now!"], 200);
        $inviter = User::where('id', $coupleReq->requested_id)->first();

        if ($coupleReq->requested_id == $authUser->id) {
            return response()->json(["message" => "Your request is pending. Waiting for your partner to say yes!"], 200);
        }
        if ($coupleReq->invited_id == $authUser->id) {
            return response()->json(["message" => "$inviter->name invited you to connect! Will you accept or decline?"], 200);
        }
        return response()->json(["message" => "You're all set! You are now connected with $inviter->name."], 200);
    }

    public function inviteCouple(CoupleInviteRequest $request)
    {
        $data = $request->validated();
        $partner = User::where('unix_id', $data['partner_unix_id'])->first();
        $user = Auth::user();

        if (! $partner) {
            return response()->json([
                "message" => "Partner Not Found"
            ], 404);
        }

        if ($user->gender == $partner->gender) {
            return response()->json([
                "message" => "This user does not match your gender preferences."
            ], 422);
        }

        $coupleReq = CoupleRequest::where("requested_id", $user->id)->orWhere("invited_id", $user->id)->first();
        if ($coupleReq) {
            return response()->json([
                "message" => "You already send invitation, please cancel it first to make a new one."
            ], 422);
        }

        // $partnerHasCouple = Couple::where('man_id', $partner->id)->value('woman_id')
        //     ?? Couple::where('woman_id', $partner->id)->value('man_id');
        // if ($partnerHasCouple) {
        //     return response()->json([
        //         "message" => "User Already Have Partner"
        //     ], 400);
        // }

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

    public function cancelRequest()
    {
        $auth = Auth::user();
        $coupleReq = CoupleRequest::where("requested_id", $auth->id)->first();
        if (! $coupleReq) {
            return response()->json(['message' => "you doesn't have any requested pending"], 200);
        }
        $coupleReq->delete();
        return response()->json(['message' => "success cancel your request"], 200);
    }
}
