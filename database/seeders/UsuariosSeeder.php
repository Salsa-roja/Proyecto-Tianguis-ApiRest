<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Usuarios;
use App\Models\Rol;

class UsuariosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $usuarios = [
            [
                'nombres' => 'Administrador General',
                'ape_paterno' => '',
                'ape_materno' => '',
                'nombre_login' => 'admin1',
                'correo' => 'admin@admin.com',
                'contrasena' => password_hash('123456789', PASSWORD_BCRYPT),
                'rol_id' => Rol::where('nombre', Config('constants.ROL_ADMIN'))->first()->id
            ]

        ];
        foreach ($usuarios as $key => $obj) {
            $z = new Usuarios();
            $z->nombres = $obj['nombres'];
            $z->rol_id = $obj['rol_id'];
            $z->ape_paterno = $obj['ape_paterno'];
            $z->ape_materno = $obj['ape_materno'];
            $z->nombre_login = $obj['nombre_login'];
            $z->correo = $obj['correo'];
            $z->contrasena = $obj['contrasena'];
            $z->save();
        }
    }
}
