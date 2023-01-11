<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuarios;

abstract class AuthService
{
    public static function authenticate($user, $password)
    {

        $user = Usuarios::with(['rol', 'rol.permisos'])
            ->where(function ($query) use ($user) {
                $query->where('correo', $user);
            })
            ->where("activo", 1)
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
        if (Hash::check($password, $user->contrasena)) {
            return [
                'status' => 200,
                'token' => self::jwt($user),
                'rol_id' => $user->rol_id,
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
            'permisos' => $user->rol->permisos->map(function ($rolePermission) {
                return $rolePermission->permiso;
            }),
            'iat' => time(),
            'exp' => time() + 1440 * 5000,
        ];
        
        return JWT::encode($payload, env('JWT_SECRET'), 'HS256');
    }
}
