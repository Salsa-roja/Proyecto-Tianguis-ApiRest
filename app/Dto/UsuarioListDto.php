<?php

namespace App\Dto;

use App\Models\Usuarios;

class UsuarioListDto
{
    public $id;
    public $nombreCompleto;
    public $nombres;
    public $apellido_paterno;
    public $apellido_materno;
    public $correo;
    public $idRol;
    public $rol;


    public function __construct(Usuarios $obj)
    {

        $this->id = $obj->id;
        $this->nombres = $obj->nombres;
        $this->apellido_paterno = $obj->ape_paterno;
        $this->apellido_materno = $obj->ape_materno;
        $this->nombreCompleto = $obj->nombre_completo;
        $this->correo = $obj->correo;
        $this->idRol=$obj->rol->id;
        $this->rol = $obj->rol->nombre;
    }
}
