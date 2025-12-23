<?php

namespace App\Domain\Subscription;

enum SubscriptionInterval: string
{
    case MONTHLY = 'monthly';
    case YEARLY = 'yearly';
}
