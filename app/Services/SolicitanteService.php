<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Solicitante;
use App\Models\Usuarios;
use App\Models\Rol;
use App\Dto\ParseDTO;
use App\Dto\SolicitanteDto;


abstract class SolicitanteService
{

   public static function listado(){
      try {
         return "listado solicitante";
      } catch (\Exception $e) {
         throw new \Exception($e->getMessage());
      }
   }

   /**
    * Buscar solicitante por id
    **/
    public static function searchById($id){
      try {
         $itemDB = Solicitante::with(['rel_usuarios'])->find($id);
         $itemDTO = ParseDTO::obj($itemDB, SolicitanteDTO::class);
         
         return $itemDTO;
      } catch (\Exception $e) {
         throw new \Exception($e->getMessage());
      }
   }

   /**
    * Buscar solicitante por id usuario
    **/
   public static function searchByIdUser($id){
      try {
         $itemDB = Solicitante::where('id_usuario', $id)->first();
         
         return $itemDB;
      } catch (\Exception $e) {
         throw new \Exception($e->getMessage());
      }
   }

   public static function guardar($params,$fieldArchivo){
      try {

         # guardar usuario
         $itemUs = new Usuarios();
         $itemUs->nombres = $params['nombre'];
         $itemUs->ape_paterno = $params['ape_paterno'];
         $itemUs->ape_materno = $params['ape_materno'];
         $itemUs->correo = $params['correo'];
         $itemUs->contrasena = password_hash($params['contrasena'], PASSWORD_BCRYPT);
         $itemUs->rol_id = Rol::where('nombre', 'Solicitante')->first()->id;
         $itemUs->save();

         # guardar solicitante
         $itemDB = new Solicitante();
         $itemDB->id_usuario = $itemUs->id; 
         $itemDB->edad = $params['edad'];
         $itemDB->curp = $params['curp'];
         $itemDB->telefono = $params['telefono'];
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
    * Lista colonias 
    * */
   public static function getColonias($cpostal){
      try {
         return DB::table('cat_c_postal_colonias')->select(['id','asentamiento_nombre','ciudad'])->where('cp',$cpostal)->get();
      } catch (\Exception $e) {
         throw new \Exception($e->getMessage());
      }
   }

}