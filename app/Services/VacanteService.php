<?php

namespace App\Services;

use App\Models\Vacantes;
use App\Dto\ParseDTO;
use App\Dto\VacantesListDTO;
use App\Dto\VacantesDBListDTO;
use App\Models\Usuarios;
use App\Models\VacanteSolicitante;
use App\Models\Solicitante;

use Faker\Core\Number;
use Hamcrest\Type\IsNumeric;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;
use Mockery\Undefined;

abstract class VacanteService
{
    public static function getVacantes($id_empresa=null)
    {
        try {
            $query = Vacantes::with(['empresa', 'tabla_turnos_laborales', 'tabla_nivel_educativo']);
            if(!is_null($id_empresa)){
                $query = $query->where('id_empresa',$id_empresa); 
            }
            $vacantedb = $query->where('activo', '1')->get();

            $vacante = ParseDTO::list($vacantedb, VacantesListDTO::class);
            return $vacante;
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage(), 500);
        }
    }

    public static function searchId($id)
    {
        try {
            $vacantedb = Vacantes::with(['empresa', 'tabla_turnos_laborales', 'tabla_nivel_educativo'])->where('id', $id)->where('activo', '1')->first();
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
    public static function filtro($request)
    {
        try {
            $vacantedb = Vacantes::with(['empresa', 'tabla_turnos_laborales', 'tabla_nivel_educativo']);
                
            if ($request['lat'] != 'null' && $request['lng'] != 'null' && $request['distancia']!=0) {
                $vacantedb = $vacantedb->whereRaw(" 
                ST_Distance(
                ST_Transform( CONCAT('SRID=4326;POINT(" . $request['lng'] . " " . $request['lat'] . " )')::geometry, 2163),
                ST_Transform( CONCAT('SRID=4326;POINT(' , lng, ' ',lat ,')')::geometry, 2163)) < " . $request['distancia'] . "*1000");
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
                    $vacante->activo=0;
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
    public static function getSolicitudesVacante($idVacante){
        try {
            #obtiene lista de relVacanteSolicitante con relacion solicitantes.usuarios y vacantes
            //$solicitudes = VacanteSolicitante::with(['rel_vacantes','rel_solicitantes.rel_usuarios'])->where('id_vacante',$idVacante)->get();
            #obtiene solo solicitantes
            $solicitudes = Solicitante::with(['rel_vacante_solicitante'=>function($query) use ($idVacante){
                                                    $query->where('id_vacante',$idVacante);
                                                }])
                                        ->with('rel_usuarios')->get();

            return $solicitudes;
        } catch (\Exception $ex) {
            return response()->json(['mensaje' => 'Hubo un error al obtener las solicitudes', $ex->getMessage()], 400);
        }
    }//...getSolicitudesVacante

    /** 
     * Vincular vacante con solicitante
    */
    public static function vincular($params){
        try {

            #datos del solicitante
            $solicitante = SolicitanteService::searchByIdUser($params['request']->auth->id);

            #buscar vacante
            $vacante = VacanteService::searchId($params['id_vacante']);
            if(isset($vacante->id)){            
                #buscar vinculacion previa
                $yaVinculado = VacanteService::yaVinculado($vacante->id,$solicitante->id);

                if($yaVinculado){
                    throw new \Exception('Ya vinculado!');
                }else{
                    #guardar vinculacion
                    $rel = new VacanteSolicitante();
                    $rel->id_vacante = $vacante->id;
                    $rel->id_solicitante = $solicitante->id;
                    $rel->save();

                    #Enviar correo al solicitante
                    $data=array(
                        'remitente'=>null,
                        'destinatario'=>$params['request']->auth->id,
                        'asunto'=>'¡Recibimos tu solicitud!',
                        'cuerpo'=>"Tu solicitud para la vacante '$vacante->vacante' se ha procesado correctamente",
                        'titulo'=>'');
                    CorreosService::guardarYEnviar($data);
                }
            }else{
                throw new \Exception('No existe la vacante');
            }
            return [$yaVinculado,$vacante,$solicitante];
        } catch (\Exception $ex) {
            return response()->json(['mensaje' => 'Hubo un error al vincular con la vacante', $ex->getMessage()], 400);
        }        
    }//...vincular

    /**
     * Buscar vinculacion previa 
    */
    public static function yaVinculado($id_vacante,$id_solicitante){
        try {
            $exists = DB::table('relVacanteSolicitante')->where(['id_vacante'=>$id_vacante,'id_solicitante'=>$id_solicitante])->first();
            return isset($exists->id);
        } catch (\Exception $ex) {
            return response()->json(['mensaje' => 'Hubo un error al buscar la vinculacion', $ex->getMessage()], 400);
        }     
    }
}
