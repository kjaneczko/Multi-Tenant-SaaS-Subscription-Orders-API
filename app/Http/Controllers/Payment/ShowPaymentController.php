<?php

declare(strict_types=1);

namespace App\Http\Controllers\Payment;

use App\Application\Common\UseCaseExecutor;
use App\Application\Payment\Command\ShowPaymentCommand;
use App\Application\Payment\Handler\ShowPaymentHandler;
use App\Domain\Payment\PaymentId;
use App\Http\Controllers\Controller;
use App\Http\Resources\PaymentResource;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class ShowPaymentController extends Controller
{
    public function __construct(
        private readonly UseCaseExecutor $executor,
    )
    {
    }

    /**
     * @throws \Throwable
     */
    public function __invoke(
        string $id,
        ShowPaymentHandler $handler,
    ): JsonResponse
    {
        $command = new ShowPaymentCommand(new PaymentId($id));
        $payment = $this->executor->run($command, fn() => ($handler)($command));

        return (new PaymentResource($payment))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }
}
