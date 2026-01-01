<?php

namespace App\Application\AuditLog\Exception;

use Throwable;

class AuditLogNotFoundException extends \RuntimeException
{
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message ?: 'Audit log not found.', $code, $previous);
    }
}
