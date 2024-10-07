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
        'sub_area',
        'status',
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function subdistrict()
    {
        return $this->belongsTo(Subdistrict::class);
    }
}
