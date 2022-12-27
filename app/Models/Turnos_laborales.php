<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Turnos_laborales extends Model
{
    use HasFactory;

    protected $table = 'turnos_laborales';
    protected $primarykey = 'id';
    protected $fillable = [
        'turnos'
    ];
}
