<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventaris extends Model
{
    use HasFactory;

    protected $table = 'inventaris';

    protected $fillable = ['id', 'jenis_inventaris', 'nama', 'no_register', 'tahun_perolehan', 'nilai_aset', 'luas', 'status', 'alamat', 'kelurahan_id', 'kecamatan_id', 'no_dokumen_sertifikat', 'skpd_id', 'master_barang_id'];


    public function master_barang()
    {
        return $this->belongsTo(MasterBarang::class, 'master_barang_id', 'id_barang');
    }

    public function master_skpd()
    {
        return $this->belongsTo(Skpd::class, 'skpd_id', 'id_skpd');
    }

    public function kelurahan()
    {
        return $this->belongsTo(Kelurahan::class, 'kelurahan_id', 'id_kelurahan');
    }

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'kecamatan_id', 'id_kecamatan');
    }

    public function geometry()
    {
        return $this->hasOne(Geometry::class);
    }

    public function galery()
    {
        return $this->hasOne(Galery::class);
    }

    public function document()
    {
        return $this->hasOne(Document::class);
    }
}
