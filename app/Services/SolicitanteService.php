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
    public static function searchById($id,$dto=true){
      try {
         $item = Solicitante::with(['rel_usuarios','rel_vacante_solicitante.rel_vacantes.empresa','rel_vacante_solicitante.tabla_estatus'])->find($id);
         if($dto){
            $itemDTO = ParseDTO::obj($item, SolicitanteDTO::class);
            return $itemDTO;
         }else{
            return $item;
         }
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

   public static function existeByCurp($curp){
      try {
         return Solicitante::where('curp',$curp)->exists();
      } catch (\Exception $e) {
         throw new \Exception($e->getMessage());
      }
   }

   public static function guardar($params,$fieldArchivo){
      try {

         # guardar usuario
         $paramsUs=[
            'nombres' => $params['nombres'],
            'ape_paterno' => $params['ape_paterno'],
            'ape_materno' => $params['ape_materno'],
            'correo' => $params['correo'],
            'nombre_login' => $params['nombre_login'],
            'contrasena' => $params['contrasena'],
            'rol_id' => Rol::where('nombre', 'Solicitante')->first()->id,
            'request' => $params['request']
         ];
         
         $itemUs=UsuarioService::guardarUsuarioSolicitante($paramsUs);

         # guardar solicitante
         $Solicitante = new Solicitante();
         $Solicitante->id_usuario = $itemUs->id; 
         $Solicitante->edad = $params['edad'];
         $Solicitante->curp = $params['curp'];
         $Solicitante->telefono = $params['telefono'];
         $Solicitante->c_numero = $params['c_numero'];
         $Solicitante->c_postal = $params['c_postal'];
         $Solicitante->id_colonia = $params['id_colonia'];
         $Solicitante->ciudad = $params['ciudad'];
         $Solicitante->descr_profesional = $params['descr_profesional'];
         $Solicitante->sueldo_deseado = $params['sueldo_deseado'];
         $Solicitante->area_desempeno = $params['area_desempeno'];
         $Solicitante->posicion_interes = $params['posicion_interes'];
         $Solicitante->industria_interes = $params['industria_interes'];
         $Solicitante->habilidades = $params['habilidades'];
         $Solicitante->exp_profesional = $params['exp_profesional'];
         $Solicitante->formacion_educativa = $params['formacion_educativa'];
         $Solicitante->disc_lenguaje = $params['disc_lenguaje'];
         $Solicitante->disc_motriz = $params['disc_motriz'];
         $Solicitante->disc_visual = $params['disc_visual'];
         $Solicitante->disc_mental = $params['disc_mental'];
         $Solicitante->disc_auditiva = $params['disc_auditiva'];
         $Solicitante->lugar_atencion = $params['lugar_atencion'];
         $Solicitante->curriculum = $fieldArchivo;
         $Solicitante->save();

         return $Solicitante;
      } catch (\Exception $e) {
         throw new \Exception($e->getMessage());
      }
   }

   public static function editar($params){
      try {

         # obtener info de solicitante
         $Solicitante = SolicitanteService::searchById($params['id'],false);

         # editar usuario
         $paramsUs=[
            'nombres' => $params['nombres'],
            'ape_paterno' => $params['ape_paterno'],
            'ape_materno' => $params['ape_materno'],
            'correo' => $params['correo'],
            'nombre_login' => $params['nombre_login']
         ];
         $itemUs=UsuarioService::editar($Solicitante->id_usuario,$paramsUs);
         
         # editar solicitante
         $Solicitante->id_usuario = $itemUs->id; 
         $Solicitante->edad = $params['edad'];
         $Solicitante->curp = $params['curp'];
         $Solicitante->telefono = $params['telefono'];
         $Solicitante->c_numero = $params['c_numero'];
         $Solicitante->c_postal = $params['c_postal'];
         $Solicitante->id_colonia = $params['id_colonia'];
         $Solicitante->ciudad = $params['ciudad'];
         $Solicitante->descr_profesional = $params['descr_profesional'];
         $Solicitante->sueldo_deseado = $params['sueldo_deseado'];
         $Solicitante->area_desempeno = $params['area_desempeno'];
         $Solicitante->posicion_interes = $params['posicion_interes'];
         $Solicitante->industria_interes = $params['industria_interes'];
         $Solicitante->habilidades = $params['habilidades'];
         $Solicitante->exp_profesional = $params['exp_profesional'];
         $Solicitante->formacion_educativa = $params['formacion_educativa'];
         $Solicitante->disc_lenguaje = $params['disc_lenguaje'];
         $Solicitante->disc_motriz = $params['disc_motriz'];
         $Solicitante->disc_visual = $params['disc_visual'];
         $Solicitante->disc_mental = $params['disc_mental'];
         $Solicitante->disc_auditiva = $params['disc_auditiva'];
         $Solicitante->lugar_atencion = $params['lugar_atencion'];
         $Solicitante->save();

         return $Solicitante;
      } catch (\Exception $e) {
         throw new \Exception($e->getMessage());
      }
   }

   public static function guardarCv($params,$fieldArchivo){
      try {

         # guardar nuevo curriculum
         $itemDB = $params['solicitante'];
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