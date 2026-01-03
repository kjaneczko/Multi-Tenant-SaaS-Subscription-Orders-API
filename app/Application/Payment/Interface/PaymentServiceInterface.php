<?php

namespace App\Application\Payment\Interface;

use App\Application\Payment\Command\CreatePaymentCommand;
use App\Application\Shared\Query\PageRequest;
use App\Domain\Payment\Payment;
use App\Domain\Payment\PaymentId;
use App\Domain\Payment\PaymentEntityType;

interface PaymentServiceInterface
{
    public function create(CreatePaymentCommand $command): Payment;

    public function getById(PaymentId $id): Payment;

    /**
     * @return Payment[]
     */
    public function paginate(
        PageRequest $pageRequest,
        ?string $tenantId = null,
        ?PaymentEntityType $entityType = null,
    ): array;
}
