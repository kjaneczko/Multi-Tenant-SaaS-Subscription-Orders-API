<?php

declare(strict_types=1);

namespace App\Application\Payment;

use App\Application\Payment\Command\CreatePaymentCommand;
use App\Application\Payment\Handler\CreatePaymentHandler;
use App\Application\Payment\Interface\PaymentServiceInterface;
use App\Application\Common\Query\PageRequest;
use App\Domain\Payment\Interface\PaymentQueryInterface;
use App\Domain\Payment\Payment;
use App\Domain\Payment\PaymentEntityType;
use App\Domain\Payment\PaymentId;

final readonly class PaymentService implements PaymentServiceInterface
{
    public function __construct(
        private CreatePaymentHandler $createPaymentHandler,
        private PaymentExecutor $executor,
        private PaymentQueryInterface $paymentQuery,
    ) {}

    public function create(CreatePaymentCommand $command): Payment
    {
        $id = ($this->createPaymentHandler)($command);

        return $this->executor->getByIdOrFail(new PaymentId($id->toString()));
    }

    public function getById(PaymentId $id): Payment
    {
        return $this->executor->getByIdOrFail($id);
    }

    public function paginate(
        PageRequest $pageRequest,
        ?string $tenantId = null,
        ?PaymentEntityType $entityType = null,
    ): array {
        return $this->paymentQuery->paginate(
            pageRequest: $pageRequest,
            tenantId: $tenantId,
            entityType: $entityType,
        );
    }
}
