<?php

namespace App\Http\Controllers;

use App\Models\expediente;
use App\Models\paciente;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PacienteController extends Controller
{
    public function index()
    {
        return Inertia::render('pacientes', [
            'pacientes' => paciente::paginate()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombres' => 'required|string|max:30',
            'apellidos' => 'required|string|max:30',
            'cedula' => 'required|string|max:10',
            'fecha_nacimiento' => 'required|date',
            'direccion' => 'nullable|string|max:100',
            'telefono' => 'nullable|string|max:15',
            'referido' => 'nullable|string|max:30',
        ]);

        paciente::create($request->all());

        expediente::create([
            'paciente_id' => paciente::latest()->first()->id,
        ]);

        return redirect()->route('pacientes.index');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombres' => 'required|string|max:30',
            'apellidos' => 'required|string|max:30',
            'cedula' => 'required|string|max:10',
            'fecha_nacimiento' => 'required|date',
            'direccion' => 'nullable|string|max:100',
            'telefono' => 'nullable|string|max:15',
            'referido' => 'nullable|string|max:30',
        ]);

        $paciente = paciente::findOrFail($id);
        $paciente->update($request->all());

        return redirect()->route('pacientes.index');
    }

    public function destroy($id)
    {
        $paciente = paciente::findOrFail($id);
        $paciente->delete();

        expediente::where('paciente_id', $id)->delete();

        return redirect()->route('pacientes.index');
    }

}
