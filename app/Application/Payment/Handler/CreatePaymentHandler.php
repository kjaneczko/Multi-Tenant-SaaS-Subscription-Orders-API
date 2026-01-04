<?php

declare(strict_types=1);

namespace App\Application\Payment\Handler;

use App\Application\Payment\Command\CreatePaymentCommand;
use App\Application\Common\Interface\UuidGeneratorInterface;
use App\Domain\Payment\Interface\PaymentRepositoryInterface;
use App\Domain\Payment\Payment;
use App\Domain\Payment\PaymentId;

final readonly class CreatePaymentHandler
{
    public function __construct(
        private PaymentRepositoryInterface $repository,
        private UuidGeneratorInterface     $uuid,
    ) {}

    public function __invoke(CreatePaymentCommand $command): Payment
    {
        $now = new \DateTimeImmutable('now');

        $payment = Payment::create(
            id: new PaymentId($this->uuid->generate()),
            tenantId: $command->tenantId,
            entityType: $command->entityType,
            entityId: $command->entityId,
            status: $command->status,
            provider: $command->provider,
            reference: $command->reference,
            amountCents: $command->amountCents,
            currency: $command->currency,
            externalId: $command->externalId,
            paidAt: null,
            createdAt: $now,
            updatedAt: $now,
        );

        return $this->repository->create($payment);
    }
}
