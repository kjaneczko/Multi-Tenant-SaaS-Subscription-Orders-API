<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $attributes)
 *
 * @property string $updated_at;
 * @property string $created_at;
 * @property string $cancelled_at;
 * @property string $refunded_at;
 * @property string $paid_at;
 * @property string $notes;
 * @property int    $total_cents;
 * @property int    $tax_cents;
 * @property int    $discount_cents;
 * @property int    $subtotal_cents;
 * @property string $currency;
 * @property string $status;
 * @property string $customer_email;
 * @property string $created_by_user_id;
 * @property string $tenant_id;
 * @property string $id;
 */
class OrderModel extends Model
{
    /** @use HasFactory<\Database\Factories\OrderModelFactory> */
    use HasFactory;
    public $incrementing = false;

    protected $table = 'orders';

    protected $fillable = [
        'id',
        'tenant_id',
        'created_by_user_id',
        'customer_email',
        'status',
        'currency',
        'subtotal_cents',
        'discount_cents',
        'tax_cents',
        'total_cents',
        'notes',
        'paid_at',
        'refunded_at',
        'cancelled_at',
        'updated_at',
        'created_at',
    ];
}
