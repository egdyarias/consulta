<?php

namespace App\Http\Controllers;

use App\Models\consulta;
use App\Models\movimiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ConsolidadoController extends Controller
{

    public function consolidado (){

        $consolidado = [];

        $consultasGeneral = consulta::where('monto_bs', '>', 0)
            ->get();
        $sumaConsultasBsGeneral = $consultasGeneral->sum('monto_bs');
        $movimientosGeneral = movimiento::where('moneda', 'BS')
            ->get();
        $movimientoManual = (object) [
            'id' => 0,
            'tipo_movimiento' => 'Deposito',
            'moneda' => 'BS',
            'concepto' => 'Suma de Consultas del Día',
            'monto' => $sumaConsultasBsGeneral,
            'created_at' => today()
        ];
        $movimientosGeneral->push($movimientoManual);

        $consolidadoBS = $movimientosGeneral->sortBy('created_at')->reduce(function ($carry, $movimiento) {
            $tipo = $movimiento->tipo_movimiento;
            $monto = $movimiento->monto;

            switch ($tipo) {
                case 'deposito':
                case 'Deposito':
                case 'DEPOSITO':
                    $carry += $monto;
                    break;

                case 'retiro':
                case 'Retiro':
                case 'RETIRO':
                    $carry -= $monto;
                    break;
            }

            return $carry;
        }, 0); 

        $consolidado[] = $consolidadoBS;

        $consultasGeneral = consulta::where('monto_usd', '>', 0)
            ->get();
        $sumaConsultasUSDGeneral = $consultasGeneral->sum('monto_usd');
        $movimientosGeneral = movimiento::where('moneda', 'USD')
            ->get();
        $movimientoManual = (object) [
            'id' => 0,
            'tipo_movimiento' => 'Deposito',
            'moneda' => 'USD',
            'concepto' => 'Suma de Consultas del Día',
            'monto' => $sumaConsultasUSDGeneral,
            'created_at' => today()
        ];
        $movimientosGeneral->push($movimientoManual);

        $consolidadoUSD = $movimientosGeneral->sortBy('created_at')->reduce(function ($carry, $movimiento) {
            $tipo = $movimiento->tipo_movimiento;
            $monto = $movimiento->monto;

            switch ($tipo) {
                case 'deposito':
                case 'Deposito':
                case 'DEPOSITO':
                    $carry += $monto;
                    break;

                case 'retiro':
                case 'Retiro':
                case 'RETIRO':
                    $carry -= $monto;
                    break;
            }

            return $carry;
        }, 0); 

        $consolidado[] = $consolidadoUSD;


        return Inertia::render('consolidado', [
            'consolidados' => $consolidado,
        ]);

    }
    public function verify(Request $request)
    {
        $request->validate([
            'password' => 'required|string',
        ]);

        $user = Auth::user();

        if (!$user || !Hash::check($request->input('password'), $user->password)) {
            return response()->json(['password' => 'Contraseña incorrecta.'], 422);
        }

        return response()->json([], 200);
    }
}
