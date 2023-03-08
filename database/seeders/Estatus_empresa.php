<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Estatus_empresa extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('estatus_empresa')->insert([
            [
                'estatus' => 'Activo'
            ],
            [
                'estatus' => 'Inhabilitado'
            ],
            [
                'estatus' => 'Rechazado'
            ],
            [
                'estatus' => 'Alerta'
            ],
            [
                'estatus' => 'En revicion'
            ]
        ]);
    }
}
