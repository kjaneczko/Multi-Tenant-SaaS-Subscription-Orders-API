<?php

namespace App\Application\Payment\Interface;

use App\Domain\Payment\Payment;
use App\Domain\Payment\PaymentId;

interface PaymentRepositoryInterface
{
    public function getById(PaymentId $id): Payment;
    public function save(Payment $payment): void;
}
