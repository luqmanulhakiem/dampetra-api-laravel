<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\Docs\SopCategoryDoc;
use App\Http\Controllers\Controller;
use App\Models\SopCategory;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class SopCategoryController extends Controller implements SopCategoryDoc, HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth:api', except: []),
        ];
    }


    public function index()
    {
        $data = SopCategory::all(['id', 'name']);

        return response()->json([
            'message' => "Success get sop categories",
            'data' => $data,
        ], 200);
    }
}
