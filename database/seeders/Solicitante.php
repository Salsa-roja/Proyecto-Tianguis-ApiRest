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
        DB::table('solicitantes')->insert([
            [   
                'nombre' => 'Jesus ',
                'ap_paterno' => 'Ibarra ',
                'ap_materno' => 'Larios',
                'edad' => 30,
                'curp' => 'ASDF722HDHW',
                'email' => 'Jesus@gmail.com',
                "pass" => password_hash('123456789', PASSWORD_BCRYPT),
                'telefono' => '3333591556',
                'c_numero' => 'pedro de ceballos #1234',
                'c_postal' => '31234',
                'id_colonia' => '1',
                'ciudad' => 'Guadalajara',
                'descr_profesional' => '',
                'sueldo_deseado' => 1000,
                'area_desempeno' => 'Guadalajara',
                'posicion_interes' => 'Patron',  
                'industria_interes' => 'Google',
                'habilidades' => 'Experto en todo',
                'exp_profesional' => 'Jefe de facebook',
                'formacion_educativa' => 'Universitario',
                'disc_lenguaje' => 0,
                'disc_motriz' => 0,
                'disc_visual' => 0,
                'disc_mental' => 0,
                'disc_auditiva' => 0,
                'lugar_atencion' => "Web",
                'curriculum' => 'si'            
            ]
        ]);
    }
}
