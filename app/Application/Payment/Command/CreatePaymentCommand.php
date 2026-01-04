<?php

declare(strict_types=1);

namespace App\Application\Payment\Command;

use App\Application\Common\AuditCategory;
use App\Application\Common\Interface\AuditableOperation;
use App\Domain\AmountCents;
use App\Domain\Currency;
use App\Domain\EntityType;
use App\Domain\Payment\PaymentEntityType;
use App\Domain\Payment\PaymentStatus;
use App\Domain\Tenant\TenantId;

final readonly class CreatePaymentCommand implements AuditableOperation
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

    public function auditPayload(): array
    {
        return get_object_vars($this);
    }

    public function auditCategory(): AuditCategory
    {
        return AuditCategory::AUDIT;
    }

    public function auditAction(): string
    {
        return EntityType::PAYMENT->value.'.create';
    }

    public function auditEntityType(): ?EntityType
    {
        return EntityType::PAYMENT;
    }

    public function auditEntityId(): ?string
    {
        return null;
    }
}
