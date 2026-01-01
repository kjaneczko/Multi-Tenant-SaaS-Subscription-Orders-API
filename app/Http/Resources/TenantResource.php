<?php

namespace App\Http\Resources;

use App\Domain\Tenant\Tenant;
use App\Infrastructure\Database\Tenant\TenantPersistenceMapper;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TenantResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @property Tenant $resource
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var Tenant $tenant */
        $tenant = $this->resource;

        return TenantPersistenceMapper::toPersistence($tenant);
    }
}
