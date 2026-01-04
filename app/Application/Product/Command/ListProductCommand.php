<?php

declare(strict_types=1);

namespace App\Application\Product\Command;

use App\Application\Common\AuditCategory;
use App\Application\Common\Interface\AuditableOperation;
use App\Application\Common\Query\PageRequest;
use App\Domain\EntityType;
use App\Domain\Payment\PaymentEntityType;
use App\Domain\Tenant\TenantId;

readonly class ListProductCommand implements AuditableOperation
{
    public function __construct(
        public PageRequest $pageRequest,
        public ?TenantId $tenantId,
    ) {}

    public function auditCategory(): AuditCategory
    {
        return AuditCategory::ACCESS;
    }

    public function auditAction(): string
    {
        return EntityType::PRODUCT->value.'.list';
    }

    public function auditEntityType(): ?EntityType
    {
        return EntityType::PRODUCT;
    }

    public function auditEntityId(): ?string
    {
        return null;
    }

    public function auditPayload(): array
    {
        return get_object_vars($this);
    }
}
