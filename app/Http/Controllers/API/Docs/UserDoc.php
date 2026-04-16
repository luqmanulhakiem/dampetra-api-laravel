<?php

namespace App\Http\Controllers\API\Docs;

use OpenApi\Attributes as OA;

interface UserDoc
{

    #[OA\Get(
        security: [["bearerAuth" => []]],
        path: "/api/v1/users/me",
        tags: ["Users"],
        description: "Get auth user information",
        responses: [
            new OA\Response(
                response: 200,
                description: "Success",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "message", type: "string", example: "Success get data user"),
                        new OA\Property(
                            property: "data",
                            type: "object",
                            properties: [
                                new OA\Property(property: "name", type: "string", example: "John Doe"),
                                new OA\Property(property: "email", type: "string", example: "john.doe@example.com"),
                                new OA\Property(property: "gender", type: "string", example: "male"),
                                new OA\Property(property: "unixId", type: "string", example: "DTU-000001"),
                                new OA\Property(property: "hasPartner", type: "bool", example: false),



                            ],
                        )
                    ]
                )
            )
        ]
    )]
    public function index();
}
