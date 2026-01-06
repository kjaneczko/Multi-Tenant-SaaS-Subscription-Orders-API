<?php

use App\Application\AuditLog\Exception\AuditLogNotFoundException;
use App\Application\Order\Exception\OrderNotFoundException;
use App\Application\OrderItem\Exception\OrderItemNotFoundException;
use App\Application\Payment\Exception\PaymentNotFoundException;
use App\Application\Product\Exception\ProductNotFoundException;
use App\Application\Subscription\Exception\SubscriptionNotFoundException;
use App\Application\User\Exception\UserNotFoundException;
use App\Domain\Exception\ValidationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {})
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (ValidationException $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'errors' => $e->getErrors(),
            ], 422);
        });

        $exceptions->render(function (AuditLogNotFoundException $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'errors' => [],
            ], 404);
        });

        $exceptions->render(function (UserNotFoundException $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'errors' => [],
            ], 404);
        });

        $exceptions->render(function (ProductNotFoundException $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'errors' => [],
            ], 404);
        });

        $exceptions->render(function (PaymentNotFoundException $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'errors' => [],
            ], 404);
        });

        $exceptions->render(function (OrderNotFoundException $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'errors' => [],
            ], 404);
        });

        $exceptions->render(function (OrderItemNotFoundException $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'errors' => [],
            ], 404);
        });

        $exceptions->render(function (SubscriptionNotFoundException $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'errors' => [],
            ], 404);
        });

        $exceptions->render(function (DateMalformedStringException $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'errors' => []
            ], 422);
        });
    })->create()
;
