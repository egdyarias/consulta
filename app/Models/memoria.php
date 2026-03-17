<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class memoria extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['paciente_id', 'foto', 'descripcion', 'created_at'];

}
