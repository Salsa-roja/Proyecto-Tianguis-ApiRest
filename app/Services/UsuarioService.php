<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\DTO\ParseDTO;
use App\DTO\UsuarioListDTO;
use App\DTO\UsuarioEmpresaListDTO;
use App\Models\Usuarios;
use App\Models\UsuariosEmpresas;
use App\Models\Rol;
use App\Models\SocketQueque;

abstract class UsuarioService
{

   public static function listado($auth){
      try {

         if($auth->rol == Config('constants.ROL_ADMIN')){         
            $usuariosdb = Usuarios::with(['rol','usuario_empresa','usuario_solicitante','rel_usuario_solicitante_vacante'])->where('activo',true)->get();
            $usuarios = ParseDTO::list($usuariosdb, UsuarioListDTO::class);
         }else{
            $usuariosdb = UsuariosEmpresas::where('id_empresa', $auth->id_empresa)
                                          ->whereHas('rel_usuarios', function ($query) {
                                             $query->where('activo', true);
                                          })
                                          ->get();

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
         if(isset($params['request']->auth))
            if($params['request']->auth->rol==Config('constants.ROL_EMPRESA'))
               return UsuarioService::guardarUsuarioEmpresa($params);
         $itemUs = new Usuarios();
         $itemUs->nombres = $params['nombres'];
         $itemUs->ape_paterno = $params['ape_paterno'];
         $itemUs->ape_materno = $params['ape_materno'];
         $itemUs->correo = $params['correo'];
         $itemUs->nombre_login = trim( strtolower($params['nombre_login'] ) );
         $itemUs->contrasena = password_hash($params['contrasena'], PASSWORD_BCRYPT);

         $itemUs->rol_id = Rol::where('nombre', Config('constants.ROL_ADMIN'))->first()->id;
         $itemUs->save();

         return $itemUs;
      } catch (\Exception $e) {
         throw new \Exception($e->getMessage());
      }
   }

   public static function guardarUsuarioEmpresa($params){
      try {
         $itemUs = new Usuarios();
         $itemUs->nombres = trim($params['nombres']);
         $itemUs->ape_paterno = trim($params['ape_paterno']);
         $itemUs->ape_materno = trim($params['ape_materno']);
         $itemUs->correo = trim($params['correo']);
         $itemUs->nombre_login = trim( strtolower($params['nombre_login'] ) );
         $itemUs->contrasena = password_hash($params['contrasena'], PASSWORD_BCRYPT);

         $itemUs->rol_id = Rol::where('nombre', Config('constants.ROL_EMPRESA'))->first()->id;
         $itemUs->save();
         # guardar relacion
         $UsrEmp = new UsuariosEmpresas();
         $UsrEmp->id_usuario = $itemUs->id;
         $UsrEmp->id_empresa = isset($params['request']->auth) ? $params['request']->auth->id_empresa : $params['empresa_id'];
         $UsrEmp->save();

         return $itemUs;
      } catch (\Exception $e) {
         throw new \Exception($e->getMessage());
      }
   }

   public static function guardarUsuarioSolicitante($params){
      try {
         $itemUs = new Usuarios();
         $itemUs->nombres = trim($params['nombres']);
         $itemUs->ape_paterno = trim($params['ape_paterno']);
         $itemUs->ape_materno = trim($params['ape_materno']);
         $itemUs->correo = trim($params['correo']);
         $itemUs->nombre_login = trim( strtolower($params['nombre_login'] ) );
         $itemUs->contrasena = password_hash($params['contrasena'], PASSWORD_BCRYPT);
         $itemUs->rol_id = Rol::where('nombre', Config('constants.ROL_SOLICITANTE'))->first()->id;
         $itemUs->save();

         return $itemUs;
      } catch (\Exception $e) {
         throw new \Exception($e->getMessage());
      }
   }

   public static function editar($params){
      try {

         $Usuario = UsuarioService::searchById($params['id'],false);
         $Usuario->nombres = trim($params['nombres']);
         $Usuario->ape_paterno = trim($params['ape_paterno']);
         $Usuario->ape_materno = trim($params['ape_materno']);
         $Usuario->correo = trim($params['correo']);
         $Usuario->nombre_login = trim( strtolower($params['nombre_login']) );
         $Usuario->save();

         return $Usuario;
      } catch (\Exception $e) {
         throw new \Exception($e->getMessage());
      }
   }

   public static function existeByUsername($nombre_login,$idUsuario=null){
      try {
         //si se proporciona un id de usuario, se buscara un registro que coincida con $nombre_login pero que tenga un id de usuario diferente
         $query = Usuarios::where('nombre_login', '=', trim(strtolower($nombre_login)));
         if (!is_null($idUsuario)) {
            $query->where('id', '<>', $idUsuario);
         }
         return $query->exists();
         /* $where=['nombre_login'=>trim( strtolower($nombre_login) ) ];
         if(!is_null($idUsuario)) $where['id <>']=$idUsuario;
         return Usuarios::where($where)->exists(); */
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
   public static function inhabilitar($id)
   {
       try {
           if ($id > 0) {
               $usuario = Usuarios::where('id', $id)->first();
               if ($usuario) {
                   $usuario->activo = 0;
                   $usuario->save();
               }
           } else {
               $usuario = [];
           }
           return $usuario;
       } catch (\Exception $ex) {
           return response()->json(['mensaje' => 'Hubo un error al eliminar el usuario', $ex->getMessage()], 400);
       }
   }
}