<?php

declare(strict_types=1);

namespace App\Domain\Subscription;

enum SubscriptionStatus: string
{
    case ACTIVE = 'active';
    case PAST_DUE = 'past_due';
    case CANCELLED = 'cancelled';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
