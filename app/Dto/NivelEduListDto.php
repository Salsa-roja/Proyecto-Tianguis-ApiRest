<?php

namespace App\Dto;

use App\Models\Nivel_educativo;

class NivelEduListDto
{
    public $id;
    public $titulo;

    public function __construct(Nivel_educativo $obj)
    {
        $this->id = $obj->id;
        $this->titulo = $obj->titulo;
    }
}
