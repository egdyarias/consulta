<?php

namespace App\Http\Controllers;

use App\Models\consulta;
use App\Models\expediente;
use App\Models\paciente;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ExpedienteController extends Controller
{
    public function edit($id){
        return Inertia::render('expediente', [
            'paciente' => paciente::where('id', $id)->get(),
            'expediente' => expediente::where('paciente_id', $id)->get(),
            'consultas' => consulta::where('paciente_id', $id)->paginate(5),
        ]);
    }

    public function storeconsulta(Request $request)
    {
        $request->validate([
            'paciente_id' => 'required|integer',
            'motivo' => 'required|string|max:255',
            'monto_bs' => 'nullable|numeric',
            'monto_usd' => 'nullable|numeric',
        ]);

        consulta::create($request->all());

        return redirect()->route('expedientes.edit', $request->paciente_id);
    }

    public function updateconsulta(Request $request, $id)
    {
        $request->validate([
            'paciente_id' => 'required|integer',
            'motivo' => 'required|string|max:255',
            'monto_bs' => 'nullable|numeric',
            'monto_usd' => 'nullable|numeric',
        ]);

        $consulta = consulta::findOrFail($id);
        $consulta->update($request->all());

        return redirect()->route('expedientes.edit', $request->paciente_id);
    }

    public function destroyconsulta($id)
    {
        $consulta = consulta::findOrFail($id);
        $paciente_id = $consulta->paciente_id;
        $consulta->delete();

        return redirect()->route('expedientes.edit', $paciente_id);
    }

    public function updateexpediente(Request $request, $id)
    {
        $request->validate([
            'paciente_id' => 'required|integer',
            'antecedentes' => 'nullable|string',
            'examen_fisico' => 'nullable|string',
            'diagnostico' => 'nullable|string',
            'plan' => 'nullable|string',
            'pendiente' => 'nullable|string',
        ]);

        $expediente = expediente::findOrFail($id);
        $expediente->update($request->all());

        return redirect()->route('pacientes.index');
    }
}
