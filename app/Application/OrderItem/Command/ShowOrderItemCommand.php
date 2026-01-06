<?php

declare(strict_types=1);

namespace App\Application\OrderItem\Command;

use App\Application\Common\AuditCategory;
use App\Application\Common\Interface\AuditableOperation;
use App\Domain\EntityType;
use App\Domain\OrderItem\OrderItemId;

readonly class ShowOrderItemCommand implements AuditableOperation
{
    public function __construct(
        public OrderItemId $orderItemId,
    ) {}

    public function auditCategory(): AuditCategory
    {
        return AuditCategory::AUDIT;
    }

    public function auditAction(): string
    {
        return EntityType::ORDER_ITEM->value.'.show';
    }

    public function auditEntityType(): ?EntityType
    {
        return EntityType::ORDER_ITEM;
    }

    public function auditEntityId(): ?string
    {
        return $this->orderItemId->toString();
    }

    public function auditPayload(): array
    {
        return get_object_vars($this);
    }
}
