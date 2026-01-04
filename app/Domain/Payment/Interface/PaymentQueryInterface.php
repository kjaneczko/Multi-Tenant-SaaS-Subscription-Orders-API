<?php

declare(strict_types=1);

namespace App\Domain\Payment\Interface;

use App\Application\Common\Query\PageRequest;
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
