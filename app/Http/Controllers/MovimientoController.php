<?php

namespace App\Http\Controllers;

use App\Models\consulta;
use App\Models\movimiento;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MovimientoController extends Controller
{
    public function indexBS()
    {

        $consultasDelDia = consulta::whereDate('created_at', today())
            ->where('monto_bs', '>', 0)
            ->get();
        $sumaConsultasBs = $consultasDelDia->sum('monto_bs');
        $ultimaConsulta = $consultasDelDia->last();

        $movimientos = movimiento::whereDate('created_at', today())
            ->where('moneda', 'BS')->orderBy('created_at', 'desc')
            ->get();

        $movimientoManual = (object) [
            'id' => 0,
            'tipo_movimiento' => 'Deposito',
            'moneda' => 'BS',
            'concepto' => 'Suma de Consultas del Día',
            'monto' => $sumaConsultasBs,
            'created_at' => $ultimaConsulta ? $ultimaConsulta->created_at : today()
        ];

        $movimientos->push($movimientoManual);


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

        $consolidado = $movimientosGeneral->sortBy('created_at')->reduce(function ($carry, $movimiento) {
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




        return Inertia::render('movimientoBS', [
            'movimientos' => $movimientos,
            'fecha' => today()->format('d/m/Y'),
            'consolidado' => $consolidado,
        ]);
    }

    public function indexBSdate(Request $request)
    {
        
        request()->validate([
        'fecha' => 'required|date',
        ]);

        $consultasDelDia = consulta::whereDate('created_at', $request->fecha)
            ->where('monto_bs', '>', 0)
            ->get();
        $sumaConsultasBs = $consultasDelDia->sum('monto_bs');
        $ultimaConsulta = $consultasDelDia->last();

        $movimientos = movimiento::whereDate('created_at', $request->fecha)
            ->where('moneda', 'BS')->orderBy('created_at', 'desc')
            ->get();

        $movimientoManual = (object) [
            'id' => 0,
            'tipo_movimiento' => 'Deposito',
            'moneda' => 'BS',
            'concepto' => 'Suma de Consultas del Día',
            'monto' => $sumaConsultasBs,
            'created_at' => $ultimaConsulta ? $ultimaConsulta->created_at : $request->fecha
        ];

        $movimientos->push($movimientoManual);


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
            'created_at' => $request->fecha
        ];
        $movimientosGeneral->push($movimientoManual);

        $consolidado = $movimientosGeneral->sortBy('created_at')->reduce(function ($carry, $movimiento) {
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


        return Inertia::render('movimientoBS', [
            'movimientos' => $movimientos,
            'fecha' => $request->fecha,
            'consolidado' => $consolidado,
        ]);
    }

    public function indexUSD()
    {

        $consultasDelDia = consulta::whereDate('created_at', today())
            ->where('monto_usd', '>', 0)
            ->get();
        $sumaConsultasUSD = $consultasDelDia->sum('monto_usd');
        $ultimaConsulta = $consultasDelDia->last();

        $movimientos = movimiento::whereDate('created_at', today())
            ->where('moneda', 'USD')->orderBy('created_at', 'desc')
            ->get();

        $movimientoManual = (object) [
            'id' => 0,
            'tipo_movimiento' => 'Deposito',
            'moneda' => 'USD',
            'concepto' => 'Suma de Consultas del Día',
            'monto' => $sumaConsultasUSD,
            'created_at' => $ultimaConsulta ? $ultimaConsulta->created_at : today()
        ];

        $movimientos->push($movimientoManual);


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

        $consolidado = $movimientosGeneral->sortBy('created_at')->reduce(function ($carry, $movimiento) {
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




        return Inertia::render('movimientoUSD', [
            'movimientos' => $movimientos,
            'fecha' => today()->format('d/m/Y'),
            'consolidado' => $consolidado,
        ]);
    }

    public function indexUSDdate(Request $request)
    {
        
        request()->validate([
        'fecha' => 'required|date',
        ]);

        $consultasDelDia = consulta::whereDate('created_at', $request->fecha)
            ->where('monto_usd', '>', 0)
            ->get();
        $sumaConsultasUSD = $consultasDelDia->sum('monto_usd');
        $ultimaConsulta = $consultasDelDia->last();

        $movimientos = movimiento::whereDate('created_at', $request->fecha)
            ->where('moneda', 'USD')->orderBy('created_at', 'desc')
            ->get();

        $movimientoManual = (object) [
            'id' => 0,
            'tipo_movimiento' => 'Deposito',
            'moneda' => 'USD',
            'concepto' => 'Suma de Consultas del Día',
            'monto' => $sumaConsultasUSD,
            'created_at' => $ultimaConsulta ? $ultimaConsulta->created_at : $request->fecha
        ];

        $movimientos->push($movimientoManual);


        $consultasGeneral = consulta::where('monto_usd', '>', 0)
            ->get();
        $sumaConsultasUSDGeneral = $consultasGeneral->sum('monto_usd');
        $movimientosGeneral = movimiento::where('moneda', 'USD')
            ->get();
        $movimientoManual = (object) [
            'id' => 0,
            'tipo_movimiento' => 'Deposito',
            'moneda' => 'BS',
            'concepto' => 'Suma de Consultas del Día',
            'monto' => $sumaConsultasUSDGeneral,
            'created_at' => $request->fecha
        ];
        $movimientosGeneral->push($movimientoManual);

        $consolidado = $movimientosGeneral->sortBy('created_at')->reduce(function ($carry, $movimiento) {
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


        return Inertia::render('movimientoUSD', [
            'movimientos' => $movimientos,
            'fecha' => $request->fecha,
            'consolidado' => $consolidado,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'tipo_movimiento' => 'required|string|max:30',
            'concepto' => 'required|string|max:30',
            'moneda' => 'required|string|max:10',
            'monto' => 'required|numeric|max:10',
        ]);

        movimiento::create($request->all());

        return back();
    }

    public function destroy($id)
    {
        $movimiento = movimiento::findOrFail($id);
        $movimiento->delete();
        return back();
    }
}
