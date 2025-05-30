<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('maquina_id');
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->decimal('monto_total', 10, 2);
            $table->timestamp('fecha_reserva')->useCurrent();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('maquina_id')->references('id')->on('maquinarias')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservas');
    }
};
