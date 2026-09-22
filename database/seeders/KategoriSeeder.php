<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Kategori::create([
            'nama_kategori' => 'Makanan',
            'deskripsi' => 'Kategori produk makanan',
        ]);

        Kategori::create([
            'nama_kategori' => 'Minuman',
            'deskripsi' => 'Kategori produk minuman',
        ]);

        Kategori::create([
            'nama_kategori' => 'Sembako',
            'deskripsi' => 'Kategori kebutuhan pokok',
        ]);

        Kategori::create([
            'nama_kategori' => 'Peralatan Rumah Tangga',
            'deskripsi' => 'Kategori peralatan rumah tangga',
        ]);

        Kategori::create([
            'nama_kategori' => 'Lainnya',
            'deskripsi' => 'Kategori produk lainnya',
        ]);
    }
}
