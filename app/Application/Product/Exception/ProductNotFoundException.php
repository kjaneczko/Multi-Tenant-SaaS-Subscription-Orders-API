<?php

namespace App\Application\Product\Exception;

use RuntimeException;
use Throwable;

class ProductNotFoundException extends RuntimeException
{

    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message ?: 'Product not found.', $code, $previous);
    }
}
