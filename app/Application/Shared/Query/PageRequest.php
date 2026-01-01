<?php
declare(strict_types=1);

namespace App\Application\Shared\Query;

readonly class PageRequest
{
    public function __construct(
        public int $page,
        public int $limit,
    ) {}
}
