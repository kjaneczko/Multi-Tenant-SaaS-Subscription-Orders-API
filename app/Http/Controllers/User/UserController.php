<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class UserController extends Controller
{
    public function __invoke(): JsonResponse
    {
        return response()->json();
    }
}
