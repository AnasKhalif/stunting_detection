<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('child_vaccinations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('child_id')->constrained('children')->cascadeOnDelete();
            $table->string('vaccine_code', 50)->comment('Kode vaksin sesuai master, misal: hepb_0, bcg, polio_1, dpt_hb_hib_1');
            $table->date('given_date');
            $table->string('batch_no', 50)->nullable();
            $table->foreignId('given_by')->nullable()->constrained('users')->nullOnDelete()->comment('Petugas yang memberi imunisasi');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['child_id', 'vaccine_code']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('child_vaccinations');
    }
};
