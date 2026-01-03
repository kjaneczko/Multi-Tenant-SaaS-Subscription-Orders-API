<?php

namespace App\Application\Payment\Command;

use App\Domain\AmountCents;
use App\Domain\Currency;
use App\Domain\Payment\PaymentEntityType;
use App\Domain\Payment\PaymentStatus;
use App\Domain\Tenant\TenantId;

final readonly class CreatePaymentCommand
{
    public function __construct(
        public TenantId $tenantId,
        public PaymentEntityType $entityType,
        public string $entityId,
        public PaymentStatus $status,
        public AmountCents $amountCents,
        public Currency $currency,
        public string $provider,
        public ?string $reference,
        public string $externalId,
    ) {}
}
