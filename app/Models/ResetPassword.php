<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResetPassword extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'password_resets';
    protected $fillable = [
        'email',
        'token',
        'created_at'
    ];
}
