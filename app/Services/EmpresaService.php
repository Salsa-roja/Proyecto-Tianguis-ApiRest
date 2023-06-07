<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Models\Empresa;
use App\Models\VacanteSolicitante;
use App\Models\Estatus_postulacion;
use App\Dto\SolicitanteDTO;
use App\Models\Rol;
use App\Dto\ParseDTO;
use App\Dto\EmpresaDTO;
use App\Models\Estatus_empresa;
use App\Models\Solicitante;
use App\Models\Vacantes;
use App\Models\UsuariosEmpresas;

abstract class EmpresaService
{

   public static function listado()
   {
      try {
         $empresasList = Empresa::where('activo', '1')->get();
         $itemDTO = ParseDTO::list($empresasList, EmpresaDTO::class);
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
   public static function searchById($id, $dto = true)
   {
      try {
         $item = Empresa::with(['usuario_empresa'])->find($id);
         if ($dto) {
            $itemDTO = ParseDTO::obj($item, EmpresaDTO::class);
            return $itemDTO;
         } else {
            return $item;
         }
      } catch (\Exception $e) {
         throw new \Exception($e->getMessage());
      }
   }

   public static function guardar($params, $fieldsArchivo)
   {
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
         $Empresa->d_estatus = Estatus_empresa::where('estatus', Config('constants.ESTATUS_EMPRESA_EN_REVICION'))->first()->id;
         $Empresa->save();

         # guardar usuario
         $paramsUs = [
            'nombres' => $params['nombre_rh'],
            'ape_paterno' => '',
            'ape_materno' => '',
            'correo' => $params['correo_rh'],
            'nombre_login' => $params['nombre_login'],
            'contrasena' => $params['contrasena'],
            'rol_id' => Rol::where('nombre', Config('constants.ROL_EMPRESA'))->first()->id,
            'request' => $params['request'],
            'empresa_id' => $Empresa->id
         ];
         $Usuario = UsuarioService::guardarUsuarioEmpresa($paramsUs);

         return [$Usuario, $Empresa];
      } catch (\Exception $e) {
         throw new \Exception($e->getMessage());
      }
   }

   public static function editar($params)
   {
      try {

         #obtener info de la empresa
         $Empresa = EmpresaService::searchById($params['id'], false);

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

   public static function guardarDocto($params, $fieldArchivo)
   {
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
   public static function getCPs()
   {
      try {
         return DB::table('cat_c_postal_colonias')->select(['cp'])->distinct(["cp"])->orderBy('cp')->get();
      } catch (\Exception $e) {
         throw new \Exception($e->getMessage());
      }
   }

   /**
    * Lista codigos postales  
    * */
   public static function getColonias($cpostal)
   {
      try {
         return DB::table('cat_c_postal_colonias')->select(['id', 'asentamiento_nombre', 'ciudad'])->where('cp', $cpostal)->get();
      } catch (\Exception $e) {
         throw new \Exception($e->getMessage());
      }
   }

   public static function existeByRFC($rfc)
   {
      try {
         return Empresa::where('rfc', $rfc)->exists();
      } catch (\Exception $e) {
         throw new \Exception($e->getMessage());
      }
   }
   public static function getEstatusEmpresas()
   {
      try {
         $item = Estatus_empresa::where('activo', '1')->get();

         return $item;
      } catch (\Exception $e) {
         throw new \Exception($e->getMessage());
      }
   }
   public static function updateEstatusEmpresa(array $params)
   {
      try {
         $solicitudes = Empresa::find($params['id']);
         $solicitudes->id_estatus = $params['idEstatus'];
         $solicitudes->save();
         return $solicitudes;
      } catch (\Exception $ex) {
         return response()->json(['mensaje' => 'Hubo un error al obtener las solicitudes', $ex->getMessage()], 400);
      }
   }
   public static function filtroDeBusquedaSolicitantes($request, $params)
   {
      try {

         $idVacante = $request['idVacante'];
         $solicitantes = Solicitante::select('solicitantes.*')
            ->with(['rel_vacante_solicitante' => function ($query) use ($idVacante) {
               $query->where('id_vacante', $idVacante);
            }])
            ->when($request['idTitulo'] != 'null', function ($query) use ($request) {
               return $query->where('id_nivel_educativo', $request['idTitulo']);
            })
            ->when($request['Search'] != 'null', function ($query) use ($request) {
               return $query->whereRaw("REPLACE(UPPER(formacion_educativa),' ','') like ?", str_replace(' ', '', strtoupper('%' . $request['Search'] . '%')));
            })
            ->get()
            ->map(function ($solicitante) {
               $solicitante->vinculado = $solicitante->rel_vacante_solicitante->isNotEmpty();
               return $solicitante;
            });
         // $vacantedb = $solicitantes;

         // return $vacantedb;
         if ($solicitantes) {
            $vacante = ParseDTO::list($solicitantes, SolicitanteDTO::class);
         } else {
            $vacante = null;
         }
         return $vacante;
      } catch (\Exception $ex) {
         throw new \Exception($ex->getMessage(), 500);
      }
   }

   public static function vincular($params)
   {
      try {
         // return $params;['nombre_comercial']with('rel_empresas')->
         #datos del solicitante
  
         $solicitante = Solicitante::find($params['idUsuario']);

         #buscar vacante
         $vacante = Vacantes::find($params['idVacante']);
         if (isset($vacante->id)) {
            #buscar vinculacion previa
            $yaVinculado = VacanteService::yaVinculado($vacante->id, $solicitante->id);

            if ($yaVinculado) {
               throw new \Exception('Ya vinculado!');
            } else {
               #guardar vinculacion
               $rel = new VacanteSolicitante();
               $rel->id_vacante = $vacante->id;
               $rel->id_solicitante = $solicitante->id;
               $rel->talent_hunting=1;
               $rel->id_estatus = Estatus_postulacion::where('estatus', Config('constants.ESTATUS_POSTULACION_NO_VISTO'))->first()->id;
               $rel->save();

               $asunto = '¡Una empresa se ha interesado en ti!';
               $cuerpo = "Una empresa te ha seleccionado para la vacante '$vacante->vacante' contacta con ellos para darle seguimiento ";
               VacanteService::NotificacionCorreo($params['request']->auth->id, $asunto, $cuerpo);
               return $rel;
            }
         } else {
            throw new \Exception('No existe la vacante');
         }
      } catch (\Exception $ex) {
         return response()->json(['mensaje' => 'Hubo un error al vincular con la vacante', $ex->getMessage()], 400);
      }
   } //...vincular

}
