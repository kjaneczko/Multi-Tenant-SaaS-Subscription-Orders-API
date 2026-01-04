<?php

declare(strict_types=1);

namespace App\Application\Context\Interface;

use App\Application\Context\RequestContext;

interface RequestContextProviderInterface
{
    public function current(): RequestContext;
}
