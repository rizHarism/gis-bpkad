<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Geometry extends Model
{
    use HasFactory;
    protected $table = 'geometry';
    protected $fillable = ['id', 'inventaris_id', 'polygon', 'lat', 'lng'];


    public function inventaris()
    {
        return $this->belongsTo(Inventaris::class);
    }
}
