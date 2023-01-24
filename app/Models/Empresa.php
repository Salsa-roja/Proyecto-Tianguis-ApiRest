<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Empresa extends Model
{
    use HasFactory;

    protected $table = 'empresas';
    protected $primarykey = 'id';
    protected $fillable = [
        'nombre_comercial',
        'razon_social',
        'rfc',
        'descripcion',
        'numero_empleados',
        'constancia_sit_fiscal',
        'licencia_municipal',
        'alta_patronal',
        'contr_discapacitados',
        'contr_antecedentes',
        'contr_adultos',
        'nombre_rh',
        'correo_rh',
        'telefono_rh'
    ];

    public function usuario_empresa()
    {
        return $this->hasMany(UsuariosEmpresas::class,'id_empresa','id');
    }
}
