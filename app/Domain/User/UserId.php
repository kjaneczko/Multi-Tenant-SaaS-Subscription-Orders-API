<?php

namespace app\Domain\User;

readonly class UserId
{
    public function __construct(
        private string $id,
    ) {}

    public function toString(): string
    {
        return $this->id;
    }
}
