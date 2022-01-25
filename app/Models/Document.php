<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;
    protected $table = 'documents';

    protected $fillable = ['inventaris_id', 'doc_path'];

    public function inventaris()
    {
        return $this->belongsTo(Inventaris::class);
    }
}
