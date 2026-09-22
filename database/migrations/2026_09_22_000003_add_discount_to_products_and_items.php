<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('produk', function (Blueprint $table) {
            $table->unsignedTinyInteger('diskon_persen')->default(0)->after('harga_jual');
        });

        Schema::table('item_penjualan', function (Blueprint $table) {
            $table->unsignedTinyInteger('diskon_persen')->default(0)->after('harga_satuan');
        });
    }

    public function down(): void
    {
        Schema::table('item_penjualan', function (Blueprint $table) {
            $table->dropColumn('diskon_persen');
        });

        Schema::table('produk', function (Blueprint $table) {
            $table->dropColumn('diskon_persen');
        });
    }
};
