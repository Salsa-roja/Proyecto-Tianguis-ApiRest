<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Empleador extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('empleador')->insert([
            [  
                'nombre' => 'Antonio ',
                'apellido_paterno' => 'Ibarra ',
                'apellido_materno' => 'Larios',
                'email' => 'Antonio@gmail.com',
                "contrasena" => password_hash('123456789', PASSWORD_BCRYPT),
                'telefono' => '3333591556',
                'direccion' => 'pedro de ceballos #1234',
                'colonia' => 'Buenos Aires',
                'código_postal' => '31234',
                'ciudad' => 'Guadalajara',
                'notas' => ''  
            ]
        ]);
    }
}
