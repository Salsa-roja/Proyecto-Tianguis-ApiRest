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
        Schema::create('empresas', function (Blueprint $table) {
            $table->integerIncrements("id"); 
            $table->string('nombre_comercial');
            $table->string('razon_social');
            $table->string('rfc');
            $table->text('descripcion');
            $table->string('numero_empleados');
            $table->string('constancia_sit_fiscal');
            $table->string('licencia_municipal');
            $table->string('alta_patronal');
            $table->boolean('')->default(0);
            $table->boolean('')->default(0);
            $table->boolean('')->default(0);
            $table->string('nombre_rh');
            $table->string('correo_rh');
            $table->string('telefono_rh');

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
        Schema::dropIfExists('empresas');
    }
};
