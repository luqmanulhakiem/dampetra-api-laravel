<?php

namespace App\Http\Controllers\API\Docs;

use OpenApi\Attributes as OA;

interface AppDoc
{
    #[OA\Get(
        path: "/api/v1",
        tags: ["App"],
        responses: [
            new OA\Response(
                response: 200,
                description: "API version 1",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "message", type: "string", example: "String"),
                    ]
                )
            ),
        ]
    )]
    public function app();
}
