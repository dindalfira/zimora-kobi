<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    { if (!Schema::hasTable('pemeriksaan_lke')) {
        Schema::create('pemeriksaan_lke', function (Blueprint $table) {
            $table->id();

            $table->foreignId('pertanyaan_lke_id')
                ->constrained('pertanyaan_lke')
                ->cascadeOnDelete();


            $table->enum('status_pemeriksaan', [
                'sesuai',
                'perbaikan'
            ]);

            $table->text('catatan_pemeriksaan')->nullable();
            $table->text('narasi')->nullable();

            $table->varchar('jawaban')->nullable();
            $table->decimal('nilai', 5, 2)->nullable();

            $table->decimal('persentase', 5, 2)->nullable();

            $table->foreignId('diperiksa_oleh')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->dateTime('diperiksa_pada',)->nullable();

            $table->timestamps();
        });
    }}

    public function down(): void
    {
        Schema::dropIfExists('pemeriksaan_lke');
    }
};