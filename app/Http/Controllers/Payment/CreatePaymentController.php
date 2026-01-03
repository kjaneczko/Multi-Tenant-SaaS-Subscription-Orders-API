<?php

namespace App\Http\Controllers\Payment;

use App\Application\Payment\Command\CreatePaymentCommand;
use App\Application\Payment\Handler\CreatePaymentHandler;
use App\Application\Payment\Interface\PaymentRepositoryInterface;
use App\Domain\AmountCents;
use App\Domain\AuditLog\EntityType;
use App\Domain\Currency;
use App\Domain\Payment\PaymentEntityType;
use App\Domain\Payment\PaymentId;
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
    public function __invoke(
        Request $request,
        CreatePaymentHandler $handler,
        PaymentRepositoryInterface $payments,
    ): JsonResponse {
        $validated = $request->validate([
            'tenant_id' => 'required|uuid',
            'entity_type' => [
                'required',
                Rule::in(EntityType::values()),
            ],
            'entity_id' => 'required|uuid',
            'status' => 'required|string|in:'.implode(',', PaymentStatus::values()),
            'amount_cents' => 'required|integer|min:0|max:1000000000',
            'currency' => 'required|string|in:USD,EUR',
            'provider' => 'required|string|min:1|max:255',
            'reference' => 'nullable|string|max:255',
            'external_id' => 'required|string|max:255',
        ]);

        $command = new CreatePaymentCommand(
            tenantId: new TenantId($validated['tenant_id']),
            entityType: PaymentEntityType::from($validated['entity_type']),
            entityId: $validated['entity_id'],
            status: PaymentStatus::from($validated['status']),
            amountCents: new AmountCents((int) $validated['amount_cents']),
            currency: Currency::from($validated['currency']),
            provider: $validated['provider'],
            reference: $validated['reference'] ?? null,
            externalId: $validated['external_id'],
        );

        $id = $handler($command);

        $payment = $payments->getById(new PaymentId($id->toString()));

        return (new PaymentResource($payment))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }
}
