<?php

declare(strict_types=1);

namespace App\Domain\Order;

enum OrderStatus: string
{
    case NEW = 'new';
    case WAITING_PAYMENT = 'waiting_payment';
    case PAID = 'paid';
    case PENDING = 'pending';
    case SENT = 'sent';
    case DELIVERED = 'delivered';
    case REFUNDED = 'refunded';
    case CANCELLED = 'cancelled';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
