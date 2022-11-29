<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicitante', function (Blueprint $table) {
            $table->id();
            $table->string("nombre")->default(1);
            $table->string("apellido_paterno")->default(1);
            $table->string("apellido_materno")->default(1);
            $table->string("email")->default(1);
            $table->string("contrasena", 255);
            $table->string("telefono")->default(1);
            $table->string("direccion", 255);
            $table->string("colonia", 255);
            $table->string("código_postal", 255);
            $table->string("ciudad", 255);
            $table->string("descripcion_profesional", 255);
            $table->string("área_desempeñarte", 255);
            $table->string("que_posicion_buscas", 255);
            $table->string("que_industria_interesan", 255);
            $table->string("que_habilidad_posees", 255);
            $table->string("experiencia_profesional", 255);
            $table->string("formacion_educativa", 255);
            $table->string("currículum", 255);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('solicitante');
    }
};
