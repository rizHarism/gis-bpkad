<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Galery extends Model
{
    use HasFactory;
    protected $table = 'galery';

    protected $fillable = ['inventaris_id', 'image_path'];

    public function inventaris()
    {
        return $this->belongsTo(Inventaris::class);
    }
}
