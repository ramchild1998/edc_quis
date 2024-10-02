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
            'created_by',
            'updated_by',
        ];

    public $timestamps = true;

    public function vendor()
    {
        return $this->belongsTo(Vendor::class); // Pastikan ini sesuai dengan relasi yang Anda inginkan
    }

    public function province()
    {
        return $this->belongsTo(Province::class); // Pastikan ini sesuai dengan relasi yang Anda inginkan
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function subdistrict()
    {
        return $this->belongsTo(Subdistrict::class);
    }

    public function poscode()
    {
        return $this->belongsTo(Poscode::class);
    }
}
