<?php

namespace App\Dto;

use App\Models\Vacantes;

class VacantesListDTO
{
    public $id;
    public $domicilio;
    public $lat;
    public $lng;
    public $contestaciones;
    public $activo;


    public function __construct(Vacantes $obj)
    {
        $this->id = $obj->id;
        $this->domicilio = $obj->domicilio;
        $this->lat = $obj->lat;
        $this->lng = $obj->lng;
        $this->contestaciones = ParseDTO::list($obj->contestaciones, ContestacionesListDTO::class);
        $this->activo = $obj->activo;
    }
}
