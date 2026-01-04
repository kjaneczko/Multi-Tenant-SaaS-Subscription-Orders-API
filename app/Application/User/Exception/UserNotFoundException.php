<?php

declare(strict_types=1);

namespace App\Application\User\Exception;

class UserNotFoundException extends \RuntimeException
{
    public function __construct(string $message = '', int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct($message ?: 'User not found.', $code, $previous);
    }
}
