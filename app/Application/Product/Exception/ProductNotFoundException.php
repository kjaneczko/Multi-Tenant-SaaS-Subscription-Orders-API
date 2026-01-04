<?php

declare(strict_types=1);

namespace App\Application\Product\Exception;

class ProductNotFoundException extends \RuntimeException
{
    public function __construct(string $message = '', int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct($message ?: 'Product not found.', $code, $previous);
    }
}
