<?php

namespace app\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class ProductController extends Controller
{
    public function __invoke(): JsonResponse
    {
        return response()->json();
    }
}
