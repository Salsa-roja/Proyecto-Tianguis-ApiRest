<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RolesSeeder::class);
        $this->call(UsuariosSeeder::class);
        $this->call(EntidadesSeeder::class);
        $this->call(MunicipiosSeeder::class);
        $this->call(CPostalColoniasSeeder::class);
        $this->call(EmpresasSeeder::class);
        $this->call(Nivel_educativo::class);
        $this->call(Turnos_laborales::class);
        $this->call(Estatus_postulacion::class);
        $this->call(SolicitantesSeeder::class);
        $this->call(Vacante::class);
        $this->call(Rel_vacante_solicitantes::class);
       

      
    }
}
