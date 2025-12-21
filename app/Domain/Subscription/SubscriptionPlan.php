<?php

namespace app\Domain\Subscription;

enum SubscriptionPlan: string
{
    case BASIC = 'basic';
    case PRO = 'pro';
    case ENTERPRISE = 'enterprise';
}
