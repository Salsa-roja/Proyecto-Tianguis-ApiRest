<?php

namespace App\Dto;

use App\Models\VacanteSolicitante;

class SolicitudDTO
{
   public $id;
   public $id_Usuario_de_Empresa= [];
   public $id_solicitante;
   public $id_vacante;
   public $id_usuario;
   public $id_empresa;
   public $vacante;
   public $alertas_en_empresa;
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
   public $status_solicitud;
   public $fecha_solicitud;
   public $nombre_completo_solicitante;
   public $correo;
   public $file;
   public $file64;
   public $id_estatus;
   public $estatus;
   public $Fecha_actualizacion;



   public function __construct(VacanteSolicitante $obj)
   {
      $this->id = $obj->id;
      $this->id_solicitante = $obj->id_solicitante;
      $this->id_vacante = $obj->id_vacante;
      $this->vacante = $obj->rel_vacantes->vacante;
      $this->id_empresa = $obj->rel_vacantes->empresa->id;
      $this->alertas_en_empresa = $obj->rel_vacantes->empresa->No_de_alertas;
      $this->status_solicitud = $obj->activo;
      $this->fecha_solicitud = $obj->created_at;
      $this->Fecha_actualizacion = $obj->updated_at;
      foreach ($obj->rel_vacantes->empresa->usuario_empresa as $usuarioEmpresa) {
         array_push($this->id_Usuario_de_Empresa, $usuarioEmpresa->id_usuario);
      }

      if (isset($obj->rel_solicitante)) {
         $this->id_estatus = $obj->tabla_estatus->id;
         $this->estatus = $obj->tabla_estatus->estatus;
         $this->id_usuario = $obj->rel_solicitante->id_usuario;
         $this->edad = $obj->rel_solicitante->edad;
         $this->curp = $obj->rel_solicitante->curp;
         $this->telefono = $obj->rel_solicitante->telefono;
         $this->c_numero = $obj->rel_solicitante->c_numero;
         $this->c_postal = $obj->rel_solicitante->c_postal;
         $this->id_colonia = $obj->rel_solicitante->id_colonia;
         $this->ciudad = $obj->rel_solicitante->ciudad;
         $this->descr_profesional = $obj->rel_solicitante->descr_profesional;
         $this->sueldo_deseado = $obj->rel_solicitante->sueldo_deseado;
         $this->area_desempeno = $obj->rel_solicitante->area_desempeno;
         $this->posicion_interes = $obj->rel_solicitante->posicion_interes;
         $this->industria_interes = $obj->rel_solicitante->industria_interes;
         $this->habilidades = $obj->rel_solicitante->habilidades;
         $this->exp_profesional = $obj->rel_solicitante->exp_profesional;
         $this->formacion_educativa = $obj->rel_solicitante->formacion_educativa;
         $this->disc_lenguaje = $obj->rel_solicitante->disc_lenguaje;
         $this->disc_motriz = $obj->rel_solicitante->disc_motriz;
         $this->disc_visual = $obj->rel_solicitante->disc_visual;
         $this->disc_mental = $obj->rel_solicitante->disc_mental;
         $this->disc_auditiva = $obj->rel_solicitante->disc_auditiva;
         $this->lugar_atencion = $obj->rel_solicitante->lugar_atencion;
         $this->curriculum = $obj->rel_solicitante->curriculum;
         $this->file = $obj->rel_solicitante->file;
         $this->file64 = $obj->rel_solicitante->file64;



         if (isset($obj->rel_solicitante->rel_usuarios)) {
            $this->nombre_completo_solicitante = $obj->rel_solicitante->rel_usuarios->nombre_completo;
            $this->correo = $obj->rel_solicitante->rel_usuarios->correo;
         }
      }
   }
}
