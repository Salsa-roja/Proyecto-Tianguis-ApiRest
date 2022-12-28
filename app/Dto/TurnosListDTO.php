<?php

namespace App\Dto;

use App\Models\Turnos_laborales;

class TurnosListDTO
{
    public $id;
    public $turnos;

    public function __construct(Turnos_laborales $obj)
    {
        $this->id = $obj->id;
        $this->turnos = $obj->turnos;
    }
}
