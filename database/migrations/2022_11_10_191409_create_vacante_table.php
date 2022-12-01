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
        Schema::create('vacante', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger("idUsuario");
            $table->string("titulo", 255);
            $table->string("descripcion", 255);
            $table->string("categorías_especiales", 255);       
            $table->string("días_laborales")->default(1);
            $table->string("turnos_laborales", 255);
            $table->string("nivel_educativo", 255);
            $table->string("direccion", 255);
            $table->string("colonia", 255);
            $table->string("código_postal", 255);
            $table->string("ciudad", 255);
            $table->string("número_de_puestos_disponibles", 255);
            $table->string("area", 255);
            $table->string("Industria", 255);
            $table->string("tipo_de_puesto", 255);
            $table->string("habilidades_requeridas", 255);
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();

            $table->timestamps();

            $table->foreign('empleador_id')->references('id')->on('empleador');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vacante');
    }
};
