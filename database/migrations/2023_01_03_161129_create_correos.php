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
        Schema::create('correos', function (Blueprint $table) {
            $table->comment('correos enviados de usuario a usuario');
            $table->id();
            $table->bigInteger('remitente');
            $table->foreign('remitente')->references('id')->on('usuarios');
            $table->bigInteger('destinatario');
            $table->foreign('destinatario')->references('id')->on('usuarios');
            $table->string('asunto');
            $table->text('cuerpo');
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
        Schema::dropIfExists('correos');
    }
};
