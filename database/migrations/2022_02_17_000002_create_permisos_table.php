<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermisosTable extends Migration
{
    public function up()
    {
        Schema::create('cat_permisos', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->string("nombre", 255);
            $table->string("permiso", 255);
            $table->boolean("activo")->default(1);
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('cat_permisos');
    }
}