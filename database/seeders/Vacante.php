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
                'id_empresa' => '1',
                'titulo' => 'Vendedora de piso ',
                'descripcion' => 'se solicita vendedora para tienda departamental ',
                'categorías_especiales' => '',
                'días_laborales' => 'de L a V ',
                'id_turnos_laborales' => '3',
                'id_nivel_educativo' => '1',
                'sueldo' => '4,800',
                'direccion' => 'pedro de ceballos #1234',
                'colonia' => 'Buenos Aires',
                'código_postal' => '12323',
                'ciudad' => 'Guadalajara',
                'número_de_puestos_disponibles' => '1',  
                'area' => 'ventas',
                'Industria' => 'Mercado Corona',
                'tipo_de_puesto' => '',
                'habilidades_requeridas' => 'proactividad'
                ,'activo'=>1               
            ],
            [   
                'id_empresa' => '1',
                'titulo' => 'Mercado Corona',
                'descripcion' => 'cosinero de tacos',
                'categorías_especiales' => '',
                'días_laborales' => 'de L a V ',
                'id_turnos_laborales' => '2',
                'id_nivel_educativo' => '4',
                'sueldo' => '9,500',
                'direccion' => 'pedro de ceballos #1234',
                'colonia' => 'Buenos Aires',
                'código_postal' => '1234',
                'ciudad' => 'guadalajara',
                'número_de_puestos_disponibles' => '2',  
                'area' => 'taqueros',
                'Industria' => 'Mercado Corona',
                'tipo_de_puesto' => 'fijo',
                'habilidades_requeridas' => 'ninguna'  
                ,'activo'=>1 
            ],
            [   
                'id_empresa' => '1',
                'titulo' => 'programador',
                'descripcion' => 'Programdor web (Angular)',
                'categorías_especiales' => 'null',
                'días_laborales' => 'L a V',
                'id_turnos_laborales' => '1',
                'id_nivel_educativo' => '4',
                'sueldo' => '12,800',
                'direccion' => 'pedro de ceballos #1234',
                'colonia' => 'Buenos Aires',
                'código_postal' => '65432',
                'ciudad' => 'guadalajara',
                'número_de_puestos_disponibles' => '4',  
                'area' => 'Innovacion',
                'Industria' => 'Gobierno',
                'tipo_de_puesto' => 'temporal',
                'habilidades_requeridas' => 'experto en programacion'   
                ,'activo'=>1 
            ],
            [   
                'id_empresa' => '1',
                'titulo' => 'barrendero',
                'descripcion' => 'barrendero de las plazas',
                'categorías_especiales' => 'null',
                'días_laborales' => 'L a V',
                'id_turnos_laborales' => '1',
                'id_nivel_educativo' => '5',
                'sueldo' => '12,800',
                'direccion' => 'pedro de ceballos #1234',
                'colonia' => 'Buenos Aires',
                'código_postal' => '65432',
                'ciudad' => 'guadalajara',
                'número_de_puestos_disponibles' => '4',  
                'area' => 'Innovacion',
                'Industria' => 'Gobierno',
                'tipo_de_puesto' => 'temporal',
                'habilidades_requeridas' => 'experto en programacion'   
                ,'activo'=>1 
            ],
        ]);
    }
}
