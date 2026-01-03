<?php

namespace App\Domain\Subscription;

enum SubscriptionInterval: string
{
    case MONTHLY = 'monthly';
    case YEARLY = 'yearly';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
