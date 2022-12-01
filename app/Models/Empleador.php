<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Preguntas;


class Empleador extends Model
{
    use HasFactory;

    protected $table = 'empleador';
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
        'notas' 
    ];
}
