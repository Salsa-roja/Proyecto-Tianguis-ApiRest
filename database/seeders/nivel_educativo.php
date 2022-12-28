<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Nivel_educativo extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('nivel_educativo')->insert([
            [  
                'titulo' => 'Primaria '            
            ],
            [   
                'titulo' => 'Secundaria'
            ],
            [   
                'titulo' => 'Preparatoria'
            ],
            [   
                'titulo' => 'Licenciatura '
            ],
            [   
                'titulo' => 'Posgrado '
            ],
        ]);
    }
}
