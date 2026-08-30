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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');

            $table->string('tipe');
            $table->string('judul');
            $table->text('pesan');

            $table->unsignedBigInteger('id_pilar')->nullable();
            $table->unsignedBigInteger('id_pertanyaan')->nullable();

            $table->string('url')->nullable();

            $table->boolean('dibaca')->default(false);
            $table->timestamp('dibaca_at')->nullable();

            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
