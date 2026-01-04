<?php

declare(strict_types=1);

namespace App\Domain\Payment\Interface;

use App\Domain\Payment\Payment;

interface PaymentRepositoryInterface
{
    public function create(Payment $payment): Payment;
}
