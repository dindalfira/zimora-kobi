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
        Schema::create('kegiatans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kegiatan',500);
            $table->string('pilar');
            $table->string('kode_pertanyaan');
            $table->string('pedoman_bukti',1000);
            $table->string('jenis_bukti',10);            

            $table->string('waktu');
            $table->date('waktu_pemenuhan');

            $table->string('frekuensi_pelaksanaan');
            $table->unsignedInteger('jumlah_pelaksanaan');   
            $table->string('status_pelaksanaan');
            $table->string('dokumentasi_kegiatan',500);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kegiatans');
    }
};
