<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bukti_dukung_lke', function (Blueprint $table) {
            $table->string('id_subpilar');
            $table->foreignId('id_pertanyaan')
                ->constrained('pertanyaan_lke')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->string('id_bukti_dukung');

            $table->text('nama_bukti_dukung');

            $table->string('status_bukti_dukung')
                ->default('belum');

            $table->string('link_bukti_dukung')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps('time_created')->nullable();
            $table->timestamps('time_updated')->nullable();


            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bukti_dukung_lke');
    }
};