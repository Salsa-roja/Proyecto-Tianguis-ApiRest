<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstatusPostulacionSeeder extends Seeder
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
                'estatus' => 'Visto'
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
