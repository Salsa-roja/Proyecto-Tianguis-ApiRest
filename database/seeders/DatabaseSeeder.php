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
        $this->call(Empleador::class);
        $this->call(Nivel_educativo::class);
        $this->call(Turnos_laborales::class);
        $this->call(RolesSeeder::class);
        $this->call(EntidadesSeeder::class);
        $this->call(MunicipiosSeeder::class);
        $this->call(CPostalColoniasSeeder::class);
        $this->call(Solicitante::class);
        $this->call(UsuariosSeeder::class);
        $this->call(Vacante::class);
        $this->call(Rel_vacante_solicitantes::class);
       

      
    }
}
