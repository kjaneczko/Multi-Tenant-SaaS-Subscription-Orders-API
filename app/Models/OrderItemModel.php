<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItemModel extends Model
{
    /** @use HasFactory<\Database\Factories\OrderItemModelFactory> */
    use HasFactory;
    public $incrementing = false;

    protected $table = 'order_items';
}
