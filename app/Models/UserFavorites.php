<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserFavorites extends Model
{
    use HasFactory;
    protected $fillable =[
        'coin_symbol',
        'coinid',
        'user_id'
    ];
}
