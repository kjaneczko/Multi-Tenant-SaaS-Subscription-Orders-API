<?php

declare(strict_types=1);

namespace App\Http\Controllers\OrderItem;

use App\Application\Common\UseCaseExecutor;
use App\Application\OrderItem\Command\ShowOrderItemCommand;
use App\Application\OrderItem\Handler\ShowOrderItemHandler;
use App\Domain\OrderItem\OrderItemId;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderItemResource;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class ShowOrderItemController extends Controller
{
    public function __construct(
        private readonly UseCaseExecutor $executor,
    ) {}

    /**
     * @throws \Throwable
     */
    public function __invoke(
        string $id,
        ShowOrderItemHandler $handler,
    ): JsonResponse {
        $command = new ShowOrderItemCommand(new OrderItemId($id));

        $orderItem = $this->executor->run($command, fn () => ($handler)($command));

        return (new OrderItemResource($orderItem))
            ->response()
            ->setStatusCode(Response::HTTP_OK)
        ;
    }
}
