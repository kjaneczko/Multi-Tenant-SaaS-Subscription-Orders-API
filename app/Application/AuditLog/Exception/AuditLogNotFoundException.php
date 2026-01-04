<?php

declare(strict_types=1);

namespace App\Application\AuditLog\Exception;

class AuditLogNotFoundException extends \RuntimeException
{
    public function __construct(string $message = '', int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct($message ?: 'Audit log not found.', $code, $previous);
    }
}
