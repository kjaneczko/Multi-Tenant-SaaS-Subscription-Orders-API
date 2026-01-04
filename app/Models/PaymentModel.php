<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentModel extends Model
{
    /** @use HasFactory<\Database\Factories\PaymentModelFactory> */
    use HasFactory;
    public $incrementing = false;

    protected $table = 'payments';

    protected $fillable = [
        'id',
        'tenant_id',
        'entity_type',
        'entity_id',
        'status',
        'reference',
        'amount_cents',
        'currency',
        'provider',
        'external_id',
        'paid_at',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'created_at' => 'string',
        'updated_at' => 'string',
        'paid_at' => 'string',
    ];
}
