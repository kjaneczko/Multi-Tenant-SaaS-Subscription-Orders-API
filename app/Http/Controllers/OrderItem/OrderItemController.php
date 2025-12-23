<?php

namespace App\Http\Controllers\OrderItem;

use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class OrderItemController extends Controller
{
    public function __invoke(): JsonResponse
    {
        return response()->json();
    }
}
