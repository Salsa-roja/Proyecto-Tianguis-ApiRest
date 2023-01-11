<?php

namespace App\Services;

use App\Models\Vacantes;
use App\Dto\ParseDTO;
use App\Dto\VacantesListDTO;
use App\Dto\VacantesDBListDTO;
use Faker\Core\Number;
use Hamcrest\Type\IsNumeric;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;
use Mockery\Undefined;

abstract class VacanteService
{
    public static function getvacante()
    {
        try {
            $vacantedb = Vacantes::with(['empresa','tabla_turnos_laborales','tabla_nivel_educativo'])->where('activo', '1')->get();
            $vacante = ParseDTO::list($vacantedb, VacantesListDTO::class);
            return $vacante;
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage(), 500);
        }
    }

    public static function searchId($id)
    {
        try {
            $vacantedb = Vacantes::with(['empresa','tabla_turnos_laborales','tabla_nivel_educativo'])->where('id', $id)->where('activo', '1')->first();
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
                $vacantedb = Vacantes::with(['empresa','tabla_turnos_laborales','tabla_nivel_educativo'])
                ->whereRaw("REPLACE(UPPER(titulo),' ','') like ?",str_replace(' ', '', strtoupper('%' . $name . '%')))->where('activo', '1')->get();
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
            $vacantedb = Vacantes::with(['empresa','tabla_turnos_laborales','tabla_nivel_educativo']);

            if ($request['lat'] != 'null') {
                // $vacantedb = Vacantes::selectRaw("
                // vacante.id,
                // vacante.vacante,
                // vacante.descripcion,
                // empleador.nombre,
                // vacante.descripcion,
                // vacante.categorías_especiales,
                // vacante.días_laborales,
                // turnos_laborales.turnos,
                // nivel_educativo.titulo,
                // vacante.sueldo,
                // vacante.direccion,
                // vacante.colonia,
                // vacante.código_postal,
                // vacante.ciudad,
                // vacante.número_de_puestos_disponibles,
                // vacante.area,
                // vacante.industria,
                // vacante.tipo_de_puesto,
                // vacante.habilidades_requeridas,
                // vacante.lng,
                // vacante.lat,
                // ST_Distance(
                //     ST_Transform( CONCAT('SRID=4326;POINT(" . $request['lng'] . " " . $request['lat'] . " )')::geometry, 2163),
                //     ST_Transform( CONCAT('SRID=4326;POINT(' ,vacante.lng,' ',vacante.lat,')')::geometry, 2163)
                //     ) AS metros")->where("ST_Distance(
                //         ST_Transform( CONCAT('SRID=4326;POINT(" . $request['lng'] . " " . $request['lat'] . " )')::geometry, 2163),
                //         ST_Transform( CONCAT('SRID=4326;POINT(' ,vacante.lng,' ',vacante.lat,')')::geometry, 2163)
                //     )",'=', '0')
                //     ->join('turnos_laborales', 'vacante.id_turnos_laborales', '=', 'turnos_laborales.id')
                //     ->join('empleador', 'vacante.empleador_id', '=', 'empleador.id')
                //     ->join('nivel_educativo', 'vacante.id_nivel_educativo', '=', 'nivel_educativo.id');
 
 
                $query = DB::select("SELECT ST_Distance(
                   ST_Transform( CONCAT('SRID=4326;POINT(" . $request['lng'] . " " . $request['lat'] . " )')::geometry, 2163),
                    ST_Transform( CONCAT('SRID=4326;POINT(' ,vacante.lng,' ',vacante.lat,')')::geometry, 2163)
                                        ) AS metros
                    FROM vacante
                    WHERE 
                        ST_Distance(
                        ST_Transform( CONCAT('SRID=4326;POINT(" . $request['lng'] . " " . $request['lat'] . " )')::geometry, 2163),
                        ST_Transform( CONCAT('SRID=4326;POINT(' , lng, ' ',lat ,')')::geometry, 2163)) < 7354.593396524609
                        ORDER BY metros
                        LIMIT 10");


                return ($query);
            } else {
                $vacantedb = Vacantes::with(['empresa', 'tabla_turnos_laborales', 'tabla_nivel_educativo']);
            }
            if ($request['idTurno'] != 'null') {
                $vacantedb = $vacantedb->where('id_turnos_laborales', $request['idTurno']);
            }
            if ($request['idTitulo'] != 'null') {
                $vacantedb = $vacantedb->where('id_nivel_educativo', $request['idTitulo']);
            }
            if ($request['Search'] != 'null') {
                $vacantedb = $vacantedb->whereRaw("REPLACE(UPPER(titulo),' ','') like ?", str_replace(' ', '', strtoupper('%' . $request['Search'] . '%')));
            }

            $vacantedb = $vacantedb->where('activo', '1')->get();

            if ($vacantedb) {
                if ($request['lat'] != 'null') {
                    $vacante = ParseDto::list($vacantedb, VacantesDBListDTO::class);
                } else {
                    $vacante = ParseDto::list($vacantedb, VacantesListDTO::class);
                }
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
                    DB::table('vacantes')->where('id', $id)->update(['activo' => '0']);
                }
            } else {
                $vacante = [];
            }
            return response()->json($vacante, Response::HTTP_CREATED);
        } catch (\Exception $ex) {
            return response()->json(['mensaje' => 'Hubo un error al eliminar el vacante', $ex->getMessage()], 400);
        }
    }
}
