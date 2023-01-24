<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Usuarios;
use App\Models\Rol;
use App\Models\Solicitante;



class SolicitantesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        #guardar usuario

         # guardar usuario
         $Usuario = new Usuarios();
         $Usuario->nombres = 'Jesus Antonio';
         $Usuario->ape_paterno = 'Ibarra';
         $Usuario->ape_materno = 'Larios';
         $Usuario->correo = 'solicitante@quierochamba.com';
         $Usuario->contrasena = password_hash('123456789', PASSWORD_BCRYPT);
         $Usuario->rol_id = Rol::where('nombre', 'Solicitante')->first()->id;
         $Usuario->save();

         # guardar solicitante
         $Solicitante = new Solicitante();
         $Solicitante->id_usuario = $Usuario->id; 
         $Solicitante->edad = 30;
         $Solicitante->curp = 'ASDF722HDHWFFW4543';
         $Solicitante->telefono = '3333591556';
         $Solicitante->c_numero = 'pedro de ceballos #1234';
         $Solicitante->c_postal = '44100';
         $Solicitante->id_colonia = 1;
         $Solicitante->ciudad = 'Guadalajara';
         $Solicitante->descr_profesional = '';
         $Solicitante->sueldo_deseado = 10000;
         $Solicitante->area_desempeno = 'Mantenimiento';
         $Solicitante->posicion_interes = 'Patron';
         $Solicitante->industria_interes = 'Google';
         $Solicitante->habilidades = 'Experto en todo';
         $Solicitante->exp_profesional = 'Jefe de facebook';
         $Solicitante->formacion_educativa = 'Universitario';
         $Solicitante->disc_lenguaje = 0;
         $Solicitante->disc_motriz = 0;
         $Solicitante->disc_visual = 0;
         $Solicitante->disc_mental = 0;
         $Solicitante->disc_auditiva = 0;
         $Solicitante->lugar_atencion = 'Web';
         $Solicitante->curriculum = '';
         $Solicitante->save();

    }
}
