<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocketClient extends Model
{

    protected $table = "socket_active_connections"; 
    
    public $timestamps = false;
    public $incrementing = false;
    
    protected $fillable = [
        'idHandshake',
        'id_usuario',
        'created_at'
	];

}
