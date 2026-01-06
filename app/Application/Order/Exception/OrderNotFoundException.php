<?php

declare(strict_types=1);

namespace App\Application\Order\Exception;

class OrderNotFoundException extends \RuntimeException
{
    public function __construct(string $message = '', int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct($message ?: 'Order not found.', $code, $previous);
    }
}
