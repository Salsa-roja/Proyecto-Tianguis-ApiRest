<?php

namespace App\Dto;

use App\Models\Rol;

class RolListDTO
{
    public $id;
    public $nombre;
    public $activo;
    public $permisos=[];


    public function __construct(Rol $obj)
    {

        $this->id = $obj->id;
        $this->nombre = $obj->nombre;
        $this->activo = $obj->activo;

        foreach ($obj->permisos as $permiso) {
            array_push( $this->permisos, ['nombre'=> $permiso->nombre, 'permiso'=> $permiso->permiso])  ;
          
         }
    }
}
