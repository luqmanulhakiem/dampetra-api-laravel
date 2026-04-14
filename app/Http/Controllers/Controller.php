<?php

namespace App\Http\Controllers;

use App\Http\Controllers\API\Docs\AppDoc;
use OpenApi\Attributes as OA;

#[OA\Info(
    version: "1.0.0",
    title: "Dampetra API",
    description: "API documentation for Dampetra Apps",
)]
#[OA\SecurityScheme(
    securityScheme: "bearerAuth",
    type: "http",
    description: "Enter JWT Bearer token",
    scheme: "bearer",
    bearerFormat: "JWT"
)]

abstract class Controller
{
    //
}

class AppController extends Controller implements AppDoc
{
    public function app() {}
}
