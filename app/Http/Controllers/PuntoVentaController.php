<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePuntoVentaRequest;
use App\Models\PuntoDeVenta;
use Illuminate\Http\Request;

class PuntoVentaController extends Controller
{
    public function index()
    {
        $pto_ventas = PuntoDeVenta::all();

        return view('sistema.configuracion.puntos-de-ventas.index', compact('pto_ventas'));
    }

    public function create()
    {
        return view('sistema.configuracion.puntos-de-ventas.create');
    }

    public function store(StorePuntoVentaRequest $request)
    {
        $data = $request->all();

        PuntoDeVenta::create($data);
    
        return redirect()->route('sistema.configuracion.puntos-de-ventas.index');
    }

    public function edit(PuntoDeVenta $pto_venta)
    {
        return view('sistema.configuracion.puntos-de-ventas.edit', compact('pto_venta'));
    }

    public function update(StorePuntoVentaRequest $request, PuntoDeVenta $pto_venta)
    {
        $data = $request->all();

        $pto_venta->update($data);
    
        return redirect()->route('sistema.configuracion.puntos-de-ventas.index');
    }

    public function destroy(PuntoDeVenta $pto_venta)
    {
        $pto_venta->delete();
    
        return redirect()->route('sistema.configuracion.puntos-de-ventas.index');
    }
}
