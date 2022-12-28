<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Nivel_educativo extends Model
{
    use HasFactory;

    protected $table = 'nivel_educativo';
    protected $primarykey = 'id';
    protected $fillable = [
        'titulo'
    ];
}
