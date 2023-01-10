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
        return $this->hasMany(Usuarios::class,'id_usuario')->rel_empresas();
    }

    public function rel_empresas(){
        return $this->belongsTo(Empresa::class,'id_empresa');
    }
}