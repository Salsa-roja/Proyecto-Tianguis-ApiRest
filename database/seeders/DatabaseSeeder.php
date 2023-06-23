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
        $this->call(EstatusEmpresaSeeder::class);
        $this->call(UsuariosSeeder::class);
        $this->call(EntidadesSeeder::class);
        $this->call(MunicipiosSeeder::class);
        $this->call(cpostalColoniasSeeder::class);
        $this->call(EmpresasSeeder::class);
        $this->call(NivelEducativoSeeder::class);
        $this->call(TurnosLaboralesSeeder::class);
        $this->call(EstatusPostulacionSeeder::class);
        $this->call(SolicitantesSeeder::class);
        $this->call(VacantesSeeder::class);
        $this->call(RelVacanteSolicitantesSeeder::class);
       

      
    }
}
