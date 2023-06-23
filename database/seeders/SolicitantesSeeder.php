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

        $solicitantes=[
            [
                'nombres' => 'Jesus Antonio',
                'ape_paterno' => 'Ibarra',
                'ape_materno' => 'Larios',
                'nombre_login' => 'solicitante1',
                'correo' => 'solicitante@quierochamba.com',
                'edad' => 23,
                'curp' => 'ASDF722HDHWFFW4543',
                'telefono' => '3333591556',
                'c_numero' => 'pedro de ceballos #1234',
                'c_postal' => '44100',
                'id_colonia' => 1,
                'ciudad' => 'Guadalajara',
                'descr_profesional' => 'Experto',
                'sueldo_deseado' =>10000,
                'area_desempeno' => 'Mantenimiento',
                'posicion_interes' => 'Jefe',
                'industria_interes' => 'Alimentos',
                'habilidades' => 'Cocina',
                'exp_profesional' => '2 años',
                'disc_lenguaje' => 0,
                'disc_motriz' => 0,
                'disc_visual' => 0,
                'disc_mental' => 0,
                'disc_auditiva' => 1,
                'lugar_atencion' => 'Web',
                'curriculum' => '',
                'id_nivel_educativo'=> 4
            ],
            [
                'nombres' => 'Alonso Adair',
                'ape_paterno' => 'Aguet',
                'ape_materno' => 'Orozco',
                'nombre_login' => 'solicitante2',
                'correo' => 'solicitante2@quierochamba.com',
                'edad' => 25,
                'curp' => 'AUOA970429HJCGRL05',
                'telefono' => '3121107201',
                'c_numero' => 'miguel hidalgo y costilla #469',
                'c_postal' => '44100',
                'id_colonia' => 1,
                'ciudad' => 'Guadalajara',
                'descr_profesional' => 'Experto',
                'sueldo_deseado' =>19000,
                'area_desempeno' => 'Programación',
                'posicion_interes' => 'Jefe',
                'industria_interes' => 'Tecnología',
                'habilidades' => 'Angular, Php, JQuery',
                'exp_profesional' => '2 años',
                'disc_lenguaje' => 0,
                'disc_motriz' => 0,
                'disc_visual' => 0,
                'disc_mental' => 0,
                'disc_auditiva' => 0,
                'lugar_atencion' => 'Web',
                'curriculum' => '',
                'id_nivel_educativo'=> 3
            ],
        ];

        foreach ($solicitantes as $k => $v) {
            
            # guardar usuario
            $Usuario = new Usuarios();
            $Usuario->nombres = $v['nombres'];
            $Usuario->ape_paterno = $v['ape_paterno'];
            $Usuario->ape_materno = $v['ape_materno'];
            $Usuario->correo = $v['correo'];
            $Usuario->nombre_login = $v['nombre_login'];
            $Usuario->contrasena = password_hash('123456789', PASSWORD_BCRYPT);
            $Usuario->rol_id = Rol::where('nombre', Config('constants.ROL_SOLICITANTE'))->first()->id;
            $Usuario->save();
   
            # guardar solicitante
            $Solicitante = new Solicitante();
            $Solicitante->id_usuario = $Usuario->id; 
            $Solicitante->edad = $v['edad'];
            $Solicitante->curp = $v['curp'];
            $Solicitante->telefono = $v['telefono'];
            $Solicitante->c_numero = $v['c_numero'];
            $Solicitante->c_postal = $v['c_postal'];
            $Solicitante->id_colonia = $v['id_colonia'];
            $Solicitante->ciudad = $v['ciudad'];
            $Solicitante->descr_profesional = $v['descr_profesional'];
            $Solicitante->sueldo_deseado = $v['sueldo_deseado'];
            $Solicitante->area_desempeno = $v['area_desempeno'];
            $Solicitante->posicion_interes = $v['posicion_interes'];
            $Solicitante->industria_interes = $v['industria_interes'];
            $Solicitante->habilidades = $v['habilidades'];
            $Solicitante->exp_profesional = $v['exp_profesional'];
            $Solicitante->disc_lenguaje = $v['disc_lenguaje'];
            $Solicitante->disc_motriz = $v['disc_motriz'];
            $Solicitante->disc_visual = $v['disc_visual'];
            $Solicitante->disc_mental = $v['disc_mental'];
            $Solicitante->disc_auditiva = $v['disc_auditiva'];
            $Solicitante->lugar_atencion = $v['lugar_atencion'];
            $Solicitante->curriculum = $v['curriculum'];
            $Solicitante->id_nivel_educativo = $v['id_nivel_educativo'];
            $Solicitante->save();
        }

    }
}
