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

    protected $fillable = [
        'id',
        'tenant_id',
        'order_id',
        'product_id',
        'quantity',
        'product_name_snapshot',
        'sku_snapshot',
        'unit_price_cents',
        'line_total_cents',
        'created_at',
        'updated_at',
    ];
}
