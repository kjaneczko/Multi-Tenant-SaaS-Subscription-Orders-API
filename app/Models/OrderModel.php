<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderModel extends Model
{
    /** @use HasFactory<\Database\Factories\OrderModelFactory> */
    use HasFactory;
    public $incrementing = false;

    protected $table = 'orders';
}
