<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Iksaku\Laravel\MassUpdate\MassUpdatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notifications extends Model
{
    use HasFactory;
    use MassUpdatable;
    protected $table ='notifications';
    protected $fillable = [
        'id',
        'type',
        'notifiable_type',
        'notifiable_id',
        'data',
        'note',
        'read_at',
        'note',
        'show_date',
    ];
    protected $casts = [
        'id' => 'string'
    ];
}
