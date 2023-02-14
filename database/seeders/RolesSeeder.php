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
                'id' => 1,
                'nombre' => 'Administrador',
                'permisos' => [
                    [
                        'nombre' => 'Modulo de Empresas',
                        'permiso' => 'EmpresasModule'
                    ],
                    [
                        'nombre' => 'Modulo de vacantes',
                        'permiso' => 'VacantesModule'
                    ],
                    [
                        'nombre' => 'Modulo de Usuarios',
                        'permiso' => 'UsuariosModule'
                    ],
                    [
                        'nombre' => 'Opcion de menu Empresas',
                        'permiso' => 'EmpresasMenu'
                    ],
                    [
                        'nombre' => 'Ocion de menu vacantes',
                        'permiso' => 'VacantesMenu'
                    ],
                    [
                        'nombre' => 'Opcion de menu Usuarios',
                        'permiso' => 'UsuariosMenu'
                    ],
                    [
                        'nombre' => 'Formulario de Usuarios',
                        'permiso' => 'UsuariosForm'
                    ],
                    [
                        'nombre' => 'Formulario de empresa',
                        'permiso' => 'EmpresasForm'
                    ],
                    [
                        'nombre' => 'Listado de empresas',
                        'permiso' => 'EmpresasList'
                    ],
                    [
                        'nombre' => 'Listado de vacantes',
                        'permiso' => 'VacantesList'
                    ],
                    [
                        'nombre' => 'Listado de usuarios',
                        'permiso' => 'UsuariosList'
                    ],
                    [
                        'nombre' => 'Redactar emails con interfaz',
                        'permiso' => 'WriteMail'
                    ],       
                ]
            ],
            [
                'id' => 2,
                'nombre' => 'Solicitante',
                'permisos' => [
                    [
                        'nombre' => 'Modulo de Solicitantes',
                        'permiso' => 'SolicitantesModule'
                    ],
                    [
                        'nombre' => 'Perfil de Solicitante',
                        'permiso' => 'SolicitantesPerfil'
                    ],
                    [
                        'nombre' => 'Formulario de solicitante',
                        'permiso' => 'SolicitantesForm'
                    ],
                    [
                        'nombre' => 'Listado de vacantes',
                        'permiso' => 'VacantesList'
                    ]
                ]
            ],
            [
                'id' => 3,
                'nombre' => 'Empresa',
                'permisos' => [
                    [
                        'nombre' => 'Ocion de menu empresas',
                        'permiso' => 'EmpresasModule'
                    ],
                    [
                        'nombre' => 'Formulario de empresa',
                        'permiso' => 'EmpresasForm'
                    ],
                    [
                        'nombre' => 'Modulo de vacantes',
                        'permiso' => 'VacantesModule'
                    ],
                    [
                        'nombre' => 'Modulo de Usuarios',
                        'permiso' => 'UsuariosModule'
                    ],
                    [
                        'nombre' => 'Ocion de menu vacantes',
                        'permiso' => 'VacantesMenu'
                    ],
                    [
                        'nombre' => 'Opcion de menu Usuarios',
                        'permiso' => 'UsuariosMenu'
                    ],
                    [
                        'nombre' => 'Formulario de Usuarios',
                        'permiso' => 'UsuariosForm'
                    ],
                    [
                        'nombre' => 'Perfil de Empresa',
                        'permiso' => 'EmpresasPerfil'
                    ],
                    [
                        'nombre' => 'Formulario de vacantes',
                        'permiso' => 'VacantesForm'
                    ],
                    [
                        'nombre' => 'Listado de vacantes',
                        'permiso' => 'VacantesList'
                    ],
                    [
                        'nombre' => 'Redactar emails con interfaz',
                        'permiso' => 'WriteMail'
                    ],

                    [
                        'nombre' => 'Listado de usuarios',
                        'permiso' => 'UsuariosList'
                    ],              
                ]
            ]
        ];

        foreach ($roles as $key => $role) {
            $r = new Rol();
            $r->id = $role['id'];
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
