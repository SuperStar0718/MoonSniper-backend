<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Iksaku\Laravel\MassUpdate\MassUpdatable;


class PresetFilter extends Model
{
    use HasFactory;
    use MassUpdatable;
    protected $table = 'preset_filters';
    protected $fillable = ['id', 'preset_name', 'filter_json', 'default', 'user_id' ,'created_at', 'updated_at'];
    public $timestamps = true;
}
