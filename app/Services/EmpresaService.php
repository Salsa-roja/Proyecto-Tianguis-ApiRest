<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Empresa;

abstract class EmpresaService
{

   public static function listado(){
      try {
         return "listado empresa";
      } catch (\Exception $e) {
         throw new \Exception($e->getMessage());
      }
   }

   public static function guardar($params,$fieldsArchivo){
      try {

         $itemDB = new Empresa();
         $itemDB->nombre_comercial = $params['nombre_comercial'];
         $itemDB->razon_social = $params['razon_social'];
         $itemDB->rfc = $params['rfc'];
         $itemDB->descripcion = $params['descripcion'];
         $itemDB->numero_empleados = $params['numero_empleados'];

         $itemDB->constancia_sit_fiscal = $fieldsArchivo['constancia_sit_fiscal'];
         $itemDB->licencia_municipal = $fieldsArchivo['licencia_municipal'];
         $itemDB->alta_patronal = $fieldsArchivo['alta_patronal'];
         
         $itemDB->contr_discapacitados = $params['contr_discapacitados'];
         $itemDB->contr_antecedentes = $params['contr_antecedentes'];
         $itemDB->contr_adultos = $params['contr_adultos'];
         
         $itemDB->nombre_rh = $params['nombre_rh'];
         $itemDB->correo_rh = $params['correo_rh'];
         $itemDB->telefono_rh = $params['telefono_rh'];
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