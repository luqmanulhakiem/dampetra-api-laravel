<?php

namespace App\Http\Controllers\API\Docs;

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

    public function storeSop();

    public function editSop();
}
