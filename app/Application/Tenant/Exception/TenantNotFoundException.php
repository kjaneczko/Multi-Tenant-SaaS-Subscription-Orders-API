<?php

namespace App\Application\Tenant\Exception;

use RuntimeException;
use Throwable;

class TenantNotFoundException extends RuntimeException
{
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct('Tenant not found.', $code, $previous);
    }
}
