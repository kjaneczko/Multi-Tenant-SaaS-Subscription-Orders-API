<?php

declare(strict_types=1);

namespace App\Domain\Payment\Interface;

use App\Domain\Payment\Payment;
use App\Domain\Payment\PaymentId;

interface PaymentRepositoryInterface
{
    public function getById(PaymentId $id): ?Payment;

    public function create(Payment $payment): void;
}
