<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCuentaGastosRequest;
use App\Http\Requests\StoreProveedorRequest;
use App\Models\City;
use App\Models\CuentaGastos;
use App\Models\CuentaOtrosEgresos;
use App\Models\IvaCondition;
use App\Models\Proveedor;
use App\Models\Province;
use App\Models\RetencionIIBB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComprasController extends Controller
{
    // Otros Egresos
    public function proveedoresIndex()
    {
        $proveedores = Proveedor::all();
        $cuentas_otros_egresos = CuentaOtrosEgresos::all();


        return view('compras.actualizaciones.proveedores.index', compact('proveedores', 'cuentas_otros_egresos'));
    }

    public function proveedoresCreate()
    {
        $localidades = City::all();
        $provincias = Province::all();
        $condiciones_IVA = IvaCondition::all();
        $retenciones_IIBB = RetencionIIBB::all();
        $cuentas_de_gastos = CuentaGastos::all();
        $next_id = Proveedor::max('id') + 1;

        return view('compras.actualizaciones.proveedores.create', compact('localidades', 'provincias', 'condiciones_IVA', 'retenciones_IIBB', 'cuentas_de_gastos', 'next_id'));
    }

    public function proveedoresStore(StoreProveedorRequest $request)
    {
        $data = $request->except('emails');

        $localidad = City::find($request->IdLocalidad);
        $provincia = $localidad->provincia;

        $data['Localidad'] = $localidad->Nombre;
        $data['Provincia'] = $provincia->Nombre;
        $data['SaldoSistemaAnterior'] = 0;
        $data['FechaCreacion'] = now();
        $data['CreadoPor'] = Auth::id();
        $data['FechaActualizacion'] = now();
        $data['ActualizadoPor'] = Auth::id();
        $data['Activo'] = 1;

        $proveedor = Proveedor::create($data);

        foreach ($request->emails as $email) {
            if ($email) {
                $proveedor->emails()->create([
                    'IdProveedor' => $proveedor->id,
                    'Email' => $email,
                    'FechaCreacion' => now(),
                    'CreadoPor' => Auth::id(),
                    'FechaActualizacion' => now(),
                    'ActualizadoPor' => Auth::id(),
                    'Activo' => 1,
                    'IdProveedorEmail' => $proveedor->id . ',' . $email,
                ]);
            }
        }    
        return redirect()->route('compras.actualizaciones.proveedores.index');
    }

    public function proveedoresEdit(Proveedor $proveedor)
    {
        $localidades = City::all();
        $provincias = Province::all();
        $condiciones_IVA = IvaCondition::all();
        $retenciones_IIBB = RetencionIIBB::all();
        $cuentas_de_gastos = CuentaGastos::all();

        return view('compras.actualizaciones.proveedores.edit', compact('proveedor', 'localidades', 'provincias', 'condiciones_IVA', 'retenciones_IIBB', 'cuentas_de_gastos'));
    }

    public function proveedoresUpdate(StoreProveedorRequest $request, Proveedor $proveedor)
    {
        $data = $request->except('emails');

        $localidad = City::find($request->IdLocalidad);
        $provincia = $localidad->provincia;

        $data['Localidad'] = $localidad->Nombre;
        $data['Provincia'] = $provincia->Nombre;
        $data['FechaActualizacion'] = now();
        $data['ActualizadoPor'] = Auth::id();

        $proveedor->update($data);

        $proveedor->emails()->delete();
    
        foreach ($request->emails as $email) {
            if ($email) {
                $proveedor->emails()->create([
                    'IdProveedor' => $proveedor->id,
                    'Email' => $email,
                    'FechaCreacion' => now(),
                    'CreadoPor' => Auth::id(),
                    'FechaActualizacion' => now(),
                    'ActualizadoPor' => Auth::id(),
                    'Activo' => 1,
                    'IdProveedorEmail' => $proveedor->id . ',' . $email,
                ]);
            }
        }    
    
        return redirect()->route('compras.actualizaciones.proveedores.index');
    }

    public function proveedoresDestroy(Proveedor $proveedor)
    {
        $proveedor->emails()->delete();

        $proveedor->delete();
    
        return redirect()->route('compras.actualizaciones.proveedores.index');
    }

    // Cuentas de Gastos
    public function cuentaDeGastosIndex()
    {
        $cuentas_de_gastos = CuentaGastos::all();

        return view('compras.actualizaciones.cuentas-de-gastos.index', compact('cuentas_de_gastos'));
    }

    public function cuentaDeGastosCreate()
    {
        return view('compras.actualizaciones.cuentas-de-gastos.create');
    }

    public function cuentaDeGastosStore(StoreCuentaGastosRequest $request)
    {
        $data = $request->all();

        $data['FechaCreacion'] = now();
        $data['CreadoPor'] = Auth::id();
        $data['FechaActualizacion'] = now();
        $data['ActualizadoPor'] = Auth::id();
        $data['Activo'] = 1;
        $data['Archivado'] = 0;

        CuentaGastos::create($data);

        return redirect()->route('compras.actualizaciones.cuentas-de-gastos.index');
    }

    public function cuentaDeGastosEdit(CuentaGastos $cuenta_de_gastos)
    {
        return view('compras.actualizaciones.cuentas-de-gastos.edit', compact('cuenta_de_gastos'));
    }

    public function cuentaDeGastosUpdate(StoreCuentaGastosRequest $request, CuentaGastos $cuenta_de_gastos)
    {
        $data = $request->all();

        $data['FechaActualizacion'] = now();
        $data['ActualizadoPor'] = Auth::id();

        $cuenta_de_gastos->update($data);

        return redirect()->route('compras.actualizaciones.cuentas-de-gastos.index');
    }

    public function cuentaDeGastosDestroy(CuentaGastos $cuenta_de_gastos)
    {
        foreach ($cuenta_de_gastos->proveedores as $proveedor) {
            $proveedor->update([
                'IdCuentaGastos' => null
            ]);
        }

        $cuenta_de_gastos->delete();
    
        return redirect()->route('compras.actualizaciones.cuentas-de-gastos.index');
    }
}
