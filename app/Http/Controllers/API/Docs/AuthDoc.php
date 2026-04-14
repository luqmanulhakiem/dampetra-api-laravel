<?php

namespace App\Http\Controllers\API\Docs;

use App\Http\Requests\API\LoginRequest;
use App\Http\Requests\API\RegisterRequest;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Request;

interface AuthDoc
{
    #[OA\Post(
        path: "/api/v1/register",
        tags: ["Authentication"],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["name", "email", "password", "gender"],
                properties: [
                    new OA\Property(property: "name", type: "string", example: "John Doe"),
                    new OA\Property(property: "email", type: "string", format: "email", example: "john@example.com"),
                    new OA\Property(property: "password", type: "string", format: "password", example: "secret123"),
                    new OA\Property(property: "gender", type: "enum", enum: ["male", "female"], example: "male")
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: "User Registered Successfully",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "message", type: "string", example: "User Registered Successfully"),
                        new OA\Property(
                            property: "data",
                            type: "object",
                            properties: [
                                new OA\Property(property: "name", type: "string", example: "John Doe"),
                                new OA\Property(property: "email", type: "string", example: "john@example.com"),
                                new OA\Property(property: "gender", type: "string", example: "male"),
                                new OA\Property(property: "unixId", type: "string", example: "DTU-000001"),
                            ]
                        ),
                    ]
                )
            ),
            new OA\Response(
                response: 422,
                description: "Error: Unprocessable Content",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: "message",
                            type: "string",
                            example: "The email has already been taken."
                        ),
                        new OA\Property(
                            property: "errors",
                            type: "object",
                            example: "{\"email\": [\"The email has already been taken.\"]}"
                        ),
                    ]
                )
            )
        ]
    )]
    public function register(RegisterRequest $request);

    #[OA\Post(
        path: "/api/v1/login",
        tags: ["Authentication"],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["email", "password"],
                properties: [
                    new OA\Property(property: "email", type: "string", format: "email", example: "john@example.com"),
                    new OA\Property(property: "password", type: "string", format: "password", example: "secret123"),
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: "User Logged In Successfully",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "message", type: "string", example: "User Logged In Successfully"),
                    ]
                )
            ),
            new OA\Response(
                response: 422,
                description: "Error: Unprocessable Content",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: "message",
                            type: "string",
                            example: "The email has already been taken."
                        ),
                        new OA\Property(
                            property: "errors",
                            type: "object",
                            example: "{\"email\": [\"The email has already been taken.\"]}"
                        ),
                    ]
                )
            )
        ]
    )]
    public function login(LoginRequest $request);

    #[OA\Post(
        security: [["bearerAuth" => []]],
        path: "/api/v1/logout",
        tags: ["Authentication"],
        responses: [
            new OA\Response(
                response: 200,
                description: "User Logged Out Successfully",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "message", type: "string", example: "User Logged Out Successfully"),
                    ]
                )
            ),
            new OA\Response(
                response: 401,
                description: "Error: Unauthorized",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "message", type: "string", example: "Unauthenticated."),
                    ]
                )
            ),
        ]
    )]
    public function logout();
}
