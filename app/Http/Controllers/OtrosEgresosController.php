<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCuentaOtrosEgresosRequest;
use App\Http\Requests\StoreMovimientoCuentaGastosRequest;
use App\Models\CuentaOtrosEgresos;
use App\Models\Material;
use App\Models\MovimientoCuentaGastos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OtrosEgresosController extends Controller
{
    // Otros Egresos
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


    // Cuentas
    public function cuentasIndex()
    {
        $cuentas_otros_egresos = CuentaOtrosEgresos::whereNull('IdCuentaOtrosEgresosPadre')
                                    ->orderBy('Nombre', 'asc')
                                    ->with('hijos')
                                    ->get();

        return view('otros-egresos.actualizaciones.cuentas.index', compact('cuentas_otros_egresos'));
    }

    public function cuentasCreate()
    {
        $cuentas_otros_egresos_padre = CuentaOtrosEgresos::whereNull('IdCuentaOtrosEgresosPadre')
                                    ->orderBy('Nombre', 'asc')
                                    ->get();

        return view('otros-egresos.actualizaciones.cuentas.create', compact('cuentas_otros_egresos_padre'));
    }

    public function cuentasStore(StoreCuentaOtrosEgresosRequest $request)
    {
        $data = $request->all();

        $data['FechaCreacion'] = now();
        $data['CreadoPor'] = Auth::id();
        $data['FechaActualizacion'] = now();
        $data['ActualizadoPor'] = Auth::id();
        $data['Activo'] = 1;

        CuentaOtrosEgresos::create($data);
    
        return redirect()->route('otros-egresos.actualizaciones.cuentas.index');
    }

    public function cuentasEdit(CuentaOtrosEgresos $cuenta_otros_egresos)
    {
        $cuentas_otros_egresos_padre = CuentaOtrosEgresos::whereNull('IdCuentaOtrosEgresosPadre')
                                    ->orderBy('Nombre', 'asc')
                                    ->get();

        return view('otros-egresos.actualizaciones.cuentas.edit', compact('cuentas_otros_egresos_padre', 'cuenta_otros_egresos'));
    }

    public function cuentasUpdate(StoreCuentaOtrosEgresosRequest $request, CuentaOtrosEgresos $cuenta_otros_egresos)
    {
        $data = $request->all();

        $data['FechaActualizacion'] = now();
        $data['ActualizadoPor'] = Auth::id();

        $cuenta_otros_egresos->update($data);
    
        return redirect()->route('otros-egresos.actualizaciones.cuentas.index');
    }

    public function cuentasDestroy(CuentaOtrosEgresos $cuenta_otros_egresos)
    {
        foreach ($cuenta_otros_egresos->hijos as $hijo) {

            foreach ($hijo->movimientos as $movimiento) {

                $movimiento->delete();
                
            }

            $hijo->delete();
        }

        foreach ($cuenta_otros_egresos->movimientos as $movimiento) {

            $movimiento->delete();
            
        }

        $cuenta_otros_egresos->delete();

        return redirect()->route('otros-egresos.actualizaciones.cuentas.index');
    }
}
