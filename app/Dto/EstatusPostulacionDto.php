<?php

namespace App\Dto;

use App\Models\Estatus_Postulacion;

class EstatusPostulacionDto
{
    public $id;
    public $estatus;

    public function __construct(Estatus_Postulacion $obj)
    {
        $this->id = $obj->id;
        $this->estatus = $obj->estatus;
    }
}
