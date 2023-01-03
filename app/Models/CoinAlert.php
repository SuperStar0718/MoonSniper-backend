<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoinAlert extends Model
{
    use HasFactory;
    protected $table = 'coin_alerts';
    protected $fillable = [
        'name',
        'priority',
        'price',
        'tradingper24h',
        'roipercentage',
        'marketcap',
        'nextunlock',
        'socialsentiments',
        'status',
    ];
}
