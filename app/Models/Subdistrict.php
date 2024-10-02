<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subdistrict extends Model
{
    use HasFactory;

    protected $table = 'subdistrict';

    protected $fillable = [
        'subdistrict_name',
        'district_id',
    ];

    public $timestamps = false;

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function poscodes()
    {
        return $this->hasMany(Poscode::class);
    }
}
