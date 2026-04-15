<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        // Add column only if it doesn't exist yet
        if (!Schema::hasColumn('children', 'uuid')) {
            Schema::table('children', function (Blueprint $table) {
                $table->uuid('uuid')->nullable()->after('id');
            });
        }

        // Fill UUID for existing rows that don't have one
        DB::table('children')->whereNull('uuid')->orderBy('id')->each(function ($row) {
            DB::table('children')->where('id', $row->id)->update(['uuid' => Str::uuid()]);
        });

        // Make uuid NOT NULL and unique
        Schema::table('children', function (Blueprint $table) {
            $table->uuid('uuid')->nullable(false)->unique()->change();
        });
    }

    public function down(): void
    {
        Schema::table('children', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });
    }
};
