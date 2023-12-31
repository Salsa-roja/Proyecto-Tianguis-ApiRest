<?php

namespace App\DTO;

use App\Models\Vacantes;

class VacantesListDTO
{
    public $id;
    public $id_empresa;
    public $vinculadoId;
    public $nombre_comercial;
    public $vacante;
    public $descripcion;
    public $categorías_especiales;
    public $dias_laborales;
    public $id_turnos_laborales;
    public $id_nivel_educativo;
    public $turnos_laborales;
    public $nivel_educativo;
    public $sueldo;
    public $calle;
    public $colonia;
    public $código_postal;
    public $ciudad;
    public $numero_de_puestos_disponibles;
    public $area;
    public $industria;
    public $tipo_de_puesto;
    public $habilidades_requeridas;
    public $lat;
    public $lng;

    public function __construct(Vacantes $obj)
    {
        $this->id = $obj->id;
        $this->id_empresa = $obj->id_empresa;
        $this->vinculadoId = $obj->vinculado;
        $this->nombre_comercial = $obj->empresa->nombre_comercial;
        $this->vacante = $obj->vacante;
        $this->descripcion = $obj->descripcion;
        $this->categorías_especiales = $obj->categorías_especiales;
        $this->dias_laborales = $obj->dias_laborales;
        $this->id_turnos_laborales = $obj->tabla_turnos_laborales->id;
        $this->id_nivel_educativo = $obj->tabla_nivel_educativo->id;
        $this->turnos_laborales = $obj->tabla_turnos_laborales->turnos;
        $this->nivel_educativo = $obj->tabla_nivel_educativo->titulo;
        $this->sueldo = $obj->sueldo;
        $this->calle = $obj->calle;
        $this->colonia = $obj->colonia;
        $this->código_postal = $obj->código_postal;
        $this->ciudad = $obj->ciudad;
        $this->numero_de_puestos_disponibles = $obj->numero_de_puestos_disponibles;
        $this->area = $obj->area;
        $this->industria = $obj->industria;
        $this->tipo_de_puesto = $obj->tipo_de_puesto;
        $this->habilidades_requeridas = $obj->habilidades_requeridas;
        $this->lat = $obj->lat;
        $this->lng = $obj->lng;
    }
}
