<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Vacantes extends Model
{
    use HasFactory;

    protected $table = 'vacante';
    protected $primarykey = 'id';
    protected $fillable = [
        'empleador_id',
        'titulo',
        'descripcion',
        'categorías_especiales',
        'días_laborales',
        'turnos_laborales',
        'nivel_educativo',
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

    public function empleador()
    {
        return $this->belongsTo(Empleador::class, 'empleador_id');
    }
}
