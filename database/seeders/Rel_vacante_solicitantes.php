<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Rel_vacante_solicitantes extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('relVacanteSolicitante')->insert([
            [  
                'idVacante' => 1,
                'idSolicitante' => 1,
            ],
            [  
                'idVacante' => 2,
                'idSolicitante' => 1,
            ]
        ]);
    }
}
