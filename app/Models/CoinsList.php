<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Iksaku\Laravel\MassUpdate\MassUpdatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CoinsList extends Model
{
    use HasFactory;
    use MassUpdatable;
    protected $table = 'coins';
    protected $fillable = ['coin_id', 'symbol', 'name', 'website', 'whitepaper', 'twitter', 'medium', 'reddit', 'github', 'telegram', 'discord', 'slack', '0xtracker', 'coin_platform', 'genesis_date', 'coin_category', 'coin_description', 'contract_address', 'trading_history_flag'];
    public $timestamps = true;

   
}
