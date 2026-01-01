<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static find(string $toString)
 * @method static where(string $string, string $entityType)
 * @method static create(array $toPersistence)
 * @method static skip(float|int $offset)
 * @property string $id
 * @property string $tenant_id
 * @property string $actor_user_id
 * @property string $action
 * @property string $entity_type
 * @property string $entity_id
 * @property string $meta
 * @property string $created_at
 */
class AuditLogModel extends Model
{
    /** @use HasFactory<\Database\Factories\AuditLogModelFactory> */
    use HasFactory;

    protected $table = 'audit_logs';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'tenant_id',
        'actor_user_id',
        'action',
        'entity_id',
        'entity_type',
        'meta',
        'created_at',
    ];
}
