<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancialRatio extends Model
{
    use HasFactory;

    protected $fillable = [
        'period',
        'category',
        'ratio_name',
        'target',
        'actual',
        'achievement_pct',
        'status',
    ];
}
