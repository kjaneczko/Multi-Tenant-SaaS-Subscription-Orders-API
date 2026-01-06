<?php

declare(strict_types=1);

namespace App\Application\OrderItem\Exception;

class OrderItemNotFoundException extends \RuntimeException
{
    public function __construct(string $message = '', int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct($message ?: 'Order item not found.', $code, $previous);
    }
}
