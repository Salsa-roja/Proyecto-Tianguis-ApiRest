<?php

namespace App\Dto;

use App\Models\Empresa;

class EmpresaDto
{


    public $id;
    public $id_Usuario = [];
    public $nombre_comercial;
    public $razon_social;
    public $rfc;
    public $descripcion;
    public $numero_empleados;
    public $constancia_sit_fiscal;
    public $licencia_municipal;
    public $alta_patronal;
    public $contr_discapacitados;
    public $contr_antecedentes;
    public $contr_adultos;
    public $nombre_rh;
    public $correo_rh;
    public $telefono_rh;
    public $files;
    public $id_estatus;
    public $estatus;

    public function __construct(Empresa $obj)
    {
        $this->id = $obj->id;
        foreach ($obj->usuario_empresa as $usuarioEmpresa) {
            array_push($this->id_Usuario, $usuarioEmpresa->id_usuario);
        }
        $this->nombre_comercial = $obj->nombre_comercial;
        $this->razon_social = $obj->razon_social;
        $this->rfc = $obj->rfc;
        $this->descripcion = $obj->descripcion;
        $this->numero_empleados = $obj->numero_empleados;
        $this->constancia_sit_fiscal = $obj->constancia_sit_fiscal;
        $this->licencia_municipal = $obj->licencia_municipal;
        $this->alta_patronal = $obj->alta_patronal;
        $this->contr_discapacitados = $obj->contr_discapacitados;
        $this->contr_antecedentes = $obj->contr_antecedentes;
        $this->contr_adultos = $obj->contr_adultos;
        $this->nombre_rh = $obj->nombre_rh;
        $this->correo_rh = $obj->correo_rh;
        $this->telefono_rh = $obj->telefono_rh;
        $this->files = $obj->id;
        $this->id_estatus = $obj->id_estatus;
        $this->estatus = $obj->empresa_estatus->estatus;
    }
}
