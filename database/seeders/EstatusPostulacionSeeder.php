<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstatusPostulacionSeeder extends Seeder
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
                'estatus' =>  Config('constants.ESTATUS_POSTULACION_NO_VISTO')
            ],
            [
                'estatus' =>  Config('constants.ESTATUS_POSTULACION_VISTO')
            ],
            [
                'estatus' =>  Config('constants.ESTATUS_POSTULACION_EN_PROCESO')
            ],
            [
                'estatus' => Config('constants.ESTATUS_POSTULACION_ACEPTADO')
            ],
            [
                'estatus' => Config('constants.ESTATUS_POSTULACION_RECHAZADO')
            ],
        ]);
    }
}
