<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Permiso;
 
class Rol extends Model{
    
    protected $table = "cat_roles"; 

    protected $primaryKey = 'id';

    protected $fillable = [
        'nombre',
        'activo',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at'
	];

    public function permisos(){
        return $this->belongsToMany(Permiso::class, 'roles_permisos');
    }
}