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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->integer('luas_lahan');
            $table->bigInteger('id_jagung');
            $table->bigInteger('id_pupuk');
            $table->bigInteger('id_pupuk_sec');
            $table->bigInteger('tipe_penanaman');
            $table->bigInteger('id_user');
            $table->date('tgl_mulai');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
