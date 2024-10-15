<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;

    protected $table = 'area';

    protected $fillable = [
        'area_id',
        'area_name',
        'status',
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function mapingArea()
    {
        return $this->hasOne(MapingArea::class);
    }
}
