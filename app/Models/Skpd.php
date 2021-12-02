<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skpd extends Model
{
    use HasFactory;
    protected $table = 'master_skpd';
    protected $fillable = ['id', 'nama', 'kode_skpd'];

    public function inventaris()
    {
        return $this->hasMany(Inventaris::class);
    }
}
