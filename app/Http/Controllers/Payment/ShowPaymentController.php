<?php

namespace App\Http\Controllers\Payment;

use App\Application\Payment\Interface\PaymentRepositoryInterface;
use App\Domain\Payment\PaymentId;
use App\Http\Controllers\Controller;
use App\Http\Resources\PaymentResource;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class ShowPaymentController extends Controller
{
    public function __invoke(
        string $id,
        PaymentRepositoryInterface $payments,
    ): JsonResponse {
        $payment = $payments->getById(new PaymentId($id));

        return (new PaymentResource($payment))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }
}
