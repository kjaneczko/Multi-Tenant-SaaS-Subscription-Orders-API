<?php

namespace app\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class PaymentController extends Controller
{
    public function __invoke(): JsonResponse
    {
        return response()->json();
    }
}
