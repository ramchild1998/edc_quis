<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    use HasFactory;

    protected $table = 'office';

    protected $fillable = [
            'code_office',
            'office_name',
            'address',
            'pic_name',
            'email',
            'phone',
            'status',
            'vendor_id',
            'province_id',
            'city_id',
            'district_id',
            'subdistrict_id',
            'poscode_id',
        ];

    public $timestamps = true;
}
