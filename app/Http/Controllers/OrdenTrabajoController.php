<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrdenTrabajoRequest;
use App\Mail\OrdenCreadaMail;
use App\Models\Certificado;
use App\Models\Client;
use App\Models\ConfiguracionGlobal;
use App\Models\Email;
use App\Models\ItemOrdenTrabajo;
use App\Models\OrdenTrabajo;
use App\Models\PuntoDeVenta;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
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
        $pto_ventas = PuntoDeVenta::all();

        $items_orden_trabajo = $orden_trabajo->itemsOrdenTrabajo;

        return view('produccion.orden-trabajo.show', compact('orden_trabajo', 'items_orden_trabajo', 'pto_ventas'));
    }

    public function ordenPDF(OrdenTrabajo $orden_trabajo)
    {
        $orden_trabajo->update([
            'CantidadImpresiones' => $orden_trabajo->CantidadImpresiones + 1
        ]);

        $pdf = Pdf::loadView('produccion.orden-trabajo.orden-pdf', [
            'orden_trabajo' => $orden_trabajo,
        ])->setPaper('A4');

        return $pdf->stream('produccion.orden-trabajo.orden-pdf');
    }

    public function historialPDF(OrdenTrabajo $orden_trabajo)
    {
        $orden_trabajo->update([
            'CantidadImpresiones' => $orden_trabajo->CantidadImpresiones + 1
        ]);

        $configuracion_global = ConfiguracionGlobal::first();

        $pdf = Pdf::loadView('produccion.orden-trabajo.historial-pdf', [
            'orden_trabajo' => $orden_trabajo,
            'configuracion_global' => $configuracion_global,
        ])->setPaper('A4');

        return $pdf->stream('produccion.orden-trabajo.historial-pdf');
    }

    public function tarjetasPDF(OrdenTrabajo $orden_trabajo)
    {
        $orden_trabajo->update([
            'CantidadImpresiones' => $orden_trabajo->CantidadImpresiones + 1
        ]);

        $pdf = Pdf::loadView('produccion.orden-trabajo.tarjetas-pdf', [
            'orden_trabajo' => $orden_trabajo,
        ])->setPaper('A5', 'landscape');

        return $pdf->stream('produccion.orden-trabajos.tarjetas-pdf');
    }

    public function ordenMail(OrdenTrabajo $orden_trabajo, Request $request)
    {
        // 🔹 Obtener emails
        $ids = explode(',', $request->Emails ?? '');

        if (!$ids || count($ids) === 0 || $ids[0] === '') {
            // Emails del cliente (ajustá la relación si cambia)
            $emails = $orden_trabajo
                ->cliente
                ->emails
                ->pluck('Email')
                ->toArray();
        } else {
            $emails = Email::whereIn('Id', $ids)->pluck('Email')->toArray();
        }

        // dd($emails);

        // 🔹 Contador de envíos por mail
        $orden_trabajo->CantidadEnviosPorCorreo =
            ($orden_trabajo->CantidadEnviosPorCorreo ?? 0) + 1;
        $orden_trabajo->save();

        // 🔹 Generar el MISMO PDF que el método pdf()
        $pdf = Pdf::loadView('produccion.orden-trabajo.orden-pdf', [
            'orden_trabajo' => $orden_trabajo,
        ])->setPaper('A4');

        // 🔹 Enviar mail

        Mail::send('emails.orden', [
            'orden_trabajo' => $orden_trabajo,
        ], function ($message) use ($emails, $pdf, $orden_trabajo) {

            $message->from('durmetal@durmetal.com.ar', 'durmetal');

            $message->to($emails)
                ->subject('ORDEN DE TRABAJO ' . $orden_trabajo->NumeroCompleto)
                ->attachData(
                    $pdf->output(),
                    'orden_trabajo' . $orden_trabajo->id . '.pdf',
                    ['mime' => 'application/pdf']
                );
        });

        return back()->with('success', 'Certificado enviado por correo correctamente.');
    }

    public function historialMail(OrdenTrabajo $orden_trabajo, Request $request)
    {
        // 🔹 Obtener la PRIMER configuración global
        $configuracion_global = ConfiguracionGlobal::first();

        // 🔹 Obtener emails
        $ids = explode(',', $request->Emails ?? '');

        if (!$ids || count($ids) === 0 || $ids[0] === '') {

            $emails = $orden_trabajo
                ->cliente
                ->emails
                ->pluck('Email')
                ->toArray();

        } else {

            $emails = Email::whereIn('Id', $ids)
                ->pluck('Email')
                ->toArray();
        }

        // 🔹 Contador
        $orden_trabajo->CantidadEnviosPorCorreo =
            ($orden_trabajo->CantidadEnviosPorCorreo ?? 0) + 1;
        $orden_trabajo->save();

        // 🔹 PDF
        $configuracion_global = ConfiguracionGlobal::first();

        $pdf = Pdf::loadView('produccion.orden-trabajo.historial-pdf', [
            'orden_trabajo' => $orden_trabajo,
            'configuracion_global' => $configuracion_global,
        ])->setPaper('A4');

        // 🔹 Mail
        Mail::send('emails.historial', [
            'orden_trabajo' => $orden_trabajo,
            'configuracion_global' => $configuracion_global   // 🔥 ESTO ES LO IMPORTANTE
        ], function ($message) use ($emails, $pdf, $orden_trabajo) {

            $message->from('durmetal@durmetal.com.ar', 'durmetal');

            $message->to($emails)
                ->subject('HISTORIAL DE TRABAJOS EN ' . $orden_trabajo->NumeroCompleto)
                ->attachData(
                    $pdf->output(),
                    'orden_trabajo' . $orden_trabajo->id . '.pdf',
                    ['mime' => 'application/pdf']
                );
        });

        return back()->with('success', 'Certificado enviado por correo correctamente.');
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

                    if ($orden_trabajo) {
                        $orden_trabajo->update([
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
