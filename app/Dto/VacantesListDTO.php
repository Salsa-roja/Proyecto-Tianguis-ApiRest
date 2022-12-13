<?php

namespace App\Dto;

use App\Models\Vacantes;

class VacantesListDTO
{
    public $id;
    public $nombre_de_empresa ;
    public $titulo;
    public $descripcion;
    public $categorías_especiales;
    public $días_laborales;
    public $turnos_laborales;
    public $nivel_educativo;
    public $direccion;
    public $colonia;
    public $código_postal;
    public $ciudad;
    public $número_de_puestos_disponibles;
    public $area;
    public $Industria;
    public $tipo_de_puesto;
    public $habilidades_requeridas;



    public function __construct(Vacantes $obj)
    {
        $this->id = $obj->id;
        $this->titulo = $obj->titulo;
        $this->nombre_de_empresa = $obj->empleador->nombre;
        $this->descripcion = $obj->descripcion;
        $this->categorías_especiales = $obj->categorías_especiales;
        $this->días_laborales = $obj->días_laborales;
        $this->turnos_laborales = $obj->turnos_laborales;
        $this->nivel_educativo = $obj->nivel_educativo;
        $this->direccion = $obj->direccion;
        $this->colonia = $obj->colonia;
        $this->código_postal = $obj->código_postal;
        $this->ciudad = $obj->ciudad;
        $this->número_de_puestos_disponibles = $obj->número_de_puestos_disponibles;
        $this->area = $obj->area;
        $this->Industria = $obj->Industria;
        $this->tipo_de_puesto = $obj->tipo_de_puesto;
        $this->habilidades_requeridas = $obj->habilidades_requeridas;
    }
}
