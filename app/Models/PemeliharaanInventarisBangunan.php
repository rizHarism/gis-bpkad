<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemeliharaanInventarisBangunan extends Model
{
    use HasFactory;

    protected $table = 'pemeliharaan_inventaris_c';
    protected $fillable = ['inventaris_id', 'nama_pemeliharaan', 'tahun_pemeliharaan', 'nilai_aset'];

    public function inventarisGedung()
    {
        return $this->belongsTo(Kecamatan::class, 'id_inventaris', 'inventaris_id');
    }
}
