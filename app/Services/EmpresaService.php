<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Empresa;
use App\Models\Usuarios;
use App\Models\UsuariosEmpresas;
use App\Models\Rol;
abstract class EmpresaService
{

   public static function listado(){
      try {
         return Empresa::with(['usuario_empresa'])->where('activo', '1')->get();
      } catch (\Exception $e) {
         throw new \Exception($e->getMessage());
      }
   }

   public static function guardar($params,$fieldsArchivo){
      try {

         # guardar usuario
         $Usuario = new Usuarios();
         $Usuario->nombres = $params['nombre_rh'];
         $Usuario->ape_paterno = '';
         $Usuario->ape_materno = '';
         $Usuario->correo = $params['correo_rh'];
         $Usuario->contrasena = password_hash($params['contrasena'], PASSWORD_BCRYPT);
         $Usuario->rol_id = Rol::where('nombre', 'Empresa')->first()->id;
         $Usuario->save();

         # guardar empresa
         $Empresa = new Empresa();
         $Empresa->nombre_comercial = $params['nombre_comercial'];
         $Empresa->razon_social = $params['razon_social'];
         $Empresa->rfc = $params['rfc'];
         $Empresa->descripcion = $params['descripcion'];
         $Empresa->numero_empleados = $params['numero_empleados'];

         $Empresa->constancia_sit_fiscal = $fieldsArchivo['constancia_sit_fiscal'];
         $Empresa->licencia_municipal = $fieldsArchivo['licencia_municipal'];
         $Empresa->alta_patronal = $fieldsArchivo['alta_patronal'];
         
         $Empresa->contr_discapacitados = $params['contr_discapacitados'];
         $Empresa->contr_antecedentes = $params['contr_antecedentes'];
         $Empresa->contr_adultos = $params['contr_adultos'];
         
         $Empresa->nombre_rh = $params['nombre_rh'];
         $Empresa->correo_rh = $params['correo_rh'];
         $Empresa->telefono_rh = $params['telefono_rh'];
         $Empresa->save();

         # guardar relacion
         $UsrEmp = new UsuariosEmpresas();
         $UsrEmp->id_usuario = $Usuario->id;
         $UsrEmp->id_empresa = $Empresa->id;
         $UsrEmp->save();

         return [$Usuario,$Empresa];
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