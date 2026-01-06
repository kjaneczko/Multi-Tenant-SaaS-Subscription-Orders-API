<?php

declare(strict_types=1);

namespace App\Application\Order\Command;

use App\Application\Common\AuditCategory;
use App\Application\Common\Interface\AuditableOperation;
use App\Domain\EntityType;
use App\Domain\Order\OrderId;

readonly class ShowOrderCommand implements AuditableOperation
{
    public function __construct(
        public OrderId $orderId,
    ) {}

    public function auditCategory(): AuditCategory
    {
        return AuditCategory::AUDIT;
    }

    public function auditAction(): string
    {
        return EntityType::ORDER->value.'.show';
    }

    public function auditEntityType(): ?EntityType
    {
        return EntityType::ORDER;
    }

    public function auditEntityId(): ?string
    {
        return $this->orderId->toString();
    }

    public function auditPayload(): array
    {
        return get_object_vars($this);
    }
}
