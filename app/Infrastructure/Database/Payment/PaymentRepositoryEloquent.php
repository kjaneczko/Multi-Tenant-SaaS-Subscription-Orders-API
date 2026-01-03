<?php

namespace App\Infrastructure\Database\Payment;

use App\Application\Payment\Interface\PaymentRepositoryInterface;
use App\Domain\Payment\Payment;
use App\Domain\Payment\PaymentId;
use App\Models\PaymentModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;

final readonly class PaymentRepositoryEloquent implements PaymentRepositoryInterface
{
    public function getById(PaymentId $id): Payment
    {
        $model = PaymentModel::query()->find($id->toString());

        if (!$model) {
            throw new ModelNotFoundException("Payment {$id->toString()} not found.");
        }

        return PaymentPersistenceMapper::toDomain($model);
    }

    public function save(Payment $payment): void
    {
        $model = new PaymentModel();

        $model->fill(
            PaymentPersistenceMapper::toPersistence($payment)
        );

        $model->save();
    }
}
