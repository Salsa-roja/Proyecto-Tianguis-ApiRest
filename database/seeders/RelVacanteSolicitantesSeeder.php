<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RelVacanteSolicitantesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $date = date('Y-m-d H:i:s', strtotime('+5 minutes', time()));

        DB::table('relVacanteSolicitante')->insert([
            [
                'id_vacante' => 1,
                'id_solicitante' => 1,
                'id_estatus' => 1,
                'TalentHunting' => 1,
                'created_at' => $date
            ],
            [
                'id_vacante' => 2,
                'id_solicitante' => 2,
                'id_estatus' => 1,
                'TalentHunting' => 1,
                'created_at' => $date
            ],
            [
                'id_vacante' => 3,
                'id_solicitante' => 1,
                'id_estatus' => 1,
                'TalentHunting' => 1,
                'created_at' => $date
            ],
            [
                'id_vacante' => 3,
                'id_solicitante' => 2,
                'id_estatus' => 1,
                'TalentHunting' => 1,
                'created_at' => $date
            ],
            [
                'id_vacante' => 4,
                'id_solicitante' => 2,
                'id_estatus' => 1,
                'TalentHunting' => 1,
                'created_at' => $date
            ],
            [
                'id_vacante' => 4,
                'id_solicitante' => 1,
                'id_estatus' => 1,
                'TalentHunting' => 1,
                'created_at' => $date
            ],

        ]);
    }
}
