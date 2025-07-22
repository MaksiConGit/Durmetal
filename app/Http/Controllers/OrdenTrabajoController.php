<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrdenTrabajoRequest;
use App\Mail\OrdenCreadaMail;
use App\Models\Client;
use App\Models\ItemOrdenTrabajo;
use App\Models\OrdenTrabajo;
use App\Models\PuntoDeVenta;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class OrdenTrabajoController extends Controller
{
    public function create()
    {
        $pto_ventas = PuntoDeVenta::all();
        $next_orden_numero = OrdenTrabajo::max('Numero') + 1;

        return view('produccion.orden-trabajo.create', compact('pto_ventas', 'next_orden_numero'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'pto_venta_id' => 'required|exists:pto_venta,id',
            'Numero' => 'required|integer',
        ]);

        $numero = $validated['Numero'];

        $data = $request->all();

        if (OrdenTrabajo::where('Numero', $numero)->exists()) {
            $orden_trabajo = OrdenTrabajo::where('Numero', $numero)->first();
            $orden_trabajo->update([
                'PuntoVenta' => $data['pto_venta_id'],
            ]);
        }
        else {
            $orden_trabajo = OrdenTrabajo::create([
                    'PuntoVenta' => $data['pto_venta_id'],
                    'Numero' => $data['Numero'],
                ]);
        }

        return redirect()->route('orden-trabajo.edit', $orden_trabajo);
    }

    public function show(OrdenTrabajo $orden_trabajo)
    {    
        $items_orden_trabajo = $orden_trabajo->itemsOrdenTrabajo;

        return view('produccion.orden-trabajo.show', compact('orden_trabajo', 'items_orden_trabajo'));
    }

    public function edit(OrdenTrabajo $orden_trabajo, Request $request)
    {    
        $items_orden_trabajo = $orden_trabajo->itemsOrdenTrabajo;

        $pto_ventas = PuntoDeVenta::all();
        $clientes = Client::all();

        $punto_venta = $request->query('PuntoVenta');
        $id_cliente = $request->query('IdCliente');
        $numero = $request->query('Numero');
        $fecha_emision = $request->query('FechaEmision');
        $numero_remito_cliente = $request->query('NumeroRemitoCliente');

        if ($id_cliente) {
            $cliente = Client::find($id_cliente);
        } else {
            $cliente = $orden_trabajo->cliente;
        }

        if ($cliente) {
            $selectedUser = [
                'id' => $cliente->id,
                'text' => "$cliente->id | $cliente->Nombre"
            ];
        } else {
            $selectedUser = null;
        }

        session()->put([
            'PuntoVenta' => $punto_venta ?? ($orden_trabajo->PuntoVenta ?? ''),
            'IdCliente' => $id_cliente ?? ($orden_trabajo->IdCliente ?? ($cliente->id ?? '')),
            'Numero' => $numero ?? ($orden_trabajo->Numero ?? ''),
            'FechaEmision' => $fecha_emision ?? ($orden_trabajo->FechaEmision ?? now()->toDateString()),
            'NumeroRemitoCliente' => $numero_remito_cliente ?? ($orden_trabajo->NumeroRemitoCliente ?? ''),
        ]);

        return view('produccion.orden-trabajo.edit', compact('orden_trabajo', 'items_orden_trabajo', 'clientes', 'pto_ventas', 'selectedUser'));
    }

    public function update(StoreOrdenTrabajoRequest $request, OrdenTrabajo $orden_trabajo)
    {
        $data = $request->all();

        $user_id = Auth::id();
    
        $data['ActualizadoPor'] = $user_id;
        $data['FechaActualizacion'] = now();

        $data['Letra'] = 'X';
        $data['NumeroCompleto'] = 'OT X 0001-000';
        $data['FechaVencimiento'] = now();
        $data['AfectarPlanillaTurno'] = 1;
        $data['CondicionPrecios'] = 1;

        $cliente = Client::find($data['IdCliente']);

        $data['RazonSocial'] = $cliente->Nombre;
        $data['IdCondicionIva'] = 1;
        $data['TipoDocumentoCliente'] = 1;
        $data['NumeroDocumentoCliente'] = 1;
        $data['Direccion'] = 1;
        $data['Localidad'] = 1;
        $data['Provincia'] = 1;
        $data['Total'] = 1;
        $data['Observaciones'] = null;

        $data['NumeroTurno'] = 1;
        $data['ReferenciaTurno'] = 1;
        $data['AjusteCtaCtePlanillaTurno'] = 1;
        $data['PuntoVentaNumero'] = 1;
        $data['IdClienteEstado'] = 1;
        $data['IdClienteFechaEmisionPuntoVentaNumero'] = 1;
        $data['CantidadImpresiones'] = 1;
        $data['CantidadEnviosPorCorreo'] = 1;
        $data['Archivado'] = 1;

        $orden_trabajo->update($data);
    
        return redirect()->route('orden-trabajo.show', $orden_trabajo);
    }


    public function mail()
    {
        // $user_id = Auth::id();
        Mail::to('asd@asd.com')->send(new OrdenCreadaMail);
        // $items_orden_trabajo = $orden_trabajo->itemsOrdenTrabajo;

        return redirect()->route('orden-trabajo.show', 1);
    }

    public function destroy(OrdenTrabajo $orden_trabajo)
    {
        $cliente = $orden_trabajo->cliente;

        foreach ($orden_trabajo->itemsOrdenTrabajo as $item_orden_trabajo) {

            foreach ($item_orden_trabajo->programacion as $programacion) {

                $programacion->delete();

            }

            $item_orden_trabajo->delete();

        }

        $orden_trabajo->delete();
    
        return redirect()->route('ventas.ficha-del-cliente.show', $cliente);
    }
}
