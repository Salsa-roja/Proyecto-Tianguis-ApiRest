<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Correo extends Model
{
    protected $table = 'correos';

    protected $primaryKey = 'id';

    protected $guarded = ['id'];
}