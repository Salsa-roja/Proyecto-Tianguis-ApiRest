<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Solicitante extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('solicitante')->insert([
            [  
                'nombre' => 'Jesus ',
                'apellido_paterno' => 'Ibarra ',
                'apellido_materno' => 'Larios',
                'email' => 'Jesus@gmail.com',
                "contrasena" => password_hash('123456789', PASSWORD_BCRYPT),
                'telefono' => '3333591556',
                'direccion' => 'pedro de ceballos #1234',
                'colonia' => 'Buenos Aires',
                'código_postal' => '31234',
                'ciudad' => 'Guadalajara',
                'descripcion_profesional' => '',
                'área_desempeñarte' => 'Guadalajara',
                'que_posicion_buscas' => 'Patron',  
                'que_industria_interesan' => 'Google',
                'que_habilidad_posees' => 'Experto en todo',
                'experiencia_profesional' => 'Jefe de facebook',
                'formacion_educativa' => 'Universitario',
                'currículum' => 'si'              
            ]
        ]);
    }
}
