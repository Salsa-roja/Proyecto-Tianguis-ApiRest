<?php

namespace App\Services;

use App\Models\Turnos_laborales;
use App\Models\Nivel_educativo;
use App\DTO\ParseDTO;
use App\DTO\TurnosListDTO;
use App\DTO\NivelEduListDTO;


abstract class TurnosTitulosService
{
    public static function getTurnos()
    {
        try {
            $turnosdb = Turnos_laborales::all();
            $turnos = ParseDTO::list($turnosdb, TurnosListDTO::class);
            return $turnos;
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage(), 500);
        }
    }

    public static function getTitulos()
    {
        try {
            $niveEduldb = Nivel_educativo::all();
            $nivelEdu = ParseDTO::list($niveEduldb, NivelEduListDTO::class);
            return $nivelEdu;
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage(), 500);
        }
    }
}
