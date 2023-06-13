<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Models\Usuarios;
use App\Models\Empresa;
use App\Models\Vacantes;
use App\Models\VacanteSolicitante;



abstract class ReportesService
{

   
   public static function grafica_conversion(){
      try {
         $psc = self::postulados_sin_contratar();
         $pc = self::contrataciones_totales();

         return [
            'descripcion' => "La taza de conversión actual es de ".($pc*100)/$psc."%, equivalente a $pc contrataciones de un total de $psc postulados.",
            'datos' => [
               [
                  'label' => 'Postulados sin contratar',
                  'value' => $psc
               ],
               [
                  'label' => 'Postulados contratados',
                  'value' => $pc
               ]   
            ]
         ];
      } catch (\Throwable $th) {
         throw new \Throwable($th->getMessage());
      }
   }

   /**
   * Obtiene estadísticas varias de la plataforma.
   *
   * Este método calcula varias métricas de la plataforma y las devuelve en un array con las estadísticas. 
   * Cada estadística es un array asociativo con dos campos:
   * - 'label': una descripción de la métrica
   * - 'value': el valor de la métrica
   *
   * Las métricas que se calculan actualmente son:
   * - Ciudadanos Registrados
   * - Empresas Registradas
   * - Vacantes Activas
   * - Postulaciones Totales
   * - Contrataciones Totales
   *
   * @return array[] Las métricas de la plataforma, formateadas como se describe arriba.
   */
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
               'value' => self::vacantes_activas()
            ],
            [
               'label' => "Postulaciones Totales",
               'value' => self::postulaciones_totales()
            ],
            [
               'label' => "Contrataciones Totales",
               'value' => self::contrataciones_totales()
            ],
         ];
         
      } catch (\Throwable $th) {
         throw new \Throwable($th->getMessage());
      }
   }

   private static function total_solicitantes(){
      return Usuarios::where('activo', true)
                     ->whereHas('rol', function ($query) {
                        $query->where('nombre', Config('constants.ROL_SOLICITANTE'));
                     })->count();
   }

   private static function postulaciones_totales(){
      return VacanteSolicitante::where([ 'activo'=>true ])->count();//,'talent_hunting'=>false
   }

   private static function contrataciones_totales(){
      return VacanteSolicitante::where('activo',true)
                                 ->whereHas('tabla_estatus', function ($query){
                                    $query->where('estatus', Config('constants.ESTATUS_POSTULACION_ACEPTADO'));
                                 })->count();
   }

   private static function vacantes_activas(){
      return Vacantes::where('activo',true)->count();
   }

   private static function postulados_sin_contratar(){
      return VacanteSolicitante::where('activo',true)
                                 ->whereHas('tabla_estatus', function ($query){
                                    $query->where('estatus','<>', Config('constants.ESTATUS_POSTULACION_ACEPTADO'));
                                 })->count();
   }

}
