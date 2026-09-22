<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'foto')) {
                $table->string('foto')->nullable()->after('email');
            }

            if (!Schema::hasColumn('users', 'nama_perusahaan')) {
                $table->string('nama_perusahaan')->nullable()->after('foto');
            }

            if (!Schema::hasColumn('users', 'website')) {
                $table->string('website')->nullable()->after('nama_perusahaan');
            }

            if (!Schema::hasColumn('users', 'deskripsi')) {
                $table->text('deskripsi')->nullable()->after('website');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['foto', 'nama_perusahaan', 'website', 'deskripsi']);
        });
    }
};
