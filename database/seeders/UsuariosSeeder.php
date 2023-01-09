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
                'nombres' => 'Administrador',
                'ape_paterno' => '',
                'ape_materno' => '',
                'correo' => 'admin@admin.com',
                "contrasena" => password_hash('123456789', PASSWORD_BCRYPT)
            ],
            [
                'nombres' => 'Administrador2',
                'ape_paterno' => '',
                'ape_materno' => '',
                'correo' => 'admin2@admin.com',
                "contrasena" => password_hash('123456789', PASSWORD_BCRYPT)
            ]
        ];
        foreach ($usuarios as $key => $obj) {
            $z = new Usuarios();
            $z->nombres = $obj['nombres'];
            $z->rol_id = Rol::where('nombre', 'Administrador')->first()->id;
            $z->ape_paterno = $obj['ape_paterno'];
            $z->ape_materno = $obj['ape_materno'];
            $z->correo = $obj['correo'];
            $z->contrasena = $obj['contrasena'];
            $z->save();
        }
    }
}
