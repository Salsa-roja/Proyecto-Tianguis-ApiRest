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
         * Almacena una conexion del cliente con el servidor websocket
        */
        Schema::create('socket_active_connections', function (Blueprint $table) {
            $table->string('idHandshake')->unique();
            $table->unsignedInteger('id_usuario');
            $table->timestamp('created_at')->nullable();

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
        Schema::dropIfExists('socket_active_connections');
    }
};
