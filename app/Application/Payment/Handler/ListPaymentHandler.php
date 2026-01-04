<?php

declare(strict_types=1);

namespace App\Application\Payment\Handler;

use App\Application\Payment\Command\ListPaymentCommand;
use App\Domain\Payment\Interface\PaymentQueryInterface;
use App\Domain\Payment\Payment;

readonly class ListPaymentHandler
{
    public function __construct(
        private PaymentQueryInterface $query,
    ) {}

    /**
     * @return Payment[]
     */
    public function __invoke(ListPaymentCommand $command): array
    {
        return $this->query->paginate(
            pageRequest: $command->pageRequest,
            tenantId: $command->tenantId,
            entityType: $command->entityType,
        );
    }
}
