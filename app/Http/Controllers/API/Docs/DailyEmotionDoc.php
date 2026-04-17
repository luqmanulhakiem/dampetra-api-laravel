<?php

namespace App\Http\Controllers\API\Docs;

use Illuminate\Http\Request;
use OpenApi\Attributes as OA;
use App\Http\Requests\API\DailyEmotionStoreRequest;

interface DailyEmotionDoc
{
    #[OA\Get(
        path: "/api/v1/daily-emotion/me",
        security: [["bearerAuth" => []]],
        tags: ["Daily Emotions"],
        parameters: [
            new OA\Parameter(
                name: "date",
                in: "query",
                required: false,
                description: "Date of the daily emotion log (format: yyyy-mm-dd)",
                schema: new OA\Schema(type: "string", format: "date", example: "2024-01-01")
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Success get self daily emotion",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "message", type: "string", example: "Success get self daily emotion"),
                        new OA\Property(
                            property: "data",
                            type: "object",
                            properties: [
                                new OA\Property(property: "mood", type: "string", example: "Neutral"),
                                new OA\Property(property: "notes", type: "string", example: "here is your notes"),
                                new OA\Property(property: "logDate", type: "date", example: "yyyy-MM-dd"),
                            ],
                        )
                    ]
                )
            ),
        ]
    )]
    public function getSelfDailyEmotion(Request $request);


    #[OA\Get(
        path: "/api/v1/daily-emotion/partner",
        security: [["bearerAuth" => []]],
        tags: ["Daily Emotions"],
        parameters: [
            new OA\Parameter(
                name: "date",
                in: "query",
                required: false,
                description: "Date of the daily emotion log (format: yyyy-mm-dd)",
                schema: new OA\Schema(type: "string", format: "date", example: "2024-01-01")
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Success get partner daily emotion",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "message", type: "string", example: "Success get partner daily emotion"),
                        new OA\Property(
                            property: "data",
                            type: "object",
                            properties: [
                                new OA\Property(property: "mood", type: "string", example: "Neutral"),
                                new OA\Property(property: "notes", type: "string", example: "here is your notes"),
                                new OA\Property(property: "logDate", type: "date", example: "yyyy-MM-dd"),
                            ],
                        )
                    ]
                )
            ),
        ]
    )]
    public function getPartnerDailyEmotion(Request $request);

    #[OA\Post(
        path: "/api/v1/daily-emotion",
        security: [["bearerAuth" => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["mood"],
                properties: [
                    new OA\Property(property: "mood", type: "enum", format: "email", example: "Angry", enum: ["Angry", "Sad", "Neutral", "Happy", "Radiant"]),
                    new OA\Property(property: "notes", type: "string", format: "notes", example: "your notes here"),
                ]
            )
        ),
        tags: ["Daily Emotions"],
        responses: [
            new OA\Response(
                response: 200,
                description: "Daily emotion stored successfully",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "message", type: "string", example: "Daily emotion stored successfully"),
                    ]
                )
            ),
        ]
    )]
    public function store(DailyEmotionStoreRequest $request);
}
