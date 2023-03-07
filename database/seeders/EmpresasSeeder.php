<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Empresa;
use App\Models\Usuarios;
use App\Models\UsuariosEmpresas;
use App\Models\Rol;

class EmpresasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

         # guardar usuario
         $Usuario = new Usuarios();
         $Usuario->nombres = "Diego Armando Maradonio Del piero López";
         $Usuario->ape_paterno = "";
         $Usuario->ape_materno = "";
         $Usuario->nombre_login = "empresa1";
         $Usuario->correo = "empresa@quierochamba.com";
         $Usuario->contrasena = password_hash("123456789", PASSWORD_BCRYPT);
         $Usuario->rol_id = Rol::where('nombre', 'Empresa')->first()->id;
         $Usuario->save();

         # guardar empresa
         $Empresa = new Empresa();
         $Empresa->nombre_comercial = "Empaques de México";
         $Empresa->razon_social = "Surtidora Nacional de Plásticos S.A. de C.V.";
         $Empresa->rfc = "STNP290497FGTD";
         $Empresa->descripcion = "Para servirle";
         $Empresa->numero_empleados = 30;

         $Empresa->constancia_sit_fiscal = '';
         $Empresa->licencia_municipal = '';
         $Empresa->alta_patronal = '';
         
         $Empresa->contr_discapacitados = true;
         $Empresa->contr_antecedentes = true;
         $Empresa->contr_adultos = true;
         
         $Empresa->nombre_rh = "Diego Armando Maradonio Del piero López";
         $Empresa->correo_rh = "empresa@quierochamba.com";
         $Empresa->telefono_rh = "3121232222";
         $Empresa->id_estatus = 1 ;
         $Empresa->save();

         # guardar relacion
         $UsrEmp = new UsuariosEmpresas();
         $UsrEmp->id_usuario = $Usuario->id;
         $UsrEmp->id_empresa = $Empresa->id;
         $UsrEmp->save();

    }
}
