<?php

declare(strict_types=1);

namespace App\Application\User\Command;

use App\Application\Common\AuditCategory;
use App\Application\Common\Interface\AuditableOperation;
use App\Domain\EntityType;
use App\Domain\User\UserId;

readonly class ShowUserCommand implements AuditableOperation
{
    public function __construct(
        public UserId $id,
    ) {}

    public function auditCategory(): AuditCategory
    {
        return AuditCategory::AUDIT;
    }

    public function auditAction(): string
    {
        return EntityType::USER->value.'.show';
    }

    public function auditEntityType(): ?EntityType
    {
        return EntityType::USER;
    }

    public function auditEntityId(): ?string
    {
        return $this->id->toString();
    }

    public function auditPayload(): array
    {
        return get_object_vars($this);
    }
}
