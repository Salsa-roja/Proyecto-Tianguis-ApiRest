<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Estatus_postulacion extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        DB::table('estatus_postulacion')->insert([
            [
                'estatus' =>  Config('constants.ESTATUS_VACANTE_NO_VISTO')
            ],
            [
                'estatus' =>  Config('constants.ESTATUS_VACANTE_VISTO')
            ],
            [
                'estatus' =>  Config('constants.ESTATUS_VACANTE_EN_PROCESO')
            ],
            [
                'estatus' => Config('constants.ESTATUS_VACANTE_ACEPTADO')
            ],
            [
                'estatus' => Config('constants.ESTATUS_VACANTE_RECHAZADO')
            ],
        ]);
    }
}
