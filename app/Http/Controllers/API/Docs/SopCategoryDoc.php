<?php

namespace App\Http\Controllers\API\Docs;

use Illuminate\Container\Attributes\Tag;
use OpenApi\Attributes as OA;

interface SopCategoryDoc
{
    #[OA\Get(
        security: [["bearerAuth" => []]],
        path: "/api/v1/sop-categories",
        tags: ["Sop Categories"],
        description: "Get all sop categories",
        responses: [
            new OA\Response(
                response: 200,
                description: "Success",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "message", type: "string", example: "Success get sop categories"),
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
    public function index();
}
