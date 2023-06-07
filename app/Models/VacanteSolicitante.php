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
        'id_estatus',
        'talent_hunting',
        'activo',
        'created_at',
        'updated_at'
    ];

    /**
     * Obtiene solicitudes con info de la vacante    
     */
    public function rel_vacantes()
    {
        return $this->belongsTo(Vacantes::class,'id_vacante');
    }

    /**
     * Obtiene la solicitudes con info del solicitante
     */
    public function rel_solicitantes()
    {
        return $this->belongsToMany(Solicitante::class, 'relVacanteSolicitante', 'id', 'id_solicitante');
    }

    /**
     * Obtiene la solicitudes con info del solicitante
     */
    public function rel_solicitante()
    {
        return $this->belongsTo(Solicitante::class, 'id_solicitante');
    }

    public function tabla_estatus()
    {
        return $this->belongsTo(Estatus_postulacion::class, 'id_estatus');
    }
}
