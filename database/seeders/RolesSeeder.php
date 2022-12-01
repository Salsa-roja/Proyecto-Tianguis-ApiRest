<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rol;
use App\Models\Permiso;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'nombre' => 'Administrador',
                'permisos' => [
                    [
                        'nombre' => 'Configuración de horarios ',
                        'permiso' => 'HorariosList'
                    ],
                    [
                        'nombre' => 'Listado de citas',
                        'permiso' => 'CitasList'
                    ],
                    [
                        'nombre' => 'Listado de trámites',
                        'permiso' => 'TrámitesList'
                    ],
                    [
                        'nombre' => 'Listado de usuarios',
                        'permiso' => 'UsuariosList'
                    ],
                    [
                        'nombre' => 'Listado de roles',
                        'permiso' => 'RolesList'
                    ]
                ]
            ]
        ];

        foreach ($roles as $key => $role) {
            $r = new Rol();
            $r->nombre = $role['nombre'];
            $r->save();
            $permisosSaved = [];
            foreach ($role['permisos'] as $key => $permiso) {
                $p = new Permiso();
                $p->nombre = $permiso['nombre'];
                $p->permiso = $permiso['permiso'];
                $p->save();
                array_push($permisosSaved, $p->id);
            }
            $r->permisos()->attach($permisosSaved);
            $r->save();
        }
    }
}
