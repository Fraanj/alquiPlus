<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('resenias', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('maquina_id');
            $table->text('comentario')->nullable();
            $table->unsignedTinyInteger('calificacion');
            $table->timestamp('fecha')->useCurrent();

            // Foreign keys
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('maquina_id')->references('id')->on('maquinarias')->onDelete('cascade');

            // Restricción de calificación
            //NOT SUPPORTED $table->check('calificacion BETWEEN 1 AND 5');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resenias');
    }
};
