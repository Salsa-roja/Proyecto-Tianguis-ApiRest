<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Empresa;
use App\Models\Usuarios;
use App\Models\UsuariosEmpresas;
use App\Models\Rol;
use App\Dto\ParseDTO;
use App\Dto\EmpresaDTO;

abstract class EmpresaService
{

   public static function listado(){
      try {
         $empresasList =Empresa::where('activo', '1')->get();
         $itemDTO = ParseDTO::list($empresasList, EmpresaDto::class);
         return $itemDTO;
      } catch (\Exception $e) {
         throw new \Exception($e->getMessage());
      }
   }

   /**
    * Buscar empresa por id
    *
    * @param id number - id de la empresa
    * @param dto boolean - aplicar o no el dto
    **/
    public static function searchById($id,$dto=true){
      try {
         $item = Empresa::with(['usuario_empresa'])->find($id);
         if($dto){
            $itemDTO = ParseDTO::obj($item, EmpresaDTO::class);
            return $itemDTO;
         }else{
            return $item;
         }
      } catch (\Exception $e) {
         throw new \Exception($e->getMessage());
      }
   }

   public static function guardar($params,$fieldsArchivo){
      try {

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

         # guardar usuario
         $paramsUs=[
            'nombres' => $params['nombre_rh'],
            'ape_paterno' => '',
            'ape_materno' => '',
            'correo' => $params['correo_rh'],
            'nombre_login' => $params['nombre_login'],
            'contrasena' => $params['contrasena'],
            'rol_id' => Rol::where('nombre', 'Empresa')->first()->id,
            'request' => $params['request'],
            'empresa_id'=>$Empresa->id
         ];
         $Usuario=UsuarioService::guardarUsuarioEmpresa($paramsUs);
         
         return [$Usuario,$Empresa];
      } catch (\Exception $e) {
         throw new \Exception($e->getMessage());
      }
   }

   public static function editar($params){
      try {

         #obtener info de la empresa
         $Empresa = EmpresaService::searchById($params['id'],false);

         # guardar empresa
         $Empresa->nombre_comercial = $params['nombre_comercial'];
         $Empresa->razon_social = $params['razon_social'];
         $Empresa->rfc = $params['rfc'];
         $Empresa->descripcion = $params['descripcion']; 
         $Empresa->numero_empleados = $params['numero_empleados'];
         $Empresa->contr_discapacitados = $params['contr_discapacitados'];
         $Empresa->contr_antecedentes = $params['contr_antecedentes'];
         $Empresa->contr_adultos = $params['contr_adultos'];
         $Empresa->nombre_rh = $params['nombre_rh'];
         $Empresa->correo_rh = $params['correo_rh'];
         $Empresa->telefono_rh = $params['telefono_rh'];
         $Empresa->save();

         return $Empresa;
      } catch (\Exception $e) {
         throw new \Exception($e->getMessage());
      }
   }

   public static function guardarDocto($params,$fieldArchivo){
      try {
         $campo = $params['inputName'];

         # guardar nuevo archivo
         $itemDB = $params['empresa'];
         $itemDB->$campo = $fieldArchivo;
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

   public static function existeByRFC($rfc){
      try {
         return Empresa::where('rfc',$rfc)->exists();
      } catch (\Exception $e) {
         throw new \Exception($e->getMessage());
      }
   }
   
}