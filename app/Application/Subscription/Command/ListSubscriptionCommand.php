<?php

declare(strict_types=1);

namespace App\Application\Subscription\Command;

use App\Application\Common\AuditCategory;
use App\Application\Common\Interface\AuditableOperation;
use App\Application\Common\Query\PageRequest;
use App\Domain\EntityType;
use App\Domain\Subscription\SubscriptionStatus;
use App\Domain\Tenant\TenantId;
use App\Domain\User\UserId;

readonly class ListSubscriptionCommand implements AuditableOperation
{
    public function __construct(
        public PageRequest $pageRequest,
        public ?TenantId $tenantId,
        public ?UserId $createdByUserId,
        public ?SubscriptionStatus $status,
    ) {}

    public function auditCategory(): AuditCategory
    {
        return AuditCategory::ACCESS;
    }

    public function auditAction(): string
    {
        return EntityType::SUBSCRIPTION->value.'.list';
    }

    public function auditEntityType(): ?EntityType
    {
        return EntityType::SUBSCRIPTION;
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
