<?php

namespace app\Domain\Order;

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
}
