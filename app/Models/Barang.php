<?php

namespace App\Models;

use App\Models\Satuan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Barang extends Model
{
    use HasFactory;

    public function kategori(){
        return $this->belongsTo(Kategori::class, 'kategori_id', 'id');
    }

    public function satuan(){
        return $this->belongsTo(Satuan::class, 'satuan_id', 'id');
    }

}
