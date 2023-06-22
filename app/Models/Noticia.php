<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Noticia extends Model
{
    protected $table = "tbl_noticias"; 

    protected $primaryKey = 'id';
    
    public $timestamps = false;
    //public $incrementing = false;
    
    protected $fillable = [
        'titulo',
        'imagen',
        'descripcion',
        'fecha_publicacion',
        'activo',
        'created_at',
        'updated_at'
	];

    protected $appends = ['ruta_archivo'];

    public function getrutaArchivoAttribute()
    {
        if (isset($this->archivo) && $this->archivo != '')
            return env('APP_URL') . 'noticias/';
        return null;
    }
}
