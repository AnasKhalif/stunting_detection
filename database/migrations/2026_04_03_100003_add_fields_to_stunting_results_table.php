<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('stunting_results', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete()->after('id');
            $table->foreignId('child_id')->nullable()->constrained('children')->nullOnDelete()->after('user_id');
            $table->decimal('weight', 5, 2)->nullable()->comment('kg')->after('height');
            $table->date('measurement_date')->nullable()->after('weight');
            $table->decimal('z_score', 6, 3)->nullable()->after('measurement_date');
            $table->string('who_standard_ref')->nullable()->after('z_score');
            $table->text('notes')->nullable()->after('prediction_result');
        });

        // Update prediction_result menjadi enum Normal/Berisiko/Stunting
        // Menggunakan DB::statement karena Laravel tidak bisa langsung alter enum
        \Illuminate\Support\Facades\DB::statement(
            "ALTER TABLE stunting_results MODIFY prediction_result ENUM('Normal', 'Berisiko', 'Stunting') NOT NULL"
        );
    }

    public function down(): void
    {
        Schema::table('stunting_results', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['child_id']);
            $table->dropColumn(['user_id', 'child_id', 'weight', 'measurement_date', 'z_score', 'who_standard_ref', 'notes']);
        });

        \Illuminate\Support\Facades\DB::statement(
            "ALTER TABLE stunting_results MODIFY prediction_result VARCHAR(255) NOT NULL"
        );
    }
};
