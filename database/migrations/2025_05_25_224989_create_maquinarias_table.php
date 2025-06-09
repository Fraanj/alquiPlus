<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaquinariasTable extends Migration
{
    public function up()
    {
        Schema::create('maquinarias', function (Blueprint $table) {
            $table->id(); // equivale a INT UNSIGNED AUTO_INCREMENT PRIMARY KEY
            $table->string('nombre', 100);
            $table->text('descripcion')->nullable();
            $table->unsignedBigInteger('tipo_id');
            $table->unsignedBigInteger('disponibilidad_id');
            $table->decimal('precio_por_dia', 10, 2);
            $table->string('imagen', 255)->nullable();
            $table->enum('politica_reembolso', ['0', '20', '100']);
            $table->string('disclaimer', 255)->nullable();
            $table->integer('anio_produccion');
            $table->enum('sucursal', ['La Plata', 'Berisso', 'Ensenada']);

            // Claves foráneas (opcionalmente con restricciones)
            $table->foreign('tipo_id')->references('id')->on('tipos_maquinaria');
            $table->foreign('disponibilidad_id')->references('id')->on('disponibilidades');

            $table->timestamps(); // created_at y updated_at
        });
        //se elije unsignedBigInteger para las FK porque los id generados con $table->id() son BIGINT UNSIGNED, y las claves foráneas deben tener el mismo tipo.
    }

    public function down()
    {
        Schema::dropIfExists('maquinarias');
    }
}
