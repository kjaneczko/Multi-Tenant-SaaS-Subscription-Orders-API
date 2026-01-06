<?php

declare(strict_types=1);

namespace App\Application\Order\Command;

use App\Application\Common\AuditCategory;
use App\Application\Common\Interface\AuditableOperation;
use App\Domain\AmountCents;
use App\Domain\Currency;
use App\Domain\Email;
use App\Domain\EntityType;
use App\Domain\Tenant\TenantId;
use App\Domain\User\UserId;

final readonly class CreateOrderCommand implements AuditableOperation
{
    public function __construct(
        public TenantId $tenantId,
        public ?UserId $createdByUserId,
        public Email $customerEmail,
        public string $status,
        public Currency $currency,
        public AmountCents $subtotalCents,
        public AmountCents $discountCents,
        public AmountCents $taxCents,
        public AmountCents $totalCents,
        public ?string $notes,
        public ?\DateTimeImmutable $paidAt,
        public ?\DateTimeImmutable $refundedAt,
        public ?\DateTimeImmutable $cancelledAt,
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
        return EntityType::ORDER->value.'.create';
    }

    public function auditEntityType(): ?EntityType
    {
        return EntityType::ORDER;
    }

    public function auditEntityId(): ?string
    {
        return null;
    }
}
