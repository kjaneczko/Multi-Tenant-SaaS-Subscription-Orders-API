<?php

declare(strict_types=1);

namespace App\Domain\Order\Interface;

use App\Domain\Order\Order;
use App\Domain\Order\OrderId;

interface OrderRepositoryInterface
{
    public function create(Order $order): Order;

    public function update(Order $order): bool;

    public function delete(OrderId $id): bool;
}
