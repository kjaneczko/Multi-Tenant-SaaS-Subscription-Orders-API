<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class OrderController extends Controller
{
    public function __invoke(): JsonResponse
    {
        return response()->json();
    }
}
