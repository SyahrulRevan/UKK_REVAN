<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategoris'; // Opsional, memastikan penamaan tabel plural

    protected $fillable = [
        'nama_kategori',
        'deskripsi',
    ];

    public function produks()
    {
        return $this->hasMany(Produk::class, 'kategori_id');
    }
}