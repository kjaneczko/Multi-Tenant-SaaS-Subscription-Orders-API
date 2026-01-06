<?php

declare(strict_types=1);

namespace App\Http\Controllers\Subscription;

use App\Application\Common\UseCaseExecutor;
use App\Application\Subscription\Command\CreateSubscriptionCommand;
use App\Application\Subscription\Handler\CreateSubscriptionHandler;
use App\Domain\Currency;
use App\Domain\PriceCents;
use App\Domain\Subscription\SubscriptionInterval;
use App\Domain\Subscription\SubscriptionPlan;
use App\Domain\Subscription\SubscriptionStatus;
use App\Domain\Tenant\TenantId;
use App\Domain\User\UserId;
use App\Http\Controllers\Controller;
use App\Http\Resources\SubscriptionResource;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CreateSubscriptionController extends Controller
{
    public function __construct(
        private readonly UseCaseExecutor $executor,
    ) {}

    /**
     * @throws \Throwable
     */
    public function __invoke(
        Request $request,
        CreateSubscriptionHandler $handler,
    ): JsonResponse {
        $request->validate([
            'tenant_id' => 'required|uuid',
            'created_by_user_id' => 'required|uuid',
            'status' => 'required|string|in:active,paused,cancelled',
            'currency' => 'required|string|in:USD,EUR',
            'price_cents' => 'required|integer|min:0|max:1000000000',
            'plan' => 'required|string',
            'interval' => 'required|string',
            'started_at' => 'required|date',
            'current_period_start' => 'required|date',
            'current_period_end' => 'required|date',
            'cancelled_at' => 'nullable|date',
            'ended_at' => 'nullable|date',
        ]);

        $command = new CreateSubscriptionCommand(
            tenantId: new TenantId($request->get('tenant_id')),
            createdByUserId: new UserId($request->get('created_by_user_id')),
            status: SubscriptionStatus::from($request->get('status')),
            currency: Currency::from($request->get('currency')),
            priceCents: new PriceCents($request->integer('price_cents')),
            plan: SubscriptionPlan::from($request->get('plan')),
            interval: SubscriptionInterval::from($request->get('interval')),
            startedAt: new \DateTimeImmutable($request->get('started_at')),
            endedAt: $request->get('ended_at') ? new \DateTimeImmutable($request->get('ended_at')) : null,
            currentPeriodStart: new \DateTimeImmutable($request->get('current_period_start')),
            currentPeriodEnd: new \DateTimeImmutable($request->get('current_period_end')),
            cancelledAt: $request->get('cancelled_at') ? new \DateTimeImmutable($request->get('cancelled_at')) : null,
        );

        $subscription = $this->executor->run($command, fn () => ($handler)($command));

        return (new SubscriptionResource($subscription))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED)
        ;
    }
}
