<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subdistrict extends Model
{
    use HasFactory;

    protected $fillable = [
        'subdistrict_name',
        'district_id',
    ];

    public $timestamps = false;

    public function district()
    {
        return $this->belongsTo(District::class);
    }
}
