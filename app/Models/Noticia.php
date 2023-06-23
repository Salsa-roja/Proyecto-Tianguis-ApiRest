<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Noticia extends Model
{
    protected $table = "tbl_noticias"; 

    protected $primaryKey = 'id';
    
    protected $fillable = [
        'titulo',
        'imagen',
        'descripcion',
        'fecha_publicacion',
        'activo',
        'created_at',
        'updated_at'
	];

    protected $appends = ['ruta_imagen'];

    public function getrutaImagenAttribute()
    {
        if (isset($this->imagen) && $this->imagen != '')
            return env('APP_URL') . '/dwl/noticias/'.$this->id;
        return null;
    }
}
