<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrdenTrabajoRequest;
use App\Mail\OrdenCreadaMail;
use App\Models\Certificado;
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

    public function update(Request $request, OrdenTrabajo $orden_trabajo)
    {
        foreach ($request->items as $id => $data) {

            if ($id > 0) {

                unset($data['NroPlano']);

                $data['ActualizadoPor'] = Auth::id();
                $data['FechaActualizacion'] = now();

                $item = ItemOrdenTrabajo::find($id);
                $item->update($data);

                $certificado = Certificado::where('IdItemOrdenTrabajo', $item->id)->first();
                $nro_plano = $request->items[$id]['NroPlano'] ?? null;

                if (empty($nro_plano)) {

                    if ($certificado) {
                        $certificado->delete();
                    }

                } else {

                    if ($certificado) {
                        $certificado->update([
                            'Nombre' => $nro_plano,
                            'NroPlano' => $nro_plano,
                        ]);

                    } else {
                        Certificado::create([
                            'IdItemOrdenTrabajo' => $item->id,
                            'Nombre' => $nro_plano,
                            'NroPlano' => $nro_plano,
                            'Observaciones' => '',
                            'CantidadImpresiones' => 0,
                            'CantidadEnviosPorCorreo' => 0,
                            'Cantidad' => $item->Cantidad,
                            'IdUsuario' => Auth::id(),
                            'Predeterminado' => 1,
                        ]);
                    }
                }

            } else {

                if (!$data['Descripcion']) {
                    $data['Descripcion'] = "SIN DESCRIPCION";
                }

                $data['ActualizadoPor'] = Auth::id();
                $data['FechaActualizacion'] = now();
                $data['CreadoPor'] = Auth::id();
                $data['FechaCreacion'] = now();
                $data['Activo'] = 1;
                $data['Estado'] = 'PENDIENTE';
                $data['NroDeposito'] = 0;
                $data['CodigoComplejidad'] = 0;
                $data['Coeficiente'] = '0';
                $data['PrecioUnitario'] = '0';
                $data['Total'] = '0';
                $data['AfectaPlanillaTurno'] = 0;
                $data['ControlarStock'] = 0;
                $data['CertificadoEmitido'] = 0;
                $data['CantidadCertificadosImpresos'] = 0;
                $data['CantidadCertificadosEnviadosPorCorreo'] = 0;
                $data['CantidadProgramaciones'] = 0;
                $data['ConNotaEnvio'] = 0;
                $data['IDEstadoConNotaEnvio'] = 0;
                $data['IDIdOrdenTrabajoIdMaterialIdTratamientoCodigoComplejidadEstado'] = 0;

                $item = $orden_trabajo->itemsOrdenTrabajo()->create($data);

                if (!empty($data['NroPlano'])) {
                    Certificado::create([
                        'IdItemOrdenTrabajo' => $item->id,
                        'Nombre' => $data['NroPlano'],
                        'NroPlano' => $data['NroPlano'],
                        'Observaciones' => '',
                        'CantidadImpresiones' => 0,
                        'CantidadEnviosPorCorreo' => 0,
                        'Cantidad' => $item->Cantidad,
                        'IdUsuario' => Auth::id(),
                        'Predeterminado' => 1,
                    ]);
                }

            }
        }

        $data = $request->except('items');
    
        $data['ActualizadoPor'] = Auth::id();
        $data['FechaActualizacion'] = now();

        $data['Letra'] = 'X';
        $data['NumeroCompleto'] = 'OT X 0001-000' . $orden_trabajo->Numero;
        $data['FechaVencimiento'] = now();
        $data['AfectarPlanillaTurno'] = 1;
        $data['CondicionPrecios'] = 'A';
        $data['Estado'] = 'PENDIENTE';

        $cliente = Client::find($data['IdCliente']);

        if ($cliente) {
            $data['RazonSocial'] = $cliente->Nombre;
            $data['IdCondicionIva'] = $cliente->IdCondicionIVA;
            $data['TipoDocumentoCliente'] = $cliente->TipoDocumento;
            $data['NumeroDocumentoCliente'] = $cliente->NroDocumento;
            $data['Direccion'] = $cliente->Domicilio;
            $data['Localidad'] = $cliente->localidad->Nombre;
            $data['Provincia'] = $cliente->localidad->provincia->Nombre;
        }
        else{
            $data['RazonSocial'] = null;
            $data['IdCondicionIva'] = null;
            $data['TipoDocumentoCliente'] = null;
            $data['NumeroDocumentoCliente'] = null;
            $data['Direccion'] = null;
            $data['Localidad'] = null;
            $data['Provincia'] = null; 
        }

        $data['Total'] = 0;
        $data['NumeroTurno'] = 0;
        $data['ReferenciaTurno'] = 0;
        $data['AjusteCtaCtePlanillaTurno'] = 0;
        $data['PuntoVentaNumero'] = 1;
        $data['IdClienteEstado'] = 1;
        $data['IdClienteFechaEmisionPuntoVentaNumero'] = 1;
        $data['CantidadImpresiones'] = 0;
        $data['CantidadEnviosPorCorreo'] = 0;

        $orden_trabajo->update($data);
    
        return redirect()->route('orden-trabajo.edit', $orden_trabajo);
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
