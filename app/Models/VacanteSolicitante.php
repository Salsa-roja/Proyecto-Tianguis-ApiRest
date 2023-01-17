<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VacanteSolicitante extends Model
{
    protected $table = "relVacanteSolicitante";

    protected $primaryKey = 'id';

    protected $fillable = [
        'id_vacante',
        'id_solicitante',
        'activo',
        'created_at',
        'updated_at'
    ];

    /**
     * Obtiene solicitudes con info de la vacante    
     */
    public function rel_vacantes(){
        return $this->belongsToMany(Vacantes::class,'relVacanteSolicitante','id','id_vacante');
    }
    
    /**
     * Obtiene la solicitudes con info del solicitante
     */
    public function rel_solicitantes(){
        return $this->belongsToMany(Solicitante::class, 'relVacanteSolicitante','id','id_solicitante');
    }

}
