<?php

namespace App\Application\User\Exception;

use Throwable;

class UserNotFoundException extends \RuntimeException
{
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message ?: 'User not found.', $code, $previous);
    }
}
