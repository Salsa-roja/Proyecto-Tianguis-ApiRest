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
        Schema::create('empleador', function (Blueprint $table) {
            $table->id();
            $table->string("nombre")->default(1);
            $table->string("ap_paterno")->default(1);
            $table->string("ap_materno")->default(1);
            $table->string("email")->default(1);
            $table->string("contrasena", 255);
            $table->string("telefono")->default(1);
            $table->string("direccion", 255);
            $table->string("colonia", 255);
            $table->string("código_postal", 255);
            $table->string("ciudad", 255);
            $table->string("notas")->default(1);
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            
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
        Schema::dropIfExists('empleador');
    }
};
