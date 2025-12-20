<?php

namespace app\Domain\Tenant;

readonly class Tenant
{
    private function __construct(
        private TenantId $id,
        private string $name,
        private string $slug,
        private string $status,
    ) {}

    public static function create(
        TenantId $id,
        string $name,
        string $slug,
        string $status,
    ): self {
        return new self(
            id: $id,
            name: $name,
            slug: $slug,
            status: $status,
        );
    }

    public function id(): TenantId
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function slug(): string
    {
        return $this->slug;
    }

    public function status(): string
    {
        return $this->status;
    }
}
