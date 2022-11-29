<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Vacante extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('vacante')->insert([
            [  
                'empleador_id' => 1,
                'titulo' => 'Vendedora de piso ',
                'descripcion' => 'se solicita vendedora para tienda departamental ',
                'categorías_especiales' => '',
                'días_laborales' => 'de L a V ',
                'turnos_laborales' => 'Mañana',
                'nivel_educativo' => 'Preparatoria',
                'direccion' => 'pedro de ceballos #1234',
                'colonia' => 'Buenos Aires',
                'código_postal' => '12323',
                'ciudad' => 'Guadalajara',
                'número_de_puestos_disponibles' => '1',  
                'area' => 'ventas',
                'Industria' => 'Mercado Corona',
                'tipo_de_puesto' => '',
                'habilidades_requeridas' => 'proactividad'              
            ],
            [   
                'empleador_id' => 1,
                'titulo' => 'Mercado Corona',
                'descripcion' => 'cosinero de tacos',
                'categorías_especiales' => '',
                'días_laborales' => 'de L a V ',
                'turnos_laborales' => 'Tarde',
                'nivel_educativo' => 'ninguna',
                'direccion' => 'pedro de ceballos #1234',
                'colonia' => 'Buenos Aires',
                'código_postal' => '1234',
                'ciudad' => 'guadalajara',
                'número_de_puestos_disponibles' => '2',  
                'area' => 'taqueros',
                'Industria' => 'Mercado Corona',
                'tipo_de_puesto' => 'fijo',
                'habilidades_requeridas' => 'ninguna'  
            ],
            [   
                'empleador_id' => 1,
                'titulo' => 'programador',
                'descripcion' => 'Programdor web (Angular)',
                'categorías_especiales' => 'null',
                'días_laborales' => 'L a V',
                'turnos_laborales' => 'Mañana',
                'nivel_educativo' => 'Universidad',
                'direccion' => 'pedro de ceballos #1234',
                'colonia' => 'Buenos Aires',
                'código_postal' => '65432',
                'ciudad' => 'guadalajara',
                'número_de_puestos_disponibles' => '4',  
                'area' => 'Innovacion',
                'Industria' => 'Gobierno',
                'tipo_de_puesto' => 'temporal',
                'habilidades_requeridas' => 'experto en programacion'    
            ],
        ]);
    }
}
