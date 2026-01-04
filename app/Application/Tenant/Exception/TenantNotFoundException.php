<?php

declare(strict_types=1);

namespace App\Application\Tenant\Exception;

class TenantNotFoundException extends \RuntimeException
{
    public function __construct(string $message = '', int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct('Tenant not found.', $code, $previous);
    }
}
