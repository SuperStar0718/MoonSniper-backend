<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Iksaku\Laravel\MassUpdate\MassUpdatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContractIcon extends Model
{
    use HasFactory;
    use MassUpdatable;
    protected $table = 'contract_icons';
    protected $fillable = [
        'platform',
        'icon',
        'url',
        'updated_at',
        'created_at',    
    ];
}
