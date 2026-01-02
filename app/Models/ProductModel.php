<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string $id
 * @property string $tenant_id
 * @property string $sku
 * @property string $name
 * @property string $slug
 * @property int $price_cents
 * @property string $status
 * @property string $currency
 * @property string|null $description
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @method static create(array $attributes)
 * @method static whereKey(string $toString)
 */
class ProductModel extends Model
{
    /** @use HasFactory<\Database\Factories\ProductModelFactory> */
    use HasFactory;
    use SoftDeletes;

    protected $table = 'products';
    public $incrementing = false;

    protected $fillable = [
        'id', 'tenant_id', 'name', 'slug', 'sku', 'price_cents',
        'status', 'description', 'created_at', 'updated_at',
        'currency', 'deleted_at',
    ];

    protected $casts = [
        'price_cents' => 'integer',
        'deleted_at' => 'datetime',
    ];
}
