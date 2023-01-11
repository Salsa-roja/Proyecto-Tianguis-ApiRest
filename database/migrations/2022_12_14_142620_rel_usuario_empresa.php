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
        Schema::create('relUsuarioEmpresa', function (Blueprint $table) {
            $table->id();
                            
            $table->unsignedInteger('id_usuario');
            $table->foreign('id_usuario')->references('id')->on('usuarios')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedInteger('id_empresa');
            $table->foreign('id_empresa')->references('id')->on('empresas')
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
        Schema::dropIfExists('relUsuarioEmpresa');
    }
};
