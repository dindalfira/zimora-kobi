<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('pertanyaan_lke')) {
            Schema::create('pertanyaan_lke', function (Blueprint $table) {

                $table->string('id_subpilar');
                $table->string('id_pertanyaan');

                $table->text('nama_pertanyaan');
                $table->text('kriteria_nilai');
                $table->string('kriteria_jawaban');
                $table->string('waktu');

                $table->integer('jumlah_bukti_dukung')->default(0);
                $table->string('status_pertanyaan');
                $table->decimal('nilai_pertanyaan',10,2);
                $table->decimal('bobot_pertanyaan',10,2);

                $table->timestamps();

                $table->foreign('id_subpilar')
                    ->references('id_subpilar')
                    ->on('SubPilarLKE')
                    ->onUpdate('cascade')
                    ->onDelete('restrict');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('pertanyaan_lke');
    }
};