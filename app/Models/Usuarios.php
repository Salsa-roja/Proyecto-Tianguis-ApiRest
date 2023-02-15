<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Rol;

class Usuarios extends Model{

    protected $table = "usuarios"; 
    
    protected $primaryKey = 'id';

    protected $fillable = [
        'rol_id',
        'nombres',
        'ape_paterno',
        'ape_materno',
        'nombre_login',
        'correo',
        'contrasena',
        'activo',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at'
	];

    protected $appends = ['nombre_completo'];

    public function getNombreCompletoAttribute()
    {
        return $this->nombres . ' ' . $this->ape_paterno . ' ' . $this->ape_materno;
    }

    public function rol()
    {
        return $this->belongsTo(Rol::class);
    }

    /**
     * usuarios con info de empresa
     */
    public function usuario_empresa(){
        return $this->hasOne(UsuariosEmpresas::class,'id_usuario','id');
        /* return $this->hasOneThrough(
                                    Empresa::class,
                                    UsuariosEmpresas::class,
                                    'id_usuario',// Foreign key on relUsuarioEmpresa table...
                                    'id_empresa',// Foreign key on empresas table...
                                    'id',// Local key on usuarios table...
                                    'id'// Local key on relUsuarioEmpresa table...
                                ); */
    }

    /**
     * usuarios con info de solicitante
     */
    public function usuario_solicitante(){
        return $this->hasOne(Solicitante::class,'id_usuario');
    }

    /**
     * usuarios con info de solicitante y vacantes a las que se han vinculado
     */
    public function rel_usuario_solicitante_vacante(){
        return $this->hasManyThrough(
            VacanteSolicitante::class,
            Solicitante::class,
            'id_usuario', // Foreign key on solicitantes table...
            'id_solicitante', // Foreign key on relVacanteSolicitante table...
            'id', // Local key on usuarios table...
            'id' // Local key on solicitantes table...
        ); 
    }
}