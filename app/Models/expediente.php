<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class expediente extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $fillable = ['id','paciente_id', 'antecedentes', 'examen_fisico', 'diagnostico', 'plan', 'pendiente', 'created_at', 'updated_at'];
}
