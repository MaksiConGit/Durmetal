<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMovimientoCuentaGastosRequest;
use App\Models\CuentaOtrosEgresos;
use App\Models\Material;
use App\Models\MovimientoCuentaGastos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OtrosEgresosController extends Controller
{
    public function otrosEgresos()
    {
        $cuentas_otros_egresos = CuentaOtrosEgresos::all();
        $movimientos_cuenta_gastos = MovimientoCuentaGastos::all();
        $materiales = Material::all();

        // dd($movimientos_cuenta_gastos);

        return view('otros-egresos.otros-egresos.index', compact('cuentas_otros_egresos', 'movimientos_cuenta_gastos', 'materiales'));
    }

    public function otrosEgresosCreate()
    {
        $cuentas_otros_egresos = CuentaOtrosEgresos::whereNull('IdCuentaOtrosEgresosPadre')
                                    ->orderBy('Nombre', 'asc')
                                    ->with('hijos')
                                    ->get();

        $movimientos_cuenta_gastos = MovimientoCuentaGastos::all();

        return view('otros-egresos.otros-egresos.create', compact('cuentas_otros_egresos', 'movimientos_cuenta_gastos'));
    }

    public function otrosEgresosStore(StoreMovimientoCuentaGastosRequest $request)
    {
        $data = $request->all();

        $data['FechaCreacion'] = now();
        $data['CreadoPor'] = Auth::id();
        $data['FechaActualizacion'] = now();
        $data['ActualizadoPor'] = Auth::id();
        $data['Activo'] = 1;

        MovimientoCuentaGastos::create($data);
    
        return redirect()->route('otros-egresos.otros-egresos.index');
    }

    public function otrosEgresosEdit(MovimientoCuentaGastos $movimiento_cuenta_gastos)
    {
        $cuentas_otros_egresos = CuentaOtrosEgresos::whereNull('IdCuentaOtrosEgresosPadre')
                                    ->orderBy('Nombre', 'asc')
                                    ->with('hijos')
                                    ->get();

        return view('otros-egresos.otros-egresos.edit', compact('movimiento_cuenta_gastos', 'cuentas_otros_egresos'));
    }

    public function otrosEgresosUpdate(StoreMovimientoCuentaGastosRequest $request, MovimientoCuentaGastos $movimiento_cuenta_gastos)
    {
        $data = $request->all();

        $data['FechaActualizacion'] = now();
        $data['ActualizadoPor'] = Auth::id();

        $movimiento_cuenta_gastos->update($data);
    
        return redirect()->route('otros-egresos.otros-egresos.index');
    }

    public function otrosEgresosDestroy(MovimientoCuentaGastos $movimiento_cuenta_gastos)
    {
        $movimiento_cuenta_gastos->delete();
    
        return redirect()->route('otros-egresos.otros-egresos.index');
    }
}
