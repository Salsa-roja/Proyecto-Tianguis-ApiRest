<?php

namespace App\DTO;

use App\Models\Usuarios;

class UsuarioListDTO
{
    public $id;
    public $nombreCompleto;
    public $nombres;
    public $ape_paterno;
    public $ape_materno;
    public $nombre_login;
    public $correo;
    public $idRol;
    public $rol;
    public $idEmpresa;


    public function __construct(Usuarios $obj)
    {

        $this->id = $obj->id;
        $this->nombres = $obj->nombres;
        $this->nombre_login = $obj->nombre_login;
        $this->ape_paterno = $obj->ape_paterno;
        $this->ape_materno = $obj->ape_materno;
        $this->nombreCompleto = $obj->nombre_completo;
        $this->correo = $obj->correo;
        $this->idRol=$obj->rol->id;
        $this->rol = $obj->rol->nombre;
        if(isset($obj->usuario_empresa))
            $this->idEmpresa = $obj->usuario_empresa->id_empresa;
    }
}
