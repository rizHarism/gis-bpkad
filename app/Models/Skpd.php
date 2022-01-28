<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skpd extends Model
{
    use HasFactory;
    protected $table = 'master_skpd';
    protected $primaryKey = "id_skpd";
    protected $fillable = ['id_skpd', 'nama_skpd', 'kode_skpd'];

    public function inventaris()
    {
        return $this->hasMany(Inventaris::class, 'id_skpd', 'skpd_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id_skpd', 'skpd_id');
    }
}
