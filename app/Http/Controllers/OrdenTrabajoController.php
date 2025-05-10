<?php

namespace App\Http\Controllers;

use App\Models\OrdenTrabajo;
use App\Models\PuntoDeVenta;
use Illuminate\Http\Request;

class OrdenTrabajoController extends Controller
{
    public function create()
    {
        $pto_ventas = PuntoDeVenta::all();
        $next_orden_numero = OrdenTrabajo::max('Numero') + 1;

        return view('orden-trabajo.create', compact('pto_ventas', 'next_orden_numero'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'pto_venta_id' => 'required|exists:pto_venta,id',
            'Numero' => 'required|integer',
        ]);

        $numero = $validated['Numero'];

        if (OrdenTrabajo::where('Numero', $numero)->exists()) {
            $orden_trabajo = OrdenTrabajo::where('Numero', $numero)->first();
        } else {
            // $orden_trabajo = OrdenTrabajo::create($data);
        }

        return redirect()->route('orden-trabajo.show', $orden_trabajo);
    }

    public function show(OrdenTrabajo $orden_trabajo)
    {    
        $items_orden_trabajo = $orden_trabajo->itemsOrdenTrabajo;

        return view('orden-trabajo.show', compact('orden_trabajo', 'items_orden_trabajo'));
    }
}
