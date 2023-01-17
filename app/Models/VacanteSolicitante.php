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

    public function rel_solicitantes(){
        return $this->hasMany(Solicitante::class,'id_solicitante')->rel_vacantes();
    }

    public function rel_vacantes(){
        return $this->belongsToMany(Vacantes::class,'id_vacante');
    }
}
