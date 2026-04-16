<?php

namespace App\Http\Controllers\API\Docs;

use OpenApi\Attributes as OA;
use App\Http\Requests\API\DailyEmotionStoreRequest;

interface DailyEmotionDoc
{
    public function getSelfDailyEmotion();

    public function getPartnerDailyEmotion();

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
