<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produk';

    protected $fillable = [
        'user_id',
        'kategori_id', // Ditambahkan
        'foto',
        'nama',
        'harga_beli',
        'harga_jual',
        'diskon_persen',
        'stok',
    ];

    // Relasi ke Model Kategori (DITAMBAHKAN)
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}