<?php

declare(strict_types=1);

namespace App\Application\Common;

use App\Application\Common\Interface\AuditableOperation;
use App\Application\Context\Interface\RequestContextProviderInterface;
use App\Application\Common\Interface\UuidGeneratorInterface;
use App\Domain\AuditLog\AuditLog;
use App\Domain\AuditLog\AuditLogId;
use App\Domain\AuditLog\Interface\AuditLogWriterInterface;
use App\Domain\PayloadJsonString;
use App\Domain\SensitiveKeys;
use App\Domain\Tenant\TenantId;
use App\Domain\User\UserId;
use Throwable;

final readonly class UseCaseExecutor
{
    public function __construct(
        private AuditLogWriterInterface $auditWriter,
        private RequestContextProviderInterface $contextProvider,
        private UuidGeneratorInterface $uuid,
    ) {}

    /**
     * @template T
     * @param AuditableOperation $operation
     * @param callable():T $fn
     * @return T
     * @throws Throwable
     */
    public function run(
        AuditableOperation $operation,
        callable           $fn,
    ): mixed {
        $ctx = $this->contextProvider->current();
        $start = microtime(true);

        try {
            $result = $fn();

            $this->auditWriter->write(AuditLog::create(
                id: new AuditLogId($this->uuid->generate()),
                tenantId: new TenantId($ctx->tenantId),
                actorUserId: new UserId($ctx->actorId),
                category: $operation->auditCategory(),
                action: $operation->auditAction(),
                entityType: $operation->auditEntityType(),
                entityId: $operation->auditEntityId(),
                payload: new PayloadJsonString(json_encode($this->redact($operation->auditPayload()))),
                durationMs: (int) round((microtime(true) - $start) * 1000),
                success: true,
                errorType: null,
                errorMessage: null,
                requestId: $ctx->requestId,
                ip: $ctx->ip,
                userAgent: $ctx->userAgent,
                createdAt: new \DateTimeImmutable(),
            ));

            return $result;
        } catch (Throwable $e) {
            $this->auditWriter->write(AuditLog::create(
                id: new AuditLogId($this->uuid->generate()),
                tenantId: new TenantId($ctx->tenantId),
                actorUserId: new UserId($ctx->actorId),
                category: $operation->auditCategory(),
                action: $operation->auditAction(),
                entityType: $operation->auditEntityType(),
                entityId: $operation->auditEntityId(),
                payload: new PayloadJsonString(json_encode($this->redact($operation->auditPayload()))),
                durationMs: (int) round((microtime(true) - $start) * 1000),
                success: false,
                errorType: (new \ReflectionClass($e))->getShortName(),
                errorMessage: $e->getMessage() !== '' ? $e->getMessage() : 'error',
                requestId: $ctx->requestId,
                ip: $ctx->ip,
                userAgent: $ctx->userAgent,
                createdAt: new \DateTimeImmutable(),
            ));

            throw $e;
        }
    }

    /** @param array<string,mixed> $payload */
    private function redact(array $payload): array
    {
        $sensitiveKeys = SensitiveKeys::values();

        $out = [];
        foreach ($payload as $k => $v) {
            if (\in_array($k, $sensitiveKeys, true)) {
                $out[$k] = '***';
                continue;
            }
            $out[$k] = $v;
        }
        return $out;
    }
}
