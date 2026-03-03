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
        'sumaMontoUSD' => $sumaMontoUSD,
        'fecha' => today()->format('d/m/Y'),
    ]);
}

public function indexdate(request $request)
{

    request()->validate([
        'fecha' => 'required|date',
    ]);

    $sumaMontoBs = consulta::whereDate('created_at', $request->fecha)->sum('monto_bs');
    $sumaMontoUSD = consulta::whereDate('created_at', $request->fecha)->sum('monto_usd');

    return Inertia::render('consultas', [
        'consultas' => Consulta::with('paciente')
            ->whereDate('created_at', $request->fecha)
            ->paginate(),
        'sumaMontoBs' => $sumaMontoBs,
        'sumaMontoUSD' => $sumaMontoUSD,
        'fecha' => $request->fecha,
    ]);
}

public function index2 ()
{

    return Inertia::render('consultas2', [
        'consultas' => Consulta::with('paciente')
            ->whereDate('created_at', today())
            ->paginate(),
        'fecha' => today()->format('d/m/Y'),
    ]);
}

public function indexdate2(request $request)
{

    request()->validate([
        'fecha' => 'required|date',
    ]);

    return Inertia::render('consultas2', [
        'consultas' => Consulta::with('paciente')
            ->whereDate('created_at', $request->fecha)
            ->paginate(),
        'fecha' => $request->fecha,
    ]);


}
}