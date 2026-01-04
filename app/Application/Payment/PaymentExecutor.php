<?php

declare(strict_types=1);

namespace App\Application\Payment;

use App\Application\Payment\Exception\PaymentNotFoundException;
use App\Domain\Payment\Interface\PaymentRepositoryInterface;
use App\Domain\Payment\Payment;
use App\Domain\Payment\PaymentId;

readonly class PaymentExecutor
{
    public function __construct(
        private PaymentRepositoryInterface $repository,
    ) {}

    public function getByIdOrFail(PaymentId $id): Payment
    {
        $payment = $this->repository->getById($id);

        if (null === $payment) {
            throw new PaymentNotFoundException();
        }

        return $payment;
    }

    public function create(Payment $payment): void
    {
        $this->repository->create($payment);
    }
}
