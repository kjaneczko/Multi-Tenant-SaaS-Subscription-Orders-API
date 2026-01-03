<?php

namespace App\Domain\AuditLog;

enum EntityType: string
{
    case ORDER = 'order';
    case ORDER_ITEM = 'order_item';
    case PRODUCT = 'product';
    case PAYMENT = 'payment';
    case SUBSCRIPTION = 'subscription';
    case TENANT = 'tenant';
    case USER = 'user';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
