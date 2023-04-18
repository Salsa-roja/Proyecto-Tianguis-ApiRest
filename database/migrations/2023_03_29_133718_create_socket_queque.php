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
        /**
         * Almacena una lista de Notificaciones pendientes de emision, generadas por la api
        */
        Schema::create('socket_queque', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('id_usuario');
            $table->string('sala');
            $table->string('titulo');
            $table->string('descripcion');
            $table->boolean('vista')->default(false);
            $table->boolean('enviada')->default(false);
            $table->timestamps();

            $table->foreign('id_usuario')->references('id')->on('usuarios')
                ->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('socket_queque');
    }
};
