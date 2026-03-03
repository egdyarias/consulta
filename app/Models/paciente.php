<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class paciente extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['id','nombres', 'apellidos', 'cedula', 'fecha_nacimiento', 'direccion', 'telefono', 'referido'];
}
