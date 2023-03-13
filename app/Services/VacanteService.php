<?php

namespace App\Services;

use App\Models\Vacantes;
use App\Dto\ParseDTO;
use App\Dto\SolicitudDto;
use App\Dto\VacantesListDTO;
use App\Dto\EstatusPostulacionDto;
use App\Models\Estatus_postulacion;
use App\Models\VacanteSolicitante;
use App\Models\UsuariosEmpresas;
use App\Models\Empresa;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;



abstract class VacanteService
{
    public static function getVacantes($id_empresa = null)
    {
        try {
            $query = Vacantes::with(['empresa', 'tabla_turnos_laborales', 'tabla_nivel_educativo']);
            if ($id_empresa != null) {
                $query = $query->where('id_empresa', $id_empresa);
            }
            $vacantedb = $query->where('activo', '1')->get();

            $vacantes = ParseDTO::list($vacantedb, VacantesListDTO::class);
            return $vacantes;
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage(), 500);
        }
    }

    public static function searchId($params)
    {
        try {
            $vacantedb = Vacantes::with(['empresa', 'tabla_turnos_laborales', 'tabla_nivel_educativo']);

            if (isset($params['request']->auth->id) && SolicitanteService::searchByIdUser($params['request']->auth->id)) {
                $idSolicitante = SolicitanteService::searchByIdUser($params['request']->auth->id)->id;
                $vacantedb =  $vacantedb->addSelect(['vinculado' => VacanteSolicitante::select('id')
                    ->where('id_solicitante', $idSolicitante)
                    ->whereColumn('vacantes.id', 'id_vacante')])
                    ->where('id', $params['request']->idVacante);
            }
            $vacantedb = $vacantedb->where(['activo' => true])->find($params['request']->idVacante);
            if ($vacantedb) {
                $vacante = ParseDto::obj($vacantedb, VacantesListDTO::class);
            } else {
                $vacante = null;
            }
            return $vacante;
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage(), 500);
        }
    }

    public static function searchName($name)
    {
        try {
            if ($name != '') {
                $vacantedb = Vacantes::with(['empresa', 'tabla_turnos_laborales', 'tabla_nivel_educativo'])
                    ->whereRaw("REPLACE(UPPER(vacante),' ','') like ?", str_replace(' ', '', strtoupper('%' . $name . '%')))->where('activo', '1')->get();
                $vacante = ParseDto::list($vacantedb, VacantesListDTO::class);
                return $vacante;
            }
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage(), 500);
        }
    }

    public static function vacanteMasLejana($request)
    {
        try {
            $vacantedb = Vacantes::selectRaw("ST_Distance(
            ST_Transform( CONCAT('SRID=4326;POINT(" . $request['lng'] . " " . $request['lat'] . " )')::geometry, 2163),
            ST_Transform( CONCAT('SRID=4326;POINT(' , lng, ' ',lat ,')')::geometry, 2163)) as lejano")
                ->where(['activo' => true])
                ->orderByDesc('lejano')
                ->first();
            return $vacantedb;
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage(), 500);
        }
    }

    public static function filtro($request, $params)
    {
        try {
            $vacantedb = Vacantes::with(['empresa', 'tabla_turnos_laborales', 'tabla_nivel_educativo']);

            if ($request['lat'] != 'null' && $request['lng'] != 'null' && $request['distancia'] != 0) {

                $vacantedb = $vacantedb->whereRaw(" 
                ST_Distance(
                ST_Transform( CONCAT('SRID=4326;POINT(" . $request['lng'] . " " . $request['lat'] . " )')::geometry, 2163),
                ST_Transform( CONCAT('SRID=4326;POINT(' , lng, ' ',lat ,')')::geometry, 2163)) < " . $request['distancia'] . "*1000");
            }
            if (isset($params['request']->auth->id) && SolicitanteService::searchByIdUser($params['request']->auth->id)) {
                $idSolicitante = SolicitanteService::searchByIdUser($params['request']->auth->id)->id;
                $vacantedb =  $vacantedb->addSelect(['vinculado' => VacanteSolicitante::select('id')
                    ->where('id_solicitante', $idSolicitante)
                    ->whereColumn('vacantes.id', 'id_vacante')]);
            }
            if ($request['idTurno'] != 'null') {
                $vacantedb = $vacantedb->where('id_turnos_laborales', $request['idTurno']);
            }
            if ($request['idTitulo'] != 'null') {
                $vacantedb = $vacantedb->where('id_nivel_educativo', $request['idTitulo']);
            }
            if ($request['Search'] != 'null') {
                $vacantedb = $vacantedb->whereRaw("REPLACE(UPPER(vacante),' ','') like ?", str_replace(' ', '', strtoupper('%' . $request['Search'] . '%')));
            }
            $vacantedb = $vacantedb->where('activo', '1')->get();
            if ($vacantedb) {
                $vacante = ParseDto::list($vacantedb, VacantesListDTO::class);
            } else {
                $vacante = null;
            }
            return $vacante;
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage(), 500);
        }
    }

    private static function getAddress($address)
    {
        $latLng = explode(',', $address);
        if (count($latLng) == 2) {
            $lat = $latLng[0];
            $lng = $latLng[1];
            if (is_numeric($lat) && is_numeric($lng))
                return ['lat' => $lat, 'lng' => $lng, 'domicilio' => null];
        }
        return ['lat' => null, 'lng' => null, 'domicilio' => $address];
    }

    public static function inhabilitar($id)
    {
        try {
            if ($id > 0) {
                $vacante = Vacantes::where('id', $id)->first();
                if ($vacante) {
                    $vacante->activo = 0;
                    $vacante->save();
                }
            } else {
                $vacante = [];
            }
            return $vacante;
        } catch (\Exception $ex) {
            return response()->json(['mensaje' => 'Hubo un error al eliminar el vacante', $ex->getMessage()], 400);
        }
    }

    /** 
     * Obtener solicitudes por vacante
     */
    public static function getSolicitudesVacante($idVacante)
    {
        try {
            #obtiene lista de relVacanteSolicitante con relacion solicitantes.usuarios y vacantes
            $solicitudes = VacanteSolicitante::with(['rel_solicitante.rel_usuarios'])->where('id_vacante', $idVacante)->get();
            $solicitudesDTO = ParseDTO::list($solicitudes, SolicitudDto::class);

            /* $solicitudes = Solicitante::with(['rel_usuarios','rel_vacante_solicitante'=>function($query) use ($idVacante){
                $query->where('id_vacante',$idVacante);
            }])->get(); */
            //$sql='SELECT * from "relVacanteSolicitante" where "relVacanteSolicitante"."id_solicitante" in (1, 2) and "id_vacantee" = 4';
            return $solicitudesDTO;
        } catch (\Exception $ex) {
            return response()->json(['mensaje' => 'Hubo un error al obtener las solicitudes', $ex->getMessage()], 400);
        }
    } //...getSolicitudesVacante

    public static function updateEstatusSolisitud(array $params)
    {
        try {
            $solicitudes = VacanteSolicitante::find($params['idVacante']);
            $solicitudes->id_estatus = $params['idEstatus'];
            $solicitudes->save();
            return $solicitudes;
        } catch (\Exception $ex) {
            return response()->json(['mensaje' => 'Hubo un error al obtener las solicitudes', $ex->getMessage()], 400);
        }
    }
    /** 
     * Vincular vacante con solicitante
     */
    public static function vincular($params)
    {
        try {
            // return $params;
            #datos del solicitante
            $solicitante = SolicitanteService::searchByIdUser($params['request']->auth->id);

            #buscar vacante
            $vacante = VacanteService::searchId($params);
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
                    $rel->id_estatus = Estatus_postulacion::where('estatus', Config('constants.ESTATUS_VACANTE_NO_VISTO'))->first()->id;
                    $rel->save();

                    #Enviar correo al solicitante
                    $data = array(
                        'remitente' => null,
                        'destinatario' => $params['request']->auth->id,
                        'asunto' => '¡Recibimos tu solicitud!',
                        'cuerpo' => "Tu solicitud para la vacante '$vacante->vacante' se ha procesado correctamente",
                        'titulo' => ''
                    );
                    CorreosService::guardarYEnviar($data);
                }
            } else {
                throw new \Exception('No existe la vacante');
            }
            return $rel;
        } catch (\Exception $ex) {
            return response()->json(['mensaje' => 'Hubo un error al vincular con la vacante', $ex->getMessage()], 400);
        }
    } //...vincular

    /**
     * Buscar vinculacion previa 
     */
    public static function yaVinculado($id_vacante, $id_solicitante)
    {
        try {
            $exists = DB::table('relVacanteSolicitante')->where(['id_vacante' => $id_vacante, 'id_solicitante' => $id_solicitante])->first();
            return isset($exists->id);
        } catch (\Exception $ex) {
            return response()->json(['mensaje' => 'Hubo un error al buscar la vinculacion', $ex->getMessage()], 400);
        }
    }

    public static function guardar(array $request, $params)
    {
        try {
            $datos = [
                'vacante' => $request['vacante'],
                'descripcion' => $request['descripcion'],
                'categorías_especiales' => $request['categorías_especiales'],
                'dias_laborales' => $request['dias_laborales'],
                'id_turnos_laborales' => $request['turnos_laborales'],
                'id_nivel_educativo' => $request['nivel_educativo'],
                'sueldo' => $request['sueldo'],
                'calle' => $request['calle'],
                'colonia' => $request['colonia'],
                'código_postal' => $request['código_postal'],
                'ciudad' => $request['ciudad'],
                'numero_de_puestos_disponibles' => $request['numero_de_puestos_disponibles'],
                'area' => $request['area'],
                'industria' => $request['industria'],
                'tipo_de_puesto' => $request['tipo_de_puesto'],
                'habilidades_requeridas' => $request['habilidades_requeridas'],
                'lat' => $request['lat'],
                'lng' => $request['lng']
            ];
            if ($request['id'] > 0) {
                $datos = $datos + [
                    'id' => $request['id'], 'id_empresa' => $request['id_empresa']
                ];
                $Vacantes = Vacantes::where('id', $request['id'])->first();
                if ($Vacantes) {
                    $Vacantes->update($datos);
                    $Vacantes->save();
                }
            } else {
                $id_empresa = UsuariosEmpresas::where('id_usuario', $params['request']->auth->id)->first()->id_empresa;
                $datos = $datos + ['id_empresa' => $id_empresa];
                $Vacantes = Vacantes::create($datos);
                $Vacantes->save();
            }
            return response()->json($Vacantes, Response::HTTP_CREATED);
        } catch (\Exception $ex) {
            return response()->json(['mensaje' => 'Hubo un error al registrar el usuario', $ex->getMessage()], 400);
        }
    }

    public static function desactivarEmpresas($id)
    {
        $empresaSoliId = Empresa::find($id);
        $alertas = $empresaSoliId->No_de_alertas;
        $empresaSoliId->No_de_alertas = $alertas + 1;
        if ($empresaSoliId->No_de_alertas <= 10) {
            $empresaSoliId->activo = 0;
        }
        $empresaSoliId->save();
    }

    public static function NotificacionCorreo($id_empresa, $solicitudVacante, $solicitudNombre_completo, $solicitudId_empresa, $solicitudEstatus)
    {
        if ($solicitudEstatus == 'visto') {
            $data = array(
                'remitente' => null,
                'destinatario' => $id_empresa,
                'asunto' => '¡Actualiza tus postulaciones !',
                'cuerpo' => "Tienes una postulacion con estatus ''" . $solicitudEstatus . "'' sin actualizar desde hace 3 dias en la vacante " . $solicitudVacante . " en la que se ha postulado el solicitante " . $solicitudNombre_completo,
                'titulo' => ''
            );
        } else {
            $data = array(
                'remitente' => null,
                'destinatario' => $id_empresa,
                'asunto' => '¡Actualiza tus postulaciones !',
                'cuerpo' => "Tienes una postulacion con estatus ''" . $solicitudEstatus . "'' sin actualizar desde hace mas de 7 dias en la vacante " . $solicitudVacante . " en la que se ha postulado el solicitante " . $solicitudNombre_completo,
                'titulo' => ''
            );
        }
        CorreosService::guardarYEnviar($data);
    }

    public static function test()
    {
        try {
            $ESTATUS_VACANTE_VISTO = Config('constants.MY_CONSTANT');
            $ESTATUS_VACANTE_EN_PROCESO = Config('constants.ESTATUS_VACANTE_EN_PROCESO');

            return    VacanteSolicitante::with(['rel_vacantes.empresa'])->all();
         
            
            $vacanteSoli = VacanteSolicitante::all();
            $Dia_de_hoy = Carbon::now();
            $solicitudesDTO = ParseDTO::list($vacanteSoli, SolicitudDto::class);

            foreach ($solicitudesDTO as $solicitud) {
                if ($solicitud->Fecha_actualizacion != null) {
                    $dias_diferencia_a_hoy = $Dia_de_hoy->diffInDays($solicitud->Fecha_actualizacion);
                    if ($dias_diferencia_a_hoy >= 3  && $solicitud->estatus == $ESTATUS_VACANTE_VISTO) {
                        VacanteService::desactivarEmpresas($solicitud->id_empresa);
                        foreach ($solicitud->id_Usuario_de_Empresa as $id_empresa) {
                            VacanteService::NotificacionCorreo($id_empresa, $solicitud->vacante, $solicitud->nombre_completo, $solicitud->id_empresa, $solicitud->estatus);
                        }
                    }
                    if ($dias_diferencia_a_hoy >= 7 && $solicitud->estatus == $ESTATUS_VACANTE_EN_PROCESO) {
                        VacanteService::desactivarEmpresas($solicitud->id_empresa);
                        foreach ($solicitud->id_Usuario_de_Empresa as $id_empresa) {
                            VacanteService::NotificacionCorreo($id_empresa, $solicitud->vacante, $solicitud->nombre_completo, $solicitud->id_empresa, $solicitud->estatus);
                        }
                    }
                }
            }
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage(), 500);
        }
    }

    public static function getEstatusPostulacion()
    {
        try {
            $niveEduldb = Estatus_postulacion::all();
            $nivelEdu = ParseDTO::list($niveEduldb, EstatusPostulacionDto::class);
            return $nivelEdu;
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage(), 500);
        }
    }
}
