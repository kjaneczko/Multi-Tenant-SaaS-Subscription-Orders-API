<?php

declare(strict_types=1);

namespace App\Application\Payment\Command;

use App\Application\Common\AuditCategory;
use App\Application\Common\Interface\AuditableOperation;
use App\Domain\EntityType;
use App\Domain\Payment\PaymentId;

readonly class ShowPaymentCommand implements AuditableOperation
{
    public function __construct(
        public PaymentId $paymentId,
    ) {}

    public function auditCategory(): AuditCategory
    {
        return AuditCategory::ACCESS;
    }

    public function auditAction(): string
    {
        return EntityType::PAYMENT->value.'.show';
    }

    public function auditEntityType(): ?EntityType
    {
        return EntityType::PAYMENT;
    }

    public function auditEntityId(): ?string
    {
        return $this->paymentId->toString();
    }

    public function auditPayload(): array
    {
        return get_object_vars($this);
    }
}
