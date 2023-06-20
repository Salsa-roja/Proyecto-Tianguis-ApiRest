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
        Schema::create('solicitantes', function (Blueprint $table) {
            $table->integerIncrements("id");
            $table->unsignedInteger("id_usuario");
            $table->integer("edad");
            $table->string("curp");
            $table->string("telefono");
            $table->string("c_numero", 255);
            $table->string("c_postal", 255);
            $table->unsignedInteger("id_colonia");
            $table->string("ciudad", 255);
            $table->string("descr_profesional", 255);
            $table->integer("sueldo_deseado");
            $table->string("area_desempeno", 255);
            $table->string("posicion_interes", 255);
            $table->string("industria_interes", 255);
            $table->string("habilidades", 255);
            $table->string("exp_profesional", 255);
            $table->boolean("disc_lenguaje")->default(0);
            $table->boolean("disc_motriz")->default(0);
            $table->boolean("disc_visual")->default(0);
            $table->boolean("disc_mental")->default(0);
            $table->boolean("disc_auditiva")->default(0);
            $table->enum('lugar_atencion',["Web","Dependencia","Feria"]);
            $table->string("curriculum", 255)->default('');
            $table->unsignedBigInteger("id_nivel_educativo");

            $table->foreign('id_nivel_educativo')->references('id')->on('nivel_educativo');
            $table->foreign('id_usuario')->references('id')->on('usuarios')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('id_colonia')->references('id')->on('cat_c_postal_colonias')->onUpdate('cascade')->onDelete('cascade');

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
        Schema::dropIfExists('solicitantes');
    }
};
