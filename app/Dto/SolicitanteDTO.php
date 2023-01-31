<?php

namespace App\Dto;

use App\Models\Solicitante;

class SolicitanteDTO
{
   public $id_solicitante;
   public $id_usuario;
   public $edad;
   public $curp;
   public $telefono;
   public $c_numero;
   public $c_postal;
   public $id_colonia;
   public $ciudad;
   public $descr_profesional;
   public $sueldo_deseado;
   public $area_desempeno;
   public $posicion_interes;
   public $industria_interes;
   public $habilidades;
   public $exp_profesional;
   public $formacion_educativa;
   public $disc_lenguaje;
   public $disc_motriz;
   public $disc_visual;
   public $disc_mental;
   public $disc_auditiva;
   public $lugar_atencion;
   public $curriculum;
   public $file;
   public $file64;
   public $nombre_completo;
   public $correo;

   public function __construct(Solicitante $obj)
   {

      $this->id_solicitante = $obj->id;
      $this->id_usuario = $obj->id_usuario;
      $this->edad = $obj->edad;
      $this->curp = $obj->curp;
      $this->telefono = $obj->telefono;
      $this->c_numero = $obj->c_numero;
      $this->c_postal = $obj->c_postal;
      $this->id_colonia = $obj->id_colonia;
      $this->ciudad = $obj->ciudad;
      $this->descr_profesional = $obj->descr_profesional;
      $this->sueldo_deseado = $obj->sueldo_deseado;
      $this->area_desempeno = $obj->area_desempeno;
      $this->posicion_interes = $obj->posicion_interes;
      $this->industria_interes = $obj->industria_interes;
      $this->habilidades = $obj->habilidades;
      $this->exp_profesional = $obj->exp_profesional;
      $this->formacion_educativa = $obj->formacion_educativa;
      $this->disc_lenguaje = $obj->disc_lenguaje;
      $this->disc_motriz = $obj->disc_motriz;
      $this->disc_visual = $obj->disc_visual;
      $this->disc_mental = $obj->disc_mental;
      $this->disc_auditiva = $obj->disc_auditiva;
      $this->lugar_atencion = $obj->lugar_atencion;
      $this->curriculum = $obj->curriculum;
      $this->file = $obj->file;
      $this->file64 = $obj->file64;

      if(isset($obj->rel_usuarios)){
         $this->nombre_completo = $obj->rel_usuarios->nombre_completo;
         $this->correo = $obj->rel_usuarios->correo;
      }
   
   }
}
