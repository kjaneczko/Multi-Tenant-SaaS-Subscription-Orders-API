<?php

declare(strict_types=1);

namespace App\Application\OrderItem\Command;

use App\Application\Common\AuditCategory;
use App\Application\Common\Interface\AuditableOperation;
use App\Application\Common\Query\PageRequest;
use App\Domain\EntityType;
use App\Domain\Tenant\TenantId;

readonly class ListOrderItemCommand implements AuditableOperation
{
    public function __construct(
        public PageRequest $pageRequest,
        public ?TenantId $tenantId,
        public ?string $orderId,
    ) {}

    public function auditCategory(): AuditCategory
    {
        return AuditCategory::ACCESS;
    }

    public function auditAction(): string
    {
        return EntityType::ORDER_ITEM->value.'.list';
    }

    public function auditEntityType(): ?EntityType
    {
        return EntityType::ORDER_ITEM;
    }

    public function auditEntityId(): ?string
    {
        return $this->orderId;
    }

    public function auditPayload(): array
    {
        return get_object_vars($this);
    }
}
