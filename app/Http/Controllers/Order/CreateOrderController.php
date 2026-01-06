<?php

declare(strict_types=1);

namespace App\Http\Controllers\Order;

use App\Application\Common\UseCaseExecutor;
use App\Application\Order\Command\CreateOrderCommand;
use App\Application\Order\Handler\CreateOrderHandler;
use App\Domain\AmountCents;
use App\Domain\Currency;
use App\Domain\Email;
use App\Domain\Tenant\TenantId;
use App\Domain\User\UserId;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CreateOrderController extends Controller
{
    public function __construct(
        private readonly UseCaseExecutor $executor,
    ) {}

    /**
     * @throws \Throwable
     */
    public function __invoke(
        Request $request,
        CreateOrderHandler $handler,
    ): JsonResponse {
        $request->validate([
            'tenant_id' => 'required|uuid',
            'created_by_user_id' => 'nullable|uuid',
            'customer_email' => 'required|email|max:255',
            'status' => 'required|string|in:new,pending,paid,cancelled',
            'currency' => 'required|string|in:USD,EUR',
            'subtotal_cents' => 'sometimes|integer|min:0|max:1000000000',
            'discount_cents' => 'sometimes|integer|min:0|max:1000000000',
            'tax_cents' => 'sometimes|integer|min:0|max:1000000000',
            'total_cents' => 'sometimes|integer|min:0|max:1000000000',
            'notes' => 'nullable|string|max:2000',
            'paid_at' => 'nullable|date',
            'refunded_at' => 'nullable|date',
            'cancelled_at' => 'nullable|date',
        ]);

        $command = new CreateOrderCommand(
            tenantId: new TenantId($request->get('tenant_id')),
            createdByUserId: new UserId($request->get('created_by_user_id')),
            customerEmail: new Email($request->get('customer_email')),
            status: $request->get('status'),
            currency: Currency::from($request->get('currency')),
            subtotalCents: new AmountCents($request->integer('subtotal_cents', 0)),
            discountCents: new AmountCents($request->integer('discount_cents', 0)),
            taxCents: new AmountCents($request->integer('tax_cents', 0)),
            totalCents: new AmountCents($request->integer('total_cents', 0)),
            notes: $request->get('notes') ?? null,
            paidAt: $request->get('paid_at') ?? null,
            refundedAt: $request->get('refunded_at') ?? null,
            cancelledAt: $request->get('cancelled_at') ?? null,
        );

        $order = $this->executor->run($command, fn () => ($handler)($command));

        return (new OrderResource($order))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED)
        ;
    }
}
