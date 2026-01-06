<?php

declare(strict_types=1);

namespace App\Http\Controllers\Order;

use App\Application\Common\UseCaseExecutor;
use App\Application\Order\Command\ShowOrderCommand;
use App\Application\Order\Handler\ShowOrderHandler;
use App\Domain\Order\OrderId;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class ShowOrderController extends Controller
{
    public function __construct(
        private readonly UseCaseExecutor $executor,
    ) {}

    /**
     * @throws \Throwable
     */
    public function __invoke(
        string $id,
        ShowOrderHandler $handler,
    ): JsonResponse {
        $command = new ShowOrderCommand(new OrderId($id));

        $order = $this->executor->run($command, fn () => ($handler)($command));

        return (new OrderResource($order))
            ->response()
            ->setStatusCode(Response::HTTP_OK)
        ;
    }
}
