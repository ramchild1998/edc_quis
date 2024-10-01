<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MapingArea extends Model
{
    use HasFactory;

    protected $table = 'maping_area';

    protected $fillable = [
        'area_id',
        'subdistrict_id',
        'status',
    ];

    public $timestamps = false;
}
