<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditLogModel extends Model
{
    /** @use HasFactory<\Database\Factories\AuditLogModelFactory> */
    use HasFactory;

    protected $table = 'audit_logs';

}
