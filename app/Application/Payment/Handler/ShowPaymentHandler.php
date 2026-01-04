<?php

declare(strict_types=1);

namespace App\Application\Payment\Handler;

use App\Application\Payment\Command\ShowPaymentCommand;
use App\Application\Payment\Exception\PaymentNotFoundException;
use App\Domain\Payment\Interface\PaymentQueryInterface;
use App\Domain\Payment\Payment;

readonly class ShowPaymentHandler
{
    public function __construct(
        private PaymentQueryInterface $query,
    ) {}

    public function __invoke(ShowPaymentCommand $command): Payment
    {
        $payment = $this->query->getById($command->paymentId);
        if (!$payment) {
            throw new PaymentNotFoundException();
        }
        return $payment;
    }
}
