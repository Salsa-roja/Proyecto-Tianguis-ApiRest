<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Solicitante;

abstract class SolicitanteService
{

   public static function listado(){
      try {
         return "listado solicitante";
      } catch (\Exception $e) {
         throw new \Exception($e->getMessage());
      }
   }

   public static function guardar($params,$fieldArchivo){
      try {

         $itemDB = new Solicitante();
         $itemDB->nombre = $params['nombre'];
         $itemDB->ap_paterno = $params['ap_paterno'];
         $itemDB->ap_materno = $params['ap_materno'];
         $itemDB->edad = $params['edad'];
         $itemDB->curp = $params['curp'];
         $itemDB->telefono = $params['telefono'];
         $itemDB->email = $params['email'];
         $itemDB->pass = password_hash($params['pass'], PASSWORD_BCRYPT);
         $itemDB->c_numero = $params['c_numero'];
         $itemDB->c_postal = $params['c_postal'];
         $itemDB->id_colonia = $params['id_colonia'];
         $itemDB->ciudad = $params['ciudad'];
         $itemDB->descr_profesional = $params['descr_profesional'];
         $itemDB->sueldo_deseado = $params['sueldo_deseado'];
         $itemDB->area_desempeno = $params['area_desempeno'];
         $itemDB->posicion_interes = $params['posicion_interes'];
         $itemDB->industria_interes = $params['industria_interes'];
         $itemDB->habilidades = $params['habilidades'];
         $itemDB->exp_profesional = $params['exp_profesional'];
         $itemDB->formacion_educativa = $params['formacion_educativa'];
         $itemDB->disc_lenguaje = $params['disc_lenguaje'];
         $itemDB->disc_motriz = $params['disc_motriz'];
         $itemDB->disc_visual = $params['disc_visual'];
         $itemDB->disc_mental = $params['disc_mental'];
         $itemDB->disc_auditiva = $params['disc_auditiva'];
         $itemDB->lugar_atencion = $params['lugar_atencion'];
         $itemDB->curriculum = $fieldArchivo;
         $itemDB->save();
         return $itemDB;
      } catch (\Exception $e) {
         throw new \Exception($e->getMessage());
      }
   }
   /**
    * Lista codigos postales  
    * */
      public static function getCPs(){
         try {
            return DB::table('cat_c_postal_colonias')->select(['cp'])->distinct(["cp"])->orderBy('cp')->get();
         } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
         }
      }

   /**
    * Lista codigos postales  
    * */
   public static function getColonias($cpostal){
      try {
         return DB::table('cat_c_postal_colonias')->select(['id','asentamiento_nombre','ciudad'])->where('cp',$cpostal)->get();
      } catch (\Exception $e) {
         throw new \Exception($e->getMessage());
      }
   }
}