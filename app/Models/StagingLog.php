<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StagingLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'period',
        'dept_code',
        'idempotency_key',
        'status',
        'source_version',
        'message',
    ];
}
