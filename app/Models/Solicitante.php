<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Usuarios;
use App\Models\VacanteSolicitante;
use App\Services\ArchivosService;

class Solicitante extends Model
{
    use HasFactory;

    protected $table = 'solicitantes';
    protected $primarykey = 'id';
    protected $fillable = [
        'nombre',
        'id_usuario',
        'ape_paterno',
        'ape_materno',
        'edad',
        'curp',
        'telefono',
        'email',
        'pass',
        'c_numero',
        'c_postal',
        'id_colonia',
        'ciudad',
        'descr_prof',
        'sueldo_deseado',
        'area_desempeno',
        'posicion_interes',
        'industria_interes',
        'habilidades',
        'experiencia_profesional',
        'formacion_educativa',
        'disc_lenguaje',
        'disc_motriz',
        'disc_visual',
        'disc_mental',
        'disc_auditiva',
        'lugar_atencion',
        'curriculum',
        'id_nivel_educativo'
    ];

    protected $appends = ['file', 'file64'];
    public function getfileAttribute()
    {
        if (isset($this->curriculum) && $this->curriculum != '')
            return env('APP_URL') . '/dwl/solicitantes/' . $this->id;
    }


    public function getfile64Attribute()
    {
        if (isset($this->curriculum) && $this->curriculum != '')
            return ArchivosService::base64File('solicitantes', $this->curriculum);
    }

    public function rel_usuarios()
    {
        return $this->belongsTo(Usuarios::class, 'id_usuario', 'id');
    }

    public function rel_vacante_solicitante()
    {
        return $this->hasMany(VacanteSolicitante::class, 'id_solicitante', 'id');
    }
    public function tabla_nivel_educativo()
    {
        return $this->belongsTo(Nivel_educativo::class, 'id_nivel_educativo');
    }
}
