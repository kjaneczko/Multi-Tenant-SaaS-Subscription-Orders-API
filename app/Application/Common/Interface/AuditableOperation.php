<?php

declare(strict_types=1);

namespace App\Application\Common\Interface;

use App\Application\Common\AuditCategory;
use App\Domain\EntityType;

interface AuditableOperation
{
    public function auditCategory(): AuditCategory;

    /** np. "order.create", "task.list" */
    public function auditAction(): string;

    /** np. "order" */
    public function auditEntityType(): ?EntityType;

    public function auditEntityId(): ?string;

    /** @return array<string,mixed> */
    public function auditPayload(): array;
}
