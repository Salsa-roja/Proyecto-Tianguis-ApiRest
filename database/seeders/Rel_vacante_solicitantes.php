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
                'id_vacante' => 1,
                'id_solicitante' => 1,
            ],
            [  
                'id_vacante' => 2,
                'id_solicitante' => 2,
            ],
            [  
                'id_vacante' => 3,
                'id_solicitante' => 1,
            ],
            [  
                'id_vacante' => 3,
                'id_solicitante' => 2,
            ],
            [  
                'id_vacante' => 4,
                'id_solicitante' => 2,
            ],
            [  
                'id_vacante' => 4,
                'id_solicitante' => 1,
            ],

        ]);
    }
}
