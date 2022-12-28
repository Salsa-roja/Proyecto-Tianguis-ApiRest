<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Archivo extends Model
{
    protected $table = 'archivos';

    protected $primaryKey = 'id';

    protected $fillable = [
        'nombre',
        'path',
        'activo',
        'created_at',
        'updated_at'
    ];

    public function getRutaArchivoAttribute($module)
    {
        if (isset($this->path) && $this->path != '')
            return env('APP_URL') . $module .'/'. $this->id;
        return null;
    }

    public function cat_municipal_archivos()
    {
        return $this->hasOne(CatalogoMunicipalArchivos::class);
    }
}