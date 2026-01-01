<?php
declare(strict_types=1);

namespace App\Infrastructure\Database\Exception;

use RuntimeException;
use Throwable;

final class DatabaseException extends RuntimeException
{
    public static function failedToSave(?Throwable $e = null): self
    {
        if ($e) {
            return new self($e->getMessage(), 0, $e);
        }
        return new self('Failed to save', 0, $e);
    }

    public static function failedToUpdate(?Throwable $e = null): self
    {
        if ($e) {
            return new self($e->getMessage(), 0, $e);
        }
        return new self('Failed to update', 0, $e);
    }

    public static function failedToDelete(?Throwable $e = null): self
    {
        if ($e) {
            return new self($e->getMessage(), 0, $e);
        }
        return new self('Failed to delete', 0, $e);
    }
}
