<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @property mixed|string $id
 * @property \App\Domain\Tenant\TenantId|mixed $tenant_id
 * @property mixed|string $name
 * @property mixed|string $email
 * @property mixed|string|null $email_verified_at
 * @property mixed|string $password
 * @property mixed|string $role
 * @property bool|mixed $is_active
 * @property mixed|string|null $remember_token
 * @property mixed|string $created_at
 * @property mixed|string $updated_at
 * @property mixed|string|null $deleted_at
 * @method static create(array $attributes)
 * @method static whereKey(string $id)
 */
class UserModel extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserModelFactory> */
    use HasFactory;
    use Notifiable;

    protected $table = 'users';
    public $incrementing = false;
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
