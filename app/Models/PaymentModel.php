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
}
