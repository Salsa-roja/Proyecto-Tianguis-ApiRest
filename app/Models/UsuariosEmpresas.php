<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsuariosEmpresas extends Model
{
    protected $table = "relUsuarioEmpresa";

    protected $primaryKey = 'id';

    protected $fillable = [
        'id_usuario',
        'id_empresa',
        'activo',
        'created_at',
        'updated_at'
    ];

    public function rel_usuarios(){
        return $this->hasOne(Usuarios::class,'id','id_usuario');
    }

    public function rel_empresas(){
        return $this->belongsTo(Empresa::class,'id_empresa');
    }
}