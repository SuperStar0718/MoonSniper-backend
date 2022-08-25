<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersVerify extends Model
{
    use HasFactory;
    protected $table = 'users_verify';
    protected $fillable = ['email','token'];
}
