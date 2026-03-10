<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class movimiento extends Model
{
    use HasFactory;

    protected $fillable = ['id','tipo_movimiento', 'moneda', 'concepto', 'monto', 'created_at', 'updated_at'];
}
