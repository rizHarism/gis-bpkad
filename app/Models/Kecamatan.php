<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    use HasFactory;

    protected $table = 'kecamatan';
    protected $fillable = ['id_kecamatan', 'nama_kecamatan'];

    public function inventaris()
    {
        return $this->hasMany(Inventaris::class, 'id_kecamatan', 'kecamatan_id');
    }
}
