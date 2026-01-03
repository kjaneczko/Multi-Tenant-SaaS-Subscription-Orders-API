<?php

namespace App\Domain\Payment;

enum PaymentEntityType: string
{
    case ORDER = 'order';
    case SUBSCRIPTION = 'subscription';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
