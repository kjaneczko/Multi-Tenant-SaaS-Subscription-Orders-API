<?php

namespace App\Http\Controllers\Payment;

use App\Application\Payment\Command\CreatePaymentCommand;
use App\Application\Payment\Interface\PaymentServiceInterface;
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
    public function __invoke(Request $request, PaymentServiceInterface $service): JsonResponse
    {
        $validated = $request->validate([
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

        $payment = $service->create(
            new CreatePaymentCommand(
                tenantId: new TenantId($validated['tenant_id']),
                entityType: PaymentEntityType::from($validated['entity_type']),
                entityId: $validated['entity_id'],
                status: PaymentStatus::from($validated['status']),
                amountCents: new AmountCents((int) $validated['amount_cents']),
                currency: Currency::from($validated['currency']),
                provider: $validated['provider'],
                reference: $validated['reference'] ?? null,
                externalId: $validated['external_id'] ?? null,
            )
        );

        return (new PaymentResource($payment))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }
}
