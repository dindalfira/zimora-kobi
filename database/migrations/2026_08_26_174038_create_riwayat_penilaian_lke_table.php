<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('riwayat_penilaian_lke', function (Blueprint $table) {

            $table->id();

            // Tahun/periode penilaian
            $table->year('periode');

            // Relasi ke SubPilarLKE
            $table->string('id_subpilar');

            // Hasil penilaian
            $table->decimal('nilai_mandiri', 8, 2)->default(0);

            // Simpan bobot saat penilaian dilakukan
            $table->decimal('bobot', 8, 2)->default(0);

            // Nilai mandiri × bobot
            $table->decimal('bobot_mandiri', 8, 2)->default(0);

            $table->timestamps();

            // Satu subpilar hanya satu hasil untuk satu periode
            $table->unique(
                ['periode', 'id_subpilar'],
                'riwayat_periode_subpilar_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('riwayat_penilaian_lke');
    }
};