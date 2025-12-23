<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class TenantController extends Controller
{
    public function __invoke(): JsonResponse
    {
        return response()->json();
    }
}
