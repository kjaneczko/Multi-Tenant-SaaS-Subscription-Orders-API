<?php

declare(strict_types=1);

namespace App\Application\Subscription\Exception;

class SubscriptionNotFoundException extends \RuntimeException
{
    public function __construct(string $message = '', int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct($message ?: 'Subscription not found.', $code, $previous);
    }
}
