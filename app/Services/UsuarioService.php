<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Dto\ParseDTO;
use App\Dto\UsuarioListDTO;
use App\Dto\UsuarioEmpresaListDTO;
use App\Models\Usuarios;
use App\Models\UsuariosEmpresas;
use App\Models\Rol;
abstract class UsuarioService
{

   public static function listado($auth){
      try {

         if($auth->rol == 'Administrador'){         
            $usuariosdb = Usuarios::with(['rol','usuario_empresa','usuario_solicitante','rel_usuario_solicitante_vacante'])->get();
            $usuarios = ParseDTO::list($usuariosdb, UsuarioListDTO::class);
         }else{
            $usuariosdb = UsuariosEmpresas::with(['rel_usuarios'])->where('id_empresa',$auth->id_empresa)->get();
            $usuarios = ParseDTO::list($usuariosdb, UsuarioEmpresaListDTO::class);
            //$usuarios = UsuariosEmpresas::with(['rel_usuarios'])->where('id_empresa',$auth->id_empresa)->get();

         }
         return $usuarios;
      } catch (\Exception $e) {
         throw new \Exception($e->getMessage());
      }
   }

   /**
    * Buscar usuario por id
    **/
    public static function searchById($id,$dto=true){
      try {
         $item = Usuarios::with('usuario_empresa')->find($id);
         if($dto){
            $itemDTO = ParseDTO::obj($item, UsuarioListDTO::class);
            return $itemDTO;
         }else{
            return $item;
         }
      } catch (\Exception $e) {
         throw new \Exception($e->getMessage());
      }
   }

   public static function guardar($params){
      try {
         $itemUs = new Usuarios();
         $itemUs->nombres = $params['nombres'];
         $itemUs->ape_paterno = $params['ape_paterno'];
         $itemUs->ape_materno = $params['ape_materno'];
         $itemUs->correo = $params['correo'];
         $itemUs->nombre_login = $params['nombre_login'];
         $itemUs->contrasena = password_hash($params['contrasena'], PASSWORD_BCRYPT);

         switch ($params['request']->auth->rol) {
            case 'Administrador':
                  $itemUs->rol_id = Rol::where('nombre', 'Administrador')->first()->id;
                  $itemUs->save();
               break;
            case 'Empresa':
                  $itemUs->rol_id = Rol::where('nombre', 'Empresa')->first()->id;
                  $itemUs->save();
                  # guardar relacion
                  $UsrEmp = new UsuariosEmpresas();
                  $UsrEmp->id_usuario = $itemUs->id;
                  $UsrEmp->id_empresa = $params['request']->auth->id_empresa;
                  $UsrEmp->save();
               break;
            case 'Solicitante':
                  return false;
               break;
            default:
                  $itemUs->rol_id = $params['rol_id'];
                  $itemUs->save();
               break;
         }

         return $itemUs;
      } catch (\Exception $e) {
         throw new \Exception($e->getMessage());
      }
   }

   public static function editar($params){
      try {

         $Usuario = UsuarioService::searchById($params['id'],false);
         $Usuario->nombres = $params['nombres'];
         $Usuario->ape_paterno = $params['ape_paterno'];
         $Usuario->ape_materno = $params['ape_materno'];
         $Usuario->correo = $params['correo'];
         $Usuario->nombre_login = $params['nombre_login'];
         $Usuario->save();

         return $Usuario;
      } catch (\Exception $e) {
         throw new \Exception($e->getMessage());
      }
   }

   public static function existeByUsername($nombre_login){
      try {
         return Usuarios::where('nombre_login',$nombre_login)->exists();
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