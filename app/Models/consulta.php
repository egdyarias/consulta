<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class consulta extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function paciente()
{
    return $this->belongsTo(paciente::class, 'paciente_id');
}

    protected $fillable = ['id','paciente_id', 'motivo', 'monto_bs', 'monto_usd', 'created_at', 'updated_at'];
}
