<?php

namespace App\Services;

use App\Models\Turnos_laborales;
use App\Models\Nivel_educativo;
use App\Dto\ParseDto;
use App\Dto\TurnosListDto;
use App\Dto\NivelEduListDto;


abstract class TurnosTitulosService
{
    public static function getTurnos()
    {
        try {
            $turnosdb = Turnos_laborales::all();
            $turnos = ParseDto::list($turnosdb, TurnosListDto::class);
            return $turnos;
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage(), 500);
        }
    }

    public static function getTitulos()
    {
        try {
            $niveEduldb = Nivel_educativo::all();
            $nivelEdu = ParseDto::list($niveEduldb, NivelEduListDto::class);
            return $nivelEdu;
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage(), 500);
        }
    }
}
