<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentModel extends Model
{
    /** @use HasFactory<\Database\Factories\PaymentModelFactory> */
    use HasFactory;

    protected $table = 'payments';
    public $incrementing = false;

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
}
