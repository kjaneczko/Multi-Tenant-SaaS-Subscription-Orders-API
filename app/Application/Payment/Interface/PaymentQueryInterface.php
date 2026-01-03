<?php

namespace App\Application\Payment\Interface;

use App\Application\Shared\Query\PageRequest;
use App\Domain\Payment\Payment;
use App\Domain\Payment\PaymentEntityType;

interface PaymentQueryInterface
{
    /**
     * @return Payment[]
     */
    public function paginate(
        PageRequest $pageRequest,
        ?string $tenantId = null,
        ?PaymentEntityType $entityType = null,
    ): array;
}
