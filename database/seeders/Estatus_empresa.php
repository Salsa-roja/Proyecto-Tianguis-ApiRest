<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Estatus_empresa extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('estatus_empresa')->insert([
            [
                'estatus' => Config('constants.ESTATUS_EMPRESA_ACTIVO')
            ],
            [
                'estatus' => Config('constants.ESTATUS_EMPRESA_INHABILITADO')
            ],
            [
                'estatus' => Config('constants.ESTATUS_EMPRESA_RECHAZADO')
            ],
            [
                'estatus' => Config('constants.ESTATUS_EMPRESA_ALERTA')
            ],
            [
                'estatus' => Config('constants.ESTATUS_EMPRESA_EN_REVICION')
            ]
        ]);
    }
}
