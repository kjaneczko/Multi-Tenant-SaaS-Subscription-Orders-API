<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionModel extends Model
{
    /** @use HasFactory<\Database\Factories\SubscriptionModelFactory> */
    use HasFactory;
    public $incrementing = false;

    protected $table = 'subscriptions';

    protected $fillable = [
        'id',
        'tenant_id',
        'created_by_user_id',
        'plan',
        'interval',
        'status',
        'currency',
        'price_cents',
        'current_period_start',
        'current_period_end',
        'cancelled_at',
        'created_at',
        'updated_at',
        'started_at',
        'ended_at',
    ];
}
