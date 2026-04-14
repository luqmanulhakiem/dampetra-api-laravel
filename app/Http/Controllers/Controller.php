<?php

namespace App\Http\Controllers;

use App\Http\Controllers\API\Docs\AppDoc;
use OpenApi\Attributes as OA;

#[OA\Info(
    version: "1.0.0",
    title: "Dampetra API",
    description: "API documentation for Dampetra Apps",
)]

abstract class Controller
{
    //
}

class AppController extends Controller implements AppDoc
{
    public function app() {}
}
