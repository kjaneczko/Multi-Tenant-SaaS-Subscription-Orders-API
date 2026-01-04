<?php

declare(strict_types=1);

namespace App\Infrastructure\Database\Payment;

use App\Domain\Payment\Interface\PaymentRepositoryInterface;
use App\Domain\Payment\Payment;
use App\Infrastructure\Database\Exception\DatabaseException;
use App\Models\PaymentModel;
use Illuminate\Database\QueryException;

final readonly class PaymentRepositoryEloquent implements PaymentRepositoryInterface
{
    public function create(Payment $payment): Payment
    {
        try {
            $attributes = PaymentPersistenceMapper::toPersistence($payment);
            $model = PaymentModel::create($attributes);
        } catch (QueryException $e) {
            throw DatabaseException::failedToSave($e);
        }

        if (!$model) {
            throw DatabaseException::failedToSave();
        }

        return PaymentPersistenceMapper::toDomain($model);
    }
}
