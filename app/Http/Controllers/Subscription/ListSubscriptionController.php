<?php

declare(strict_types=1);

namespace App\Http\Controllers\Subscription;

use App\Application\Common\Query\PageRequest;
use App\Application\Common\UseCaseExecutor;
use App\Application\Subscription\Command\ListSubscriptionCommand;
use App\Application\Subscription\Handler\ListSubscriptionHandler;
use App\Domain\Subscription\SubscriptionStatus;
use App\Domain\Tenant\TenantId;
use App\Domain\User\UserId;
use App\Http\Controllers\Controller;
use App\Http\Resources\SubscriptionResource;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class ListSubscriptionController extends Controller
{
    public function __construct(
        private readonly UseCaseExecutor $executor,
    ) {}

    /**
     * @throws \Throwable
     */
    public function __invoke(
        Request $request,
        ListSubscriptionHandler $handler,
    ): JsonResponse {
        $request->validate([
            'page' => 'sometimes|integer|min:1',
            'limit' => 'sometimes|integer|min:1|max:100',
            'tenant_id' => 'sometimes|uuid',
            'created_by_user_id' => 'sometimes|uuid',
            'status' => 'sometimes|string|in:active,paused,cancelled',
        ]);

        $pageRequest = new PageRequest(
            page: $request->integer('page', 1),
            limit: $request->integer('limit', 25),
        );

        $tenantId = $request->filled('tenant_id')
            ? new TenantId($request->string('tenant_id')->toString())
            : null;

        $createdByUserId = $request->filled('created_by_user_id')
            ? new UserId($request->string('created_by_user_id')->toString())
            : null;

        $status = $request->filled('status')
            ? SubscriptionStatus::from($request->string('status')->toString())
            : null;

        $command = new ListSubscriptionCommand(
            pageRequest: $pageRequest,
            tenantId: $tenantId,
            createdByUserId: $createdByUserId,
            status: $status,
        );

        $subscriptions = $this->executor->run($command, fn () => ($handler)($command));

        return SubscriptionResource::collection($subscriptions)
            ->response()
            ->setStatusCode(Response::HTTP_OK)
        ;
    }
}
