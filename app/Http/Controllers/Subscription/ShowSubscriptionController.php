<?php

declare(strict_types=1);

namespace App\Http\Controllers\Subscription;

use App\Application\Common\UseCaseExecutor;
use App\Application\Subscription\Command\ShowSubscriptionCommand;
use App\Application\Subscription\Handler\ShowSubscriptionHandler;
use App\Domain\Subscription\SubscriptionId;
use App\Http\Controllers\Controller;
use App\Http\Resources\SubscriptionResource;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class ShowSubscriptionController extends Controller
{
    public function __construct(
        private readonly UseCaseExecutor $executor,
    ) {}

    /**
     * @throws \Throwable
     */
    public function __invoke(
        string $id,
        ShowSubscriptionHandler $handler,
    ): JsonResponse {
        $command = new ShowSubscriptionCommand(new SubscriptionId($id));

        $subscription = $this->executor->run($command, fn () => ($handler)($command));

        return (new SubscriptionResource($subscription))
            ->response()
            ->setStatusCode(Response::HTTP_OK)
        ;
    }
}
