<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Services\ArchivosService;

class Estatus_empresa extends Model
{
    use HasFactory;

    protected $table = 'estatus_empresa';
    protected $primarykey = 'id';
    protected $fillable = [
        'estatus'
    ];
}
