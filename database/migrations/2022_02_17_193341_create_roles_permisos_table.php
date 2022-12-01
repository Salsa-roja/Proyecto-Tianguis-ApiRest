<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolesPermisosTable extends Migration
{
    public function up()
    {
        Schema::create('roles_permisos', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->unsignedInteger("rol_id");
            $table->unsignedInteger("permiso_id");
            $table->boolean("activo")->default(1);
            $table->timestamps();

            $table->foreign('rol_id')->references('id')->on('cat_roles');
            $table->foreign('permiso_id')->references('id')->on('cat_permisos');
        });
    }

    public function down()
    {
        Schema::dropIfExists('roles_permisos');
    }
}