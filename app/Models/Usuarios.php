<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Rol;

class Usuarios extends Model{

    protected $table = "usuarios"; 
    
    protected $primaryKey = 'id';

    protected $fillable = [
        'rol_id',
        'nombres',
        'ape_paterno',
        'ape_materno',
        'correo',
        'contrasena',
        'activo',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at'
	];

    protected $appends = ['nombre_completo'];

    public function getNombreCompletoAttribute()
    {
        return $this->nombres . ' ' . $this->ape_paterno . ' ' . $this->ape_materno;
    }

    public function rol()
    {
        return $this->belongsTo(Rol::class);
    }
}