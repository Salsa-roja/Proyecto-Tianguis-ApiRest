<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Solicitante extends Model
{
    use HasFactory;

    protected $table = 'solicitantes';
    protected $primarykey = 'id';
    protected $fillable = [
        'nombre',
        'ape_paterno',
        'ape_materno',
        'edad',
        'curp',
        'telefono',
        'email',
        'pass',
        'c_numero',
        'c_postal',
        'id_colonia',
        'ciudad',
        'descr_prof',
        'sueldo_deseado',
        'area_desempeno',
        'posicion_interes',
        'industria_interes',
        'habilidades',
        'experiencia_profesional',
        'formacion_educativa',
        'disc_lenguaje',
        'disc_motriz',
        'disc_visual',
        'disc_mental',
        'disc_auditiva',
        'lugar_atencion',
        'curriculum'
    ];
}
