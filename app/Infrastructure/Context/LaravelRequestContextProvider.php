<?php

declare(strict_types=1);

namespace App\Infrastructure\Context;

use App\Application\Context\Interface\RequestContextProviderInterface;
use App\Application\Context\RequestContext;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

final readonly class LaravelRequestContextProvider implements RequestContextProviderInterface
{
    public function __construct(
        private Request $request,
    ) {}

    public function current(): RequestContext
    {
        $requestId = $this->request->headers->get('X-Request-Id');
        if (!$requestId) {
            $requestId = (string) Str::uuid();
        }

        $user = $this->request->user();
        $actorId = $user?->id ? (string) $user->id : 'unknown';

        $tenantId = $user?->tenant_id ? (string) $user->tenant_id : 'unknown';

        return new RequestContext(
            tenantId: $tenantId,
            actorId: $actorId,
            requestId: $requestId,
            ip: $this->request->ip(),
            userAgent: $this->request->userAgent(),
        );
    }
}
