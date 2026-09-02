<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Period extends Model
{
    use HasFactory;

    protected $fillable = ['period', 'status', 'apex_score'];

    public function isClosed(): bool
    {
        return $this->status === 'CLOSED';
    }
}
