<?php

namespace App\Models;
use App\Models\Rol;

use Illuminate\Database\Eloquent\Model;

class Permiso extends Model{
    
    protected $table = "cat_permisos"; 

    protected $primaryKey = 'id';

    protected $fillable = [
        'nombre',
        'permiso',
        'activo',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at'
	];

    public function roles(){
        return $this->belongsToMany(Rol::class, 'roles_permisos');
    }
}