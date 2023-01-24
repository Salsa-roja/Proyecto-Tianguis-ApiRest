<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Dto\ParseDTO;
use App\Dto\UsuarioListDTO;
use App\Models\Usuarios;
use App\Models\Rol;
abstract class UsuarioService
{

   public static function listado(){
      try {

         $usuariosdb = Usuarios::with(['rol','usuario_empresa','usuario_solicitante','rel_usuario_solicitante_vacante'])->get();
         $usuarios = ParseDTO::list($usuariosdb, UsuarioListDTO::class);
         return $usuarios;
      } catch (\Exception $e) {
         throw new \Exception($e->getMessage());
      }
   }

   public static function guardar($params){
      try {

         /* # guardar usuario
         $Usuario = new Usuarios();
         $Usuario->nombres = $params['nombre_rh'];
         $Usuario->ape_paterno = '';
         $Usuario->ape_materno = '';
         $Usuario->correo = $params['correo_rh'];
         $Usuario->contrasena = password_hash($params['contrasena'], PASSWORD_BCRYPT);
         $Usuario->rol_id = Rol::where('nombre', 'Usuario')->first()->id;
         $Usuario->save();

         # guardar empresa
         $Usuario = new Usuarios();
         $Usuario->nombre_comercial = $params['nombre_comercial'];
         $Usuario->razon_social = $params['razon_social'];
         $Usuario->rfc = $params['rfc'];
         $Usuario->descripcion = $params['descripcion'];
         $Usuario->numero_empleados = $params['numero_empleados'];

         $Usuario->constancia_sit_fiscal = $fieldsArchivo['constancia_sit_fiscal'];
         $Usuario->licencia_municipal = $fieldsArchivo['licencia_municipal'];
         $Usuario->alta_patronal = $fieldsArchivo['alta_patronal'];
         
         $Usuario->contr_discapacitados = $params['contr_discapacitados'];
         $Usuario->contr_antecedentes = $params['contr_antecedentes'];
         $Usuario->contr_adultos = $params['contr_adultos'];
         
         $Usuario->nombre_rh = $params['nombre_rh'];
         $Usuario->correo_rh = $params['correo_rh'];
         $Usuario->telefono_rh = $params['telefono_rh'];
         $Usuario->save();

         # guardar relacion
         $UsrEmp = new UsuariosUsuarios();
         $UsrEmp->id_usuario = $Usuario->id;
         $UsrEmp->id_empresa = $Usuario->id;
         $UsrEmp->save(); 

         return [$Usuario,$Usuario];*/
         return true;
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