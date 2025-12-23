<?php

namespace App\Domain\Payment;

enum PaymentStatus: string
{
    case NEW = 'new';
    case PENDING = 'pending';
    case PAID = 'paid';
    case CANCELLED = 'cancelled';
}
