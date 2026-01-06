<?php

declare(strict_types=1);

namespace App\Domain\OrderItem\Interface;

use App\Domain\OrderItem\OrderItem;
use App\Domain\OrderItem\OrderItemId;

interface OrderItemRepositoryInterface
{
    public function create(OrderItem $orderItem): OrderItem;

    public function update(OrderItem $orderItem): bool;

    public function delete(OrderItemId $id): bool;
}
