<?php

declare(strict_types=1);

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Domain\Tenant\TenantId;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @property mixed|string      $id
 * @property mixed|TenantId    $tenant_id
 * @property mixed|string      $name
 * @property mixed|string      $email
 * @property null|mixed|string $email_verified_at
 * @property mixed|string      $password
 * @property mixed|string      $role
 * @property bool|mixed        $is_active
 * @property null|mixed|string $remember_token
 * @property mixed|string      $created_at
 * @property mixed|string      $updated_at
 * @property null|mixed|string $deleted_at
 *
 * @method static create(array $attributes)
 * @method static whereKey(string $id)
 */
class UserModel extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserModelFactory> */
    use HasFactory;
    use Notifiable;
    public $incrementing = false;

    protected $table = 'users';
    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'id',
        'tenant_id',
        'name',
        'email',
        'email_verified_at',
        'password',
        'role',
        'is_active',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'is_active' => 'bool',
        'email_verified_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];
}
