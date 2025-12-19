<?php

namespace app\Http\Controllers\Subscription;

use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class SubscriptionController extends Controller
{
    public function __invoke(): JsonResponse
    {
        return response()->json();
    }
}
