<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('children', function (Blueprint $table) {
            $table->boolean('asi_eksklusif')->nullable()->after('birth_height')
                ->comment('Apakah anak mendapat ASI Eksklusif 0-6 bulan (sesuai KMS Buku KIA)');
        });
    }

    public function down(): void
    {
        Schema::table('children', function (Blueprint $table) {
            $table->dropColumn('asi_eksklusif');
        });
    }
};
