<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Launchpad extends Model
{
    use HasFactory;
   protected $fillable = [
            'icon',
            'launchpad',
            'project',
            'category',
            'market_cap',
            'thicker',
            'launch_time',
            'first_unlock_time',
            'network',
            'ido_public_number',
            'telegram',
            'website',
            'twitter',
            'tokenomies',
            'contract',
    ];
}
