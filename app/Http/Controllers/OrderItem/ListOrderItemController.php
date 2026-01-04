<?php

declare(strict_types=1);

namespace App\Http\Controllers\OrderItem;

use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class ListOrderItemController extends Controller
{
    public function __invoke(): JsonResponse
    {
        return response()->json();
    }
}
