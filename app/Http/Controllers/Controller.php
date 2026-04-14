<?php

namespace App\Http\Controllers;

use OpenApi\Attributes as OA;

#[OA\Info(
    version: "1.0.0",
    title: "My Application API",
    description: "API documentation for My Application",
    contact: new OA\Contact(
        name: "API Support",
        email: "support@example.com",
        url: "https://example.com/support"
    ),
    license: new OA\License(
        name: "Apache 2.0",
        url: "https://www.apache.org/licenses/LICENSE-2.0.html"
    )
)]
#[OA\Server(
    url: "http://localhost:8000",
    description: "Local development server"
)]
#[OA\Server(
    url: "https://api.example.com",
    description: "Production server"
)]

abstract class Controller
{
    //
}
