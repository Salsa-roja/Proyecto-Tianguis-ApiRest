<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Vacantes extends Model
{
    use HasFactory;

    protected $table = 'vacantes';
    protected $primarykey = 'id';
    protected $fillable = [
        'id_empresa',
        'vacantes',
        'descripcion',
        'categorías_especiales',
        'días_laborales',
        'id_turnos_laborales',
        'id_nivel_educativo',
        'direccion',
        'colonia',
        'código_postal',
        'ciudad',
        'número_de_puestos_disponibles',
        'area',
        'Industria',
        'tipo_de_puesto',
        'habilidades_requeridas',
    ];
    public function tabla_turnos_laborales()
    {
        return $this->belongsTo(Turnos_laborales::class, 'id_turnos_laborales');
    }
    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'id_empresa');
    }

    public function tabla_nivel_educativo()
    {
        return $this->belongsTo(Nivel_educativo::class, 'id_nivel_educativo');
    }

    public function rel_vacante_solicitante()
    {
        return $this->hasMany(VacanteSolicitante::class, 'id_vacante', 'id');
    }


}
