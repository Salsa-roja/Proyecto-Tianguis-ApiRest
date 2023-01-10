<?php

namespace App\Dto;

use App\Models\Usuarios;

class UsuarioListDto
{
    public $id;
    public $nombreCompleto;
    public $nombres;
    public $ape_paterno;
    public $ape_materno;
    public $correo;
    public $idRol;
    public $rol;


    public function __construct(Usuarios $obj)
    {

        $this->id = $obj->id;
        $this->nombres = $obj->nombres;
        $this->ape_paterno = $obj->ape_paterno;
        $this->ape_materno = $obj->ape_materno;
        $this->nombreCompleto = $obj->nombre_completo;
        $this->correo = $obj->correo;
        $this->idRol=$obj->rol->id;
        $this->rol = $obj->rol->nombre;
    }
}
