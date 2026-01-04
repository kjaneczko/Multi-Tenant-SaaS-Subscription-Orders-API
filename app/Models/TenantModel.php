<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $id
 * @property string $name
 * @property string $slug
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 *
 * @method static create(array $toPersistence)
 * @method static whereKey(string $toString)
 * @method static find(string $toString)
 * @method static where(string $string)
 * @method static skip(float|int $offset)
 */
class TenantModel extends Model
{
    /** @use HasFactory<\Database\Factories\TenantModelFactory> */
    use HasFactory;

    public $incrementing = false;

    protected $table = 'tenants';

    protected $fillable = [
        'id',
        'name',
        'slug',
        'status',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'created_at' => 'string',
        'updated_at' => 'string',
    ];
}
