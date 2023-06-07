<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsuariosTable extends Migration
{
    public function up() 
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->engine = "InnoDB";
            $table->integerIncrements('id');
            $table->unsignedInteger("rol_id");
            $table->string("nombres", 255);
            $table->string("ape_paterno", 255);
            $table->string("ape_materno", 255);
            $table->string("nombre_login", 40);
            $table->string("correo", 155);
            $table->string("contrasena", 255);
            $table->boolean("activo")->default(1);
            $table->integer("no_de_alertas")->default(0);
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();
            
            $table->foreign('rol_id')->references('id')->on('cat_roles');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tbl_usuarios');
    }
}