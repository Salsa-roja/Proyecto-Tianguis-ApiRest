<?php

namespace App\Services;

use App\Models\Turnos_laborales;
use App\Models\Nivel_educativo;
use App\Dto\ParseDTO;
use App\Dto\TurnosListDTO;
use App\Dto\NivelEduListDto;


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
            $nivelEdu = ParseDTO::list($niveEduldb, NivelEduListDto::class);
            return $nivelEdu;
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage(), 500);
        }
    }
}
