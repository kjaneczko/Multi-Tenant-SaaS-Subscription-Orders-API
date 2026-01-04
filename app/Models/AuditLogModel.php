<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static find(string $toString)
 * @method static where(string $string, string $entityType)
 * @method static create(array $toPersistence)
 * @method static skip(float|int $offset)
 *
 * @property string $id
 * @property string $tenant_id
 * @property string $actor_user_id
 * @property string $category
 * @property string $action
 * @property string $entity_type
 * @property string $entity_id
 * @property string $payload
 * @property int $duration_ms
 * @property boolean $success
 * @property ?string $error_type
 * @property ?string $error_message
 * @property string $created_at
 * @property mixed $request_id
 * @property mixed $ip
 * @property mixed $user_agent
 */
class AuditLogModel extends Model
{
    /** @use HasFactory<\Database\Factories\AuditLogModelFactory> */
    use HasFactory;
    public $incrementing = false;
    public $timestamps = false;

    protected $table = 'audit_logs';

    protected $fillable = [
        'id',
        'tenant_id',
        'actor_user_id',
        'category',
        'action',
        'entity_id',
        'entity_type',
        'payload',
        'duration_ms',
        'success',
        'error_type',
        'error_message',
        'request_id',
        'ip',
        'user_agent',
        'created_at',
    ];

    protected $casts = [
        'success' => 'boolean',
    ];
}
