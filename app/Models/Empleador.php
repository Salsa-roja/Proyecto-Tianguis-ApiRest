<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Empleador extends Model
{
    use HasFactory;

    protected $table = 'empleador';
    protected $primarykey = 'id';
    protected $fillable = [
        'nombre',
        'ap_paterno',
        'ap_materno',
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
