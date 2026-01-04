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
}
