<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocketQueque extends Model
{

    protected $table = "socket_queque"; 

    protected $primaryKey = 'id';
    
    public $timestamps = false;
    //public $incrementing = false;
    
    protected $fillable = [
        'id_usuario',
        'sala',
        'titulo',
        'descripcion',
        'vista',
        'enviada',
        'created_at',
        'updated_at',
        'activo'
	];

}
