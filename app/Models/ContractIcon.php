<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractIcon extends Model
{
    use HasFactory;
    protected $table = 'contract_icons';
    protected $fillable = [
        'contract_type',
        'icon',
        'url',
        'updated_at',
        'created_at',    
    ];
}
