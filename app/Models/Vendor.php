<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    protected $table = 'vendor';

    protected $fillable = [
            'vendor_name',
            'pic_name',
            'email',
            'phone',
            'status',
        ];

    public $timestamps = true;
}
