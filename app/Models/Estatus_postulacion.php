<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Estatus_postulacion extends Model
{
    use HasFactory;

    protected $table = 'estatus_postulacion';
    protected $primarykey = 'id';
    protected $fillable = [
        'estatus'
    ];
}
