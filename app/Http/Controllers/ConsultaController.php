<?php

namespace App\Http\Controllers;

use App\Models\consulta;
use App\Models\paciente;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ConsultaController extends Controller
{
    public function index()
{

    $sumaMontoBs = consulta::whereDate('created_at', today())->sum('monto_bs');
    $sumaMontoUSD = consulta::whereDate('created_at', today())->sum('monto_usd');

    return Inertia::render('consultas', [
        'consultas' => Consulta::with('paciente')
            ->whereDate('created_at', today())
            ->paginate(),
        'sumaMontoBs' => $sumaMontoBs,
        'sumaMontoUSD' => $sumaMontoUSD
    ]);
}
}