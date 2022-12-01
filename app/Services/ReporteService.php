<?php

namespace App\Services;

use App\Models\Vacantes;
use App\Dto\ParseDTO;
use App\Dto\VacantesListDTO;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;

abstract class VacanteService
{
    public static function getvacante()
    {
        try {
            $vacantedb = Vacantes::with('contestaciones.pregunta')->where('activo', '1')->get();
            $vacante = ParseDTO::list($vacantedb, VacantesListDTO::class);
            return $vacante;
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage(), 500);
        }
    }

    public static function searchId($id)
    {
        try {
            $vacantedb = Vacantes::where('id', $id)->first();
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
