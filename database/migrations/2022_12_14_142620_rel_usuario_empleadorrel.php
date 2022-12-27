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
        Schema::create('relUsuarioEmpleador', function (Blueprint $table) {
            $table->id();
                            
            $table->unsignedInteger('idUsuario');
            $table->foreign('idUsuario')->references('id')->on('usuarios')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedInteger('idEmpleador');
            $table->foreign('idEmpleador')->references('id')->on('empleador')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';

            $table->boolean('activo')->default(1);
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
        Schema::dropIfExists('relVacanteSolicitante');
    }
};
