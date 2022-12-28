<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Turnos_laborales extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('turnos_laborales')->insert([
            [  
                'turnos' => 'Matutino'            
            ],
            [   
                'turnos' => 'Vespertino'
            ],
            [   
                'turnos' => 'Nocturno'
            ]
        ]);
    }
}
