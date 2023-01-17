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

    public function usuario_empresa(){
        return $this->belongsToMany(    Empresa::class,
                                        'relUsuarioEmpresa',
                                        'usuario_id',
                                        'empresa_id',
                                        'id',//usuario.id
                                        'id'//empresa.id
                                    )->where('relUsuarioEmpresa.activo',true);
    }

    /**
     * usuarios con info de solicitante vacantes a las que se han vinculado
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