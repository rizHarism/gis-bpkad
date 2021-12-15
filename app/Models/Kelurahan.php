<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelurahan extends Model
{
    use HasFactory;
    protected $table = 'kelurahan';
    protected $fillable = ['id_kelurahan', 'nama_kelurahan'];

    public function inventaris()
    {
        return $this->hasMany(Inventaris::class, 'id_kelurahan', 'kelurahan_id');
    }
}
