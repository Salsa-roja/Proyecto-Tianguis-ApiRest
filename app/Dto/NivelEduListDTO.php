<?php

namespace App\DTO;

use App\Models\Nivel_educativo;

class NivelEduListDTO
{
    public $id;
    public $titulo;

    public function __construct(Nivel_educativo $obj)
    {
        $this->id = $obj->id;
        $this->titulo = $obj->titulo;
    }
}
