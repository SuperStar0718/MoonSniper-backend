<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dashboard extends Model
{
    use HasFactory;
    protected $table = 'dashboard';
    protected $fillable = ['fear_greed_index', 'market_cap', 'vol_24h', 'btc_dom', 'eth_dom', 'fear_greed_classification', 'fear_greed_history'];
    public $timestamps = true;
}
