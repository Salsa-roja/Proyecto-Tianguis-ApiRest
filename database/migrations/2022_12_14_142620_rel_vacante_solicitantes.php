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
        Schema::create('relVacanteSolicitante', function (Blueprint $table) {
            $table->id();
           
            $table->integer('idVacante')->unsigned();
            $table->foreign('idVacante')->references('id')->on('vacante')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->integer('idSolicitante')->unsigned();
            $table->foreign('idSolicitante')->references('id')->on('solicitante')
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
