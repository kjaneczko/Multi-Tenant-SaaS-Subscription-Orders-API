<?php

declare(strict_types=1);

namespace App\Application\Context;

final readonly class RequestContext
{
    public function __construct(
        public ?string $tenantId,
        public ?string $actorId,
        public ?string $requestId,
        public ?string $ip,
        public ?string $userAgent,
    ) {}
}
