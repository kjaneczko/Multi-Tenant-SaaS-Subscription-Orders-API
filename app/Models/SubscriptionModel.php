<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionModel extends Model
{
    /** @use HasFactory<\Database\Factories\SubscriptionModelFactory> */
    use HasFactory;

    protected $table = 'subscriptions';
}
