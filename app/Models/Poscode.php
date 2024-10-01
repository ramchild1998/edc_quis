<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poscode extends Model
{
    use HasFactory;
    protected $fillable = [
            'poscode',
            'subdistrict_id',
        ];

    public $timestamps = false;

    public function subdistrict()
    {
        return $this->belongsTo(Subdistrict::class);
    }
}
