<?php

namespace App\Dto;

use App\Models\Permiso;

class PermisoListDto
{
        public $id;
        public $nombre;
        public $permiso;


    public function __construct(Permiso $obj)
    {

        $this->id = $obj->id;
        $this->nombre = $obj->nombre;
        $this->permiso = $obj->permiso;
        
    }
}
