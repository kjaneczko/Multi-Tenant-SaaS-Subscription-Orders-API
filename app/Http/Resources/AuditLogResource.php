<?php

namespace App\Http\Resources;

use App\Domain\AuditLog\AuditLog;
use App\Infrastructure\Database\AuditLog\AuditLogPersistenceMapper;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuditLogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @property AuditLog $resource
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var AuditLog $auditLog */
        $auditLog = $this->resource;

        return AuditLogPersistenceMapper::toPersistence($auditLog);
    }
}
