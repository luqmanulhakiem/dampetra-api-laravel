<?php

namespace App\Http\Controllers\API\Docs;

use App\Http\Requests\Api\CoupleApprovalRequest;
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
    #[OA\Post(
        path: "/api/v1/couple/invite",
        security: [["bearerAuth" => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["partner_unix_id"],
                properties: [
                    new OA\Property(property: "partner_unix_id", type: "string", example: "DTU-0000002"),
                ]
            )
        ),
        tags: ["Couples"],
        responses: [
            new OA\Response(
                response: 200,
                description: "Invite Your Couple",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "message", type: "string", example: "Succes Invite Your Partner"),
                    ]
                )
            ),
        ]
    )]
    public function inviteCouple(CoupleInviteRequest $request);

    #[OA\Post(
        path: "/api/v1/couple/approval",
        security: [["bearerAuth" => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["is_accepted"],
                properties: [
                    new OA\Property(property: "is_accepted", type: "boolean", example: true),
                ]
            )
        ),
        tags: ["Couples"],
        responses: [
            new OA\Response(
                response: 200,
                description: "Approve Your Partner",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "message", type: "string", example: "Success connected with your partner"),
                    ]
                )
            ),
        ]
    )]
    public function acceptCouple(CoupleApprovalRequest $request);

    #[OA\Post(
        path: "/api/v1/couple/invite-cancel",
        security: [["bearerAuth" => []]],
        tags: ["Couples"],
        responses: [
            new OA\Response(
                response: 200,
                description: "Cancel Partner Request",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "message", type: "string", example: "success cancel your request"),
                    ]
                )
            ),
        ]
    )]
    public function cancelRequest();
}
