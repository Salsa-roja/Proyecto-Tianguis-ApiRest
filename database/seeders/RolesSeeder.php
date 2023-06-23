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
                'nombre' => Config('constants.ROL_ADMIN'),
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
                        'nombre' => 'Opcion de menu Noticias',
                        'permiso' => 'NoticiasMenu'
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
                        'nombre' => 'Perfil de Empresa',
                        'permiso' => 'EmpresasPerfil'
                    ],
                    [
                        'nombre' => 'Editar perfil empresa',
                        'permiso' => 'EmpresasPerfilForm'
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
                    [
                        'nombre' => 'Modulo de Reportes',
                        'permiso' => 'ReportsModule'
                    ],
                    [
                        'nombre' => 'Modulo de Comentarios',
                        'permiso' => 'ContactoList'
                    ],
                    [
                        'nombre' => 'Modulo de Noticias',
                        'permiso' => 'NoticiasModule'
                    ],
                    [
                        'nombre' => 'Formulario de Noticias',
                        'permiso' => 'NoticiasForm'
                    ],
                    [
                        'nombre' => 'Listado de Noticias',
                        'permiso' => 'NoticiasList'
                    ],
                ]
            ],
            [
                'id' => 2,
                'nombre' => Config('constants.ROL_SOLICITANTE'),
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
                        'nombre' => 'Editar perfil solicitante',
                        'permiso' => 'SolicitantesPerfilForm'
                    ],
                    [
                        'nombre' => 'Listado de vacantes',
                        'permiso' => 'VacantesList'
                    ],
                    [
                        'nombre' => 'Listado de Noticias',
                        'permiso' => 'NoticiasList'
                    ],
                ]
            ],
            [
                'id' => 3,
                'nombre' => Config('constants.ROL_EMPRESA'),
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
                        'nombre' => 'Opcion de menu Perfil de Empresa',
                        'permiso' => 'EmpresasPerfilMenu'
                    ],
                    [
                        'nombre' => 'Editar perfil empresa',
                        'permiso' => 'EmpresasPerfilForm'
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
                        'nombre' => 'Listado de usuarios',
                        'permiso' => 'UsuariosList'
                    ],
                    [
                        'nombre' => 'Listado de Noticias',
                        'permiso' => 'NoticiasList'
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
