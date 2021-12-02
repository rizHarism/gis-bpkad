<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterBarang extends Model
{
    use HasFactory;
    protected $table = 'master_barang';
    protected $fillable = ['id', 'nama', 'kode_barang'];

    public function inventaris()
    {
        return $this->hasMany(Inventaris::class);
    }
}
