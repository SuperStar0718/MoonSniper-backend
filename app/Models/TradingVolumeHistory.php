<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Iksaku\Laravel\MassUpdate\MassUpdatable;

class TradingVolumeHistory extends Model
{
    use HasFactory;
    use MassUpdatable;
    protected $table = 'trading_volume_history';
    protected $fillable = ['coin_id', 'symbol', 'trading_volume_history_json' ,'created_at', 'updated_at'];
    public $timestamps = true;
}
