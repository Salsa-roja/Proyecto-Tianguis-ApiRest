<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contacto extends Model
{
    protected $table = 'contacto';
    protected $primarykey = 'id';
    protected $fillable = [
        'nombre',
        'correo',
        'comentario',
        'activo'
    ];
}
