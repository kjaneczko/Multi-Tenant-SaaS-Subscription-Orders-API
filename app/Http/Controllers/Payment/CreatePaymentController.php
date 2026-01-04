<?php

declare(strict_types=1);

namespace App\Http\Controllers\Payment;

use App\Application\Common\UseCaseExecutor;
use App\Application\Payment\Command\CreatePaymentCommand;
use App\Application\Payment\Handler\CreatePaymentHandler;
use App\Domain\AmountCents;
use App\Domain\Currency;
use App\Domain\Payment\PaymentEntityType;
use App\Domain\Payment\PaymentStatus;
use App\Domain\Tenant\TenantId;
use App\Http\Controllers\Controller;
use App\Http\Resources\PaymentResource;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class CreatePaymentController extends Controller
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
        Request $request,
        CreatePaymentHandler $handler,
    ): JsonResponse
    {
        $request->validate([
            'tenant_id' => 'required|uuid',
            'entity_type' => ['required', 'string', Rule::in(PaymentEntityType::values())],
            'entity_id' => 'required|uuid',
            'status' => ['required', 'string', Rule::in(PaymentStatus::values())],
            'amount_cents' => 'required|integer|min:1|max:1000000000',
            'currency' => ['required', 'string', Rule::in(Currency::values())],
            'provider' => 'required|string|min:1|max:50',
            'reference' => 'nullable|string|max:100',
            'external_id' => 'required|string|max:255',
        ]);

        $command = new CreatePaymentCommand(
            tenantId: new TenantId($request->get('tenant_id')),
            entityType: PaymentEntityType::from($request->get('entity_type')),
            entityId: $request->get('entity_id'),
            status: PaymentStatus::from($request->get('status')),
            amountCents: new AmountCents($request->integer('amount_cents')),
            currency: Currency::from($request->get('currency')),
            provider: $request->get('provider'),
            reference: $request->get('reference') ?? null,
            externalId: $request->get('external_id') ?? null,
        );

        $payment = $this->executor->run($command, fn() => ($handler)($command));

        return (new PaymentResource($payment))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED)
        ;
    }
}
