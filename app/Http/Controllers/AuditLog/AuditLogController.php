<?php

namespace App\Http\Controllers\AuditLog;

use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class AuditLogController extends Controller
{
    public function __invoke(): JsonResponse
    {
        return response()->json();
    }
}
