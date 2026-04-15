<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement(
            "ALTER TABLE stunting_results MODIFY prediction_result VARCHAR(50) NOT NULL"
        );
    }

    public function down(): void
    {
        DB::statement(
            "ALTER TABLE stunting_results MODIFY prediction_result ENUM('Normal', 'Berisiko', 'Stunting') NOT NULL"
        );
    }
};
