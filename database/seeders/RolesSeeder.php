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
                        'nombre' => 'Listado de usuarios',
                        'permiso' => 'UsuariosList'
                    ],
                    [
                        'nombre' => 'Listado de roles',
                        'permiso' => 'RolesList'
                    ]
                ]
            ],
            [
                'nombre' => 'Solicitante',
                'permisos' => [
                    [
                        'nombre' => 'Formulario de Registro de solicitante',
                        'permiso' => 'SolicitanteForm'
                    ]
                ]
            ],
            [
                'nombre' => 'Empresa',
                'permisos' => [
                    [
                        'nombre' => 'Formulario de Registro de empresa',
                        'permiso' => 'EmpresasForm'
                    ],
                    [
                        'nombre' => 'Ocion de menu vacantes',
                        'permiso' => 'VacantesModule'
                    ],
                    [
                        'nombre' => 'Formulario de Registro de vacantes',
                        'permiso' => 'VacantesForm'
                    ],
                    [
                        'nombre' => 'Listado de vacantes',
                        'permiso' => 'VacantesList'
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
