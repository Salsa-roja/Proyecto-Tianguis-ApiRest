<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Models\Usuarios;
use App\Models\Empresa;
use App\Models\Vacantes;
use App\Models\VacanteSolicitante;



abstract class ReportesService
{

   public static function generales(){
      try {

         return [
            [
               'label' => "Ciudadanos Registrados",
               'value' => self::total_solicitantes()
            ],
            [
               'label' => "Empresas Registradas",
               'value' => Empresa::where('activo',true)->count()
            ],
            [
               'label' => "Vacantes Activas",
               'value' => Vacantes::where('activo',true)->count()
            ],
            [
               'label' => "Postulaciones Totales",
               'value' => VacanteSolicitante::where([ 'activo'=>true, 'talent_hunting'=>false ])->count()
            ],
            [
               'label' => "Contrataciones Totales",
               'value' => self::contrataciones_totales()
            ],
         ];
         
      } catch (\Throwable $th) {
         return response()->json(['mensaje' => 'Hubo un error al obtener estadisticas generales', $th->getMessage()], 400);
      }
   }

   private static function total_solicitantes(){
      return Usuarios::where('activo', true)
                     ->whereHas('rol', function ($query) {
                        $query->where('nombre', Config('constants.ROL_SOLICITANTE'));
                     })->count();
   }

   private static function contrataciones_totales(){
      return VacanteSolicitante::where('activo',true)
                                 ->whereHas('tabla_estatus', function ($query){
                                    $query->where('estatus', Config('constants.ESTATUS_POSTULACION_ACEPTADO'));
                                 })->count();
   }



}
