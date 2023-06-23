<?php

namespace App\Services;

use App\Models\Vacantes;
use App\DTO\ParseDTO;
use App\DTO\SolicitudDTO;
use App\DTO\VacantesListDTO;
use App\DTO\EstatusPostulacionDTO;
use App\Models\Estatus_postulacion;
use App\Models\VacanteSolicitante;
use App\Models\UsuariosEmpresas;
use App\Models\Empresa;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;
use Carbon\Carbon;
use App\Models\Usuarios;
use App\Services\SocketService;

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
                $vacante = ParseDTO::obj($vacantedb, VacantesListDTO::class);
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
                $vacante = ParseDTO::list($vacantedb, VacantesListDTO::class);
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
                $vacante = ParseDTO::list($vacantedb, VacantesListDTO::class);
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
            $solicitudesDTO = ParseDTO::list($solicitudes, SolicitudDTO::class);

            /* $solicitudes = Solicitante::with(['rel_usuarios','rel_vacante_solicitante'=>function($query) use ($idVacante){
                $query->where('id_vacante',$idVacante);
            }])->get(); */
            //$sql='SELECT * from "relVacanteSolicitante" where "relVacanteSolicitante"."id_solicitante" in (1, 2) and "id_vacantee" = 4';
            return $solicitudesDTO;
        } catch (\Exception $ex) {
            return response()->json(['mensaje' => 'Hubo un error al obtener las solicitudes', $ex->getMessage()], 400);
        }
    } //...getSolicitudesVacante

    public static function updateEstatusSolicitud(array $params)
    {
        try {
            $solicitudes = VacanteSolicitante::find($params['idVacanteSolicitante']);
            $solicitudes->id_estatus = $params['idEstatus'];

            $solicitudesDTO = ParseDTO::obj($solicitudes, SolicitudDTO::class);
            $asunto = '¡Tu potulacion se ha actualizado!';
            if ($solicitudes->talent_hunting == true) {
                $cuerpo = "Tu ofrecimiento de la vacante " . $solicitudesDTO->vacante . " se ha actualizado y se encuentra en el estatus de " . '"' . $solicitudesDTO->estatus . '"' . " del postulado llamado " . $solicitudesDTO->nombre_completo_solicitante;
                VacanteService::NotificacionCorreo($solicitudesDTO->id_Usuario_de_Empresa[0], $asunto, $cuerpo);
            } else {
                $cuerpo = "Tu solicitud para la vacante de " . $solicitudesDTO->vacante . " se ha actualizado y se encuentra en el estatus de " . '"' . $solicitudesDTO->estatus . '"';
                VacanteService::NotificacionCorreo($solicitudesDTO->id_usuario, $asunto, $cuerpo);
            }
            if ($params['idEstatus'] != 2) {
                $solicitudes->talent_hunting = false;
            }

            $solicitudes->save();
            return $solicitudesDTO;
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
            // return 'hola';

            $id_usuario = $params['request']->auth->id;
            #datos del solicitante
            $solicitante = SolicitanteService::searchByIdUser($id_usuario);

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
                    $rel->talent_hunting = 0;
                    $rel->id_estatus = Estatus_postulacion::where('estatus', Config('constants.ESTATUS_POSTULACION_NO_VISTO'))->first()->id;
                    $rel->save();

                    $asunto = '¡Recibimos tu solicitud!';
                    $cuerpo = "Tu solicitud para la vacante '$vacante->vacante' se ha procesado correctamente";
                    VacanteService::NotificacionCorreo($id_usuario, $asunto, $cuerpo);

                    # Almacenar nueva notificacion en la cola del socket y enviarla
                    $Ssv = new SocketService($params['request']->auth, 'notify_client');
                    if ($Ssv) {
                        $Ssv->addToQueque([
                            'id_usuario' => $id_usuario,
                            'sala' => "user_$id_usuario",
                            'titulo' => '¡Postulación enviada!',
                            'descripcion' => $cuerpo
                        ])
                            ->emitQueque()
                            ->close();
                    }
                    return $rel;
                }
            } else {
                throw new \Exception('No existe la vacante');
            }
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
                // 'lat' => $request['lat'],
                // 'lng' => $request['lng']
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
            return response()->json(['mensaje' => 'Hubo un error al registrar la vacante', $ex->getMessage()], 400);
        }
    }

    public static function desactivarEmpresas($id)
    {
        $empresaSoliId = Empresa::find($id);
        $alertas = $empresaSoliId->no_de_alertas;
        $empresaSoliId->no_de_alertas = $alertas + 1;
        if ($empresaSoliId->no_de_alertas === 10) {
            $empresaSoliId->id_estatus = 2;
        }
        $empresaSoliId->save();
    }

    public static function NotificacionCorreo($id_usuario, $asunto, $cuerpo)
    {
        #obtener datos del usuario
        $usuario = Usuarios::find($id_usuario);

        #Enviar correo al usuario
        $data = array(
            'from_mail' => null,
            'from_name' => null,
            'to_mail' => $usuario->correo,
            'to_name' => $usuario->nombres . ' ' . $usuario->ape_paterno,
            'asunto' => $asunto,
            'cuerpo' => $cuerpo,
            'titulo' => 'Atención!'
        );

        CorreosService::guardarYEnviar($data);
    }

    public static function NotificacionEstatusVacantesDesactualizado()
    {
        try {
            $ESTATUS_POSTULACION_VISTO = Config('constants.ESTATUS_POSTULACION_VISTO');
            $ESTATUS_POSTULACION_EN_PROCESO = Config('constants.ESTATUS_POSTULACION_EN_PROCESO');
            $vacanteSoli = VacanteSolicitante::all();
            $Dia_de_hoy = Carbon::now();
            $solicitudesDTO = ParseDTO::list($vacanteSoli, SolicitudDTO::class);

            $user = Usuarios::with('rol', 'rol.permisos')->whereHas('rol', function ($query) {
                $query->where('nombre', Config('constants.ROL_ADMIN'));
            })->first();

            $payload = new \stdClass;
            $payload->id = $user->id;
            $payload->nombre = $user->nombre_completo;
            $payload->correo = $user->correo;
            $payload->rol = $user->rol->nombre;
            $payload->rol_id = $user->rol_id;
            $payload->permisos = $user->rol->permisos->map(function ($rolePermission) {
                return $rolePermission->permiso;
            });
            $payload->id_empresa = !is_null($user->usuario_empresa) ? $user->usuario_empresa->rel_empresas['id'] : null;
            $payload->id_solicitante = !is_null($user->usuario_solicitante) ? $user->usuario_solicitante['id'] : null;
            $payload->iat = time();
            $payload->exp = time() + 1440 * 5000;;
            $Ssv = new SocketService($payload, 'notify_client');
            foreach ($solicitudesDTO as $solicitud) {
                if ($solicitud->Fecha_actualizacion != null) {
                    $dias_diferencia_a_hoy = $Dia_de_hoy->diffInDays($solicitud->Fecha_actualizacion);
                    if (($dias_diferencia_a_hoy >= 3  && $solicitud->estatus == $ESTATUS_POSTULACION_VISTO) ||
                        ($dias_diferencia_a_hoy >= 7 && $solicitud->estatus == $ESTATUS_POSTULACION_EN_PROCESO)
                    ) {
                        VacanteService::desactivarEmpresas($solicitud->id_empresa);
                        foreach ($solicitud->id_Usuario_de_Empresa as $id_usuario) {
                            $asunto = '¡Actualiza tus postulaciones!';
                            $cuerpo = "Tienes una postulacion con estatus ''" .  $solicitud->estatus . "'' sin actualizar desde hace mas de " . $dias_diferencia_a_hoy . " dias en la vacante " . $solicitud->vacante . " en la que se ha postulado el solicitante " . $solicitud->nombre_completo_solicitante .". Si llegas a 10 alertas tu cuenta sera desactivada  ";
                            VacanteService::NotificacionCorreo($id_usuario, $asunto, $cuerpo);
                            $Ssv->addToQueque([
                                'id_usuario' => $id_usuario,
                                'sala' => "user_$id_usuario",
                                'titulo' => $asunto,
                                'descripcion' => $cuerpo
                            ]);
                        }
                    }
                }
            }
            $Ssv->emitQueque()->close();
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage(), 500);
        }
    }


    public static function getEstatusPostulacion()
    {
        try {
            $niveEduldb = Estatus_postulacion::all();
            $nivelEdu = ParseDTO::list($niveEduldb, EstatusPostulacionDTO::class);
            return $nivelEdu;
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage(), 500);
        }
    }
}
