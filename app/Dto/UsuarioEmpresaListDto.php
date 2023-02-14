<?php

namespace App\Dto;

use App\Models\UsuariosEmpresas;

class UsuarioEmpresaListDto
{
    public $id;
    public $id_empresa;
    public $id_usuario;
    public $nombreCompleto;
    public $nombres;
    public $ape_paterno;
    public $ape_materno;
    public $correo;
    public $idRol;
    public $rol;


    public function __construct(UsuariosEmpresas $obj)
    {

        $this->id = $obj->id;
        $this->id_empresa = $obj->id_empresa;
        $this->id_usuario = $obj->id_usuario;

        if(isset($obj->rel_usuarios)){
            $this->nombres          = $obj->rel_usuarios->nombres;
            $this->ape_paterno      = $obj->rel_usuarios->ape_paterno;
            $this->ape_materno      = $obj->rel_usuarios->ape_materno;
            $this->nombreCompleto   = $obj->rel_usuarios->nombre_completo;
            $this->correo           = $obj->rel_usuarios->correo;
            $this->idRol            = $obj->rel_usuarios->rol->id;
            $this->rol              = $obj->rel_usuarios->rol->nombre;
        }
    }
}
