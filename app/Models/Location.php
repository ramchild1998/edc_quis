<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $table = 'location';

    protected $fillable = [
        'area_id',
        'lokasi',
        'id_lokasi',
        'status',
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

}
