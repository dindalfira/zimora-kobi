<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('SubPilarLKE', function (Blueprint $table) {
            $table->id();

            $table->string('nama_area');
            $table->string('nama_pilar');
            $table->text('nama_subpilar');

            $table->decimal('bobot', 10, 2);

            $table->string('aspek');
            $table->string('area');
            $table->string('pilar');
            $table->string('subpilar');
            $table->string('id_subpilar');
            $table->int('jumlah_bukti_dukung');

            $table->string('status');
            $table->integer('kelengkapan_pemenuhan');
            $table->decimal('nilai_mandiri', 10, 2);

        
            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('SubPilarLKE');
    }
};