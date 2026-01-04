<?php

declare(strict_types=1);

namespace App\Infrastructure\Database\Payment;

use App\Domain\Payment\Interface\PaymentRepositoryInterface;
use App\Domain\Payment\Payment;
use App\Domain\Payment\PaymentId;
use App\Models\PaymentModel;

final readonly class PaymentRepositoryEloquent implements PaymentRepositoryInterface
{
    public function getById(PaymentId $id): ?Payment
    {
        $model = PaymentModel::query()->find($id->toString());

        if (!$model) {
            return null;
        }

        return PaymentPersistenceMapper::toDomain($model);
    }

    public function create(Payment $payment): void
    {
        PaymentModel::create(PaymentPersistenceMapper::toPersistence($payment));
    }
}
