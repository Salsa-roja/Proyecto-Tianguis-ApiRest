<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Estatus_postulacion extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('estatus_postulacion')->insert([
            [
                'estatus' => 'No visto'
            ],
            [
                'estatus' => 'visto'
            ],
            [
                'estatus' => 'En proceso'
            ],
            [
                'estatus' => 'Aceptado'
            ],
            [
                'estatus' => 'Rechazado'
            ],
        ]);
    }
}
