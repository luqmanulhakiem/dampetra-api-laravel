<?php

namespace App\Http\Controllers\API\Docs;

use App\Http\Requests\Api\SopCoupleStoreRequest;
use App\Http\Requests\Api\SopCoupleUpdateRequest;
use OpenApi\Attributes as OA;

interface SopCoupleDoc
{
    #[OA\Get(
        security: [["bearerAuth" => []]],
        path: "/api/v1/sop-couple",
        tags: ["Sop Couple"],
        description: "Get all sop couples",
        responses: [
            new OA\Response(
                response: 200,
                description: "Success",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "message", type: "string", example: "Success get couple SOP"),
                        new OA\Property(
                            property: "data",
                            type: "array",
                            items: new OA\Items(
                                properties: [
                                    new OA\Property(property: "id", type: "integer", example: 1),
                                    new OA\Property(property: "name", type: "string", example: "Communication"),
                                ],
                                type: "object",
                            )
                        )
                    ]
                )
            )
        ]
    )]
    public function getSops();


    #[OA\Post(
        path: "/api/v1/sop-couple",
        security: [["bearerAuth" => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["category_id"],
                properties: [
                    new OA\Property(property: "category_id", type: "integer", example: 1),
                    new OA\Property(property: "description", type: "string", example: "Your Sop Description"),
                ]
            )
        ),
        tags: ["Sop Couple"],
        responses: [
            new OA\Response(
                response: 200,
                description: "Sop Couple Stored",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "message", type: "string", example: "Sop Couple stored successfully"),
                    ]
                )
            ),
        ]
    )]
    public function storeSop(SopCoupleStoreRequest $request);


    #[OA\Put(
        path: "/api/v1/sop-couple/{id}",
        security: [["bearerAuth" => []]],
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                description: "id of sop couple",
                schema: new OA\Schema(type: "integer", example: 1)
            ),
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["category_id", "status"],
                properties: [
                    new OA\Property(property: "category_id", type: "integer", example: 1),
                    new OA\Property(property: "status", type: "enum", example: "Active", enum: ["Active", "Trial", "Archived"]),
                    new OA\Property(property: "description", type: "string", example: "Your Sop Description"),
                ]
            )
        ),
        tags: ["Sop Couple"],
        responses: [
            new OA\Response(
                response: 200,
                description: "Sop Couple Updated",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "message", type: "string", example: "Sop Couple Updated successfully"),
                    ]
                )
            ),
        ]
    )]
    public function editSop(SopCoupleUpdateRequest $request, string $id);
}
