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
        Schema::create('cat_c_postal_colonias', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->unsignedInteger('cp');
            $table->string('asentamiento_nombre');
            $table->unsignedInteger('municipio_id');
            $table->unsignedInteger('entidad_id');
            $table->string('ciudad');
            $table->foreign('entidad_id')->references('id')->on('cat_entidades')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('municipio_id')->references('id')->on('cat_municipios')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cat_c_postal_colonias');
    }
};
