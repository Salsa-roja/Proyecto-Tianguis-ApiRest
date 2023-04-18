<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Services\ArchivosService;

class Empresa extends Model
{
    use HasFactory;

    protected $table = 'empresas';
    protected $primarykey = 'id';
    protected $fillable = [
        'nombre_comercial',
        'razon_social',
        'rfc',
        'No_de_alertas',
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
        'activo',
        'id_estatus',
        'telefono_rh'
    ];

    protected $appends = ['files'];
    public function getfilesAttribute()
    {
        $dwl = env('APP_URL') . '/dwl/empresas/';
        $files=[
            'constancia_sit_fiscal' => ['name' => 'Constancia de Situación Fiscal'],
            'licencia_municipal' => ['name' => 'Licencia Municipal'],
            'alta_patronal' => ['name' => 'Alta Patronal'],
        ];

        if (isset($this->constancia_sit_fiscal) && $this->constancia_sit_fiscal != ''){
            $files['constancia_sit_fiscal']['file'] = $dwl.$this->id.'/constancia_sit_fiscal';
            $files['constancia_sit_fiscal']['file64'] = ArchivosService::base64File('empresas',$this->constancia_sit_fiscal);
        }
        if (isset($this->licencia_municipal) && $this->licencia_municipal != ''){
            $files['licencia_municipal']['file'] = $dwl.$this->id.'/licencia_municipal';
            $files['licencia_municipal']['file64'] = ArchivosService::base64File('empresas',$this->licencia_municipal);
        }
        if (isset($this->alta_patronal) && $this->alta_patronal != ''){
            $files['alta_patronal']['file'] = $dwl.$this->id.'/alta_patronal';
            $files['alta_patronal']['file64'] = ArchivosService::base64File('empresas',$this->alta_patronal);
        }
        return $files;
    }

    public function usuario_empresa()
    {
        return $this->hasMany(UsuariosEmpresas::class,'id_empresa','id');
    }

    public function empresa_estatus()
    {
        return $this->belongsTo(estatus_empresa::class,'id_estatus','id');
    }
}
