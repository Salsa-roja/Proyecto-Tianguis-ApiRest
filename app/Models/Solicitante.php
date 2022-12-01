<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Preguntas;


class Solicitante extends Model
{
    use HasFactory;

    protected $table = 'solicitante';
    protected $primarykey = 'id';
    protected $fillable = [
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'email',
        'contrasena',
        'telefono',
        'direccion',
        'colonia',
        'código_postal',
        'ciudad',
        'descripcion_profesional',
        'área_desempeñarte',
        'que_posicion_buscas',
        'que_industria_interesan',
        'que_habilidad_posees',
        'experiencia_profesional',
        'formacion_educativa',
        'currículum' 
    ];
}
