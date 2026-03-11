<?php

namespace App\Http\Controllers;

use App\Models\consulta;
use App\Models\expediente;
use App\Models\paciente;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PacienteController extends Controller
{

    public function dashboard(){

    $hoy = Carbon::today();
    $resultado = [];
    
    for ($i = 4; $i >= 0; $i--) {
        $fecha = $hoy->copy()->subDays($i);
        $fechaStr = $fecha->format('Y-m-d');

        $total = consulta::whereDate('created_at', $fecha)->count();
        
        $resultado[] = $total;
    }
    

    return Inertia::render('Dashboard', [
        'pacientes' => paciente::count(),
        'consultas' => consulta::count(),
        'numConsultas' => $resultado
    ]);

    }

    public function index(Request $request)
    {
        $query = paciente::query();

        $search = strtoupper($request->input('search'));
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('cedula', 'like', "%{$search}%")
                  ->orWhere('nombres', 'like', "%{$search}%")
                  ->orWhere('apellidos', 'like', "%{$search}%");
            });
        }

        $pacientes = $query->paginate()->appends(['search' => $search]);

        return Inertia::render('pacientes', [
            'pacientes' => $pacientes,
            'search' => $search,
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
