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
        if(!Schema::hasTable('pelaksanaan_kegiatan')) {
        Schema::create('pelaksanaan_kegiatan', function (Blueprint $table) {
            $table->id();
            // Relasi ke kegiatan
            $table->foreignId('kegiatan_id')
                ->constrained('kegiatans')
                ->cascadeOnDelete();

            // Urutan periode
            // 1 = TW I, 2 = TW II, dst.
            $table->unsignedInteger('periode_ke');

            // Contoh: TW I, TW II, Semester I, Tahunan
            $table->string('periode', 50);

            // Tanggal pelaksanaan masing-masing periode
            $table->date('waktu_pemenuhan');
            
            // Link Google Drive dokumentasi kegiatan
            $table->string('dokumentasi', 500)
                ->nullable();

            $table->string('status_pelaksanaan', 50)
                ->nullable();

            $table->timestamps('time_updated');

            $table->timestamps();

            // Mencegah periode yang sama dibuat dua kali
            $table->unique(
                ['kegiatan_id', 'periode_ke'],
                'kegiatan_periode_unique'
            );
 
        });
    }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelaksanaan_kegiatan');
    }
};
