<?php

namespace App\Http\Controllers\API\Docs;

use App\Http\Requests\API\CoupleInviteRequest;
use OpenApi\Attributes as OA;


interface CouplesDoc
{
    #[OA\Get(
        security: [["bearerAuth" => []]],
        path: "/api/v1/couple/request-status",
        tags: ["Couples"],
        description: "Get couple request status",
        responses: [
            new OA\Response(
                response: 200,
                description: "Success",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "message", type: "string", example: "Still flying solo? Invite your partner and get connected now!"),
                    ]
                )
            )
        ]
    )]
    public function getCoupleRequestsStatus();
    public function inviteCouple(CoupleInviteRequest $request);
    public function acceptCouple();
}
