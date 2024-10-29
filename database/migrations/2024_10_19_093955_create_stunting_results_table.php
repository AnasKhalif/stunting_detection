<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStuntingResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stunting_results', function (Blueprint $table) {
            $table->id(); // ID unik untuk setiap hasil prediksi
            $table->string('gender'); // Kolom untuk jenis kelamin
            $table->integer('age'); // Kolom untuk usia (dalam bulan)
            $table->decimal('height', 5, 2); // Kolom untuk tinggi badan saat ini (cm)
            $table->foreignId('city_id')->constrained('indonesia_cities'); // Relasi dengan tabel cities
            $table->string('prediction_result'); // Kolom untuk hasil prediksi ('Stunting' atau 'Tidak Stunting')
            $table->timestamps(); // Kolom created_at dan updated_at untuk tracking waktu
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stunting_results');
    }
}
