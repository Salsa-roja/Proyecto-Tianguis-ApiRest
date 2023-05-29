<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuarios;

abstract class AuthService
{
    public static function authenticate($nombre_login, $password)
    {
        $user = Usuarios::with(['rol', 'rol.permisos', 'usuario_solicitante', 'usuario_empresa.rel_empresas'])
            ->where(['activo' => 1, 'nombre_login' => $nombre_login])
            ->first();

        // return $user;

        if (!$user) {
            return [
                'status' => 400,
                'token' => '',
                'message' => 'El usuario no existe'
            ];
        }

        // Verify the password and generate the token
        if (Hash::check($password, $user->contrasena) ) {

            return [
                'status' => 200,
                'token' => self::jwt($user),
                'rol_id' => $user->rol_id,
                // validacion del login que muestra si la empresa ha tenido demasiadas alertas
                'estatus' => isset($user->usuario_empresa) ? $user->usuario_empresa->rel_empresas->activo : true,
                'info' => $user,
                'message' => 'Autorizado'
            ];
        } 

        // Bad Request response
        return [
            'status' => 400,
            'token' => '',
            'message' => 'Usuario o contraseña incorrectos'
        ];
    }

    /**
     * Create a new token.
     * 
     * @param  \App\User   $user
     * @return string
     */
    public static function jwt($user)
    {

        $payload = [
            'id' => $user->id,
            'nombre' => $user->nombre_completo,
            'correo' => $user->correo,
            'rol' => $user->rol->nombre,
            'rol_id' => $user->rol_id,
            'permisos' => $user->rol->permisos->map(function ($rolePermission) {
                return $rolePermission->permiso;
            }),
            'id_empresa' => !is_null($user->usuario_empresa) ? $user->usuario_empresa->rel_empresas['id'] : null,
            'id_solicitante' => !is_null($user->usuario_solicitante) ? $user->usuario_solicitante['id'] : null,
            'iat' => time(),
            'exp' => time() + 1440 * 5000,
        ];

        return JWT::encode($payload, env('JWT_SECRET'), 'HS256');
    }
}
