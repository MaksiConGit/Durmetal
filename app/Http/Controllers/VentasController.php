<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreItemOrdenTrabajoRequest;
use App\Http\Requests\StoreUSDARSRequest;
use App\Http\Requests\UpdateCodigoComplejidadRequest;
use App\Models\CodigoComplejidad;
use App\Models\Arti;
use App\Models\Banco;
use App\Models\Certificado;
use App\Models\Chequecobro;
use App\Models\Client;
use App\Models\ClientType;
use App\Models\Cobro;
use App\Models\CondicionVenta;
use App\Models\ConfiguracionGlobal;
use App\Models\DestinoCheque;
use App\Models\Email;
use App\Models\FacturaVenta;
use App\Models\ImpuestoIva;
use App\Models\ItemFacturaVenta;
use App\Models\ItemFacturaVentaNotaEnvio;
use App\Models\ItemNotaCreditoVenta;
use App\Models\ItemNotaEnvio;
use App\Models\ItemOrdenTrabajo;
use App\Models\ItemReciboVenta;
use App\Models\NotaCreditoVenta;
use App\Models\NotaEnvio;
use App\Models\OrdenTrabajo;
use App\Models\PuntoDeVenta;
use App\Models\ReciboVenta;
use App\Models\TransferenciaCobro;
use App\Models\Tratamiento;
use App\Services\AfipService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

use function PHPUnit\Framework\isEmpty;

class VentasController extends Controller
{
    public function trabajosSinFacturar()
    {
        $clientes = Client::all();
        $items_orden_trabajo = ItemOrdenTrabajo::whereIn('Estado', ['PENDIENTE'])->get();

        return view('ventas.trabajos-sin-facturar.index', compact('clientes', 'items_orden_trabajo'));
    }

    public function listadoDeRetenciones()
    {
        $recibos_venta = ReciboVenta::all();

        return view('ventas.listado-de-retenciones.index', compact('recibos_venta'));
    }
    
    public function listadoDePrecios()
    {
        $tratamientos = Tratamiento::all();
        $configuracion_global = ConfiguracionGlobal::first();

        return view('ventas.listado-de-precios.index', compact('tratamientos', 'configuracion_global'));
    }

    public function fichaDelCliente()
    {
        $clientes = Client::all();

        return view('ventas.ficha-del-cliente.index', compact('clientes'));
    }

    public function fichaDelClienteShow(Client $cliente, Request $request)
    {
        session()->forget('nota_envio_state');

        $filtro = $request->filtro;

        $facturas_venta = FacturaVenta::where('IdCliente', $cliente->id)->get();
        
        return view('ventas.ficha-del-cliente.show', compact('cliente', 'filtro', 'facturas_venta'));
    }

    public function listadoDeCheques()
    {
        $cheques_cobro = Chequecobro::all();
        $destinos_cheque = DestinoCheque::all();

        return view('ventas.listado-de-cheques.index', compact('cheques_cobro', 'destinos_cheque'));
    }

    public function valorizarTrabajos()
    {
        $items_orden_trabajo = ItemOrdenTrabajo::where('CC', 0);

        return view('ventas.valorizar-trabajos.index', compact('items_orden_trabajo'));
    }

    public function fichaDelClienteOrdenCreate(Client $cliente)
    {
        $next_orden_numero = OrdenTrabajo::max('Numero') + 1;

        $orden_trabajo = OrdenTrabajo::create([
                'PuntoVenta' => 1,
                'Numero' => $next_orden_numero,
        ]);

        return redirect()->route('orden-trabajo.edit', $orden_trabajo);
    }

    public function divisasUpdate(StoreUSDARSRequest $request, ConfiguracionGlobal $configuracion_global, Client $cliente)
    {
        $data = $request->all();

        $data['FechaActualizacionUSD_ARS'] = now();

        $configuracion_global->update($data);

        return redirect()->route('ventas.ficha-del-cliente-nota-envio.create', [
            'cliente' => $cliente,
            'pendientes' => $request->Pendientes,
        ]);
    }

    public function divisasUpdateEdit(StoreUSDARSRequest $request, ConfiguracionGlobal $configuracion_global, NotaEnvio $nota_envio)
    {
        $data = $request->all();
        $data['FechaActualizacionUSD_ARS'] = now();

        $configuracion_global->update($data);

        $pendientes = $request->Pendientes;

        return redirect()->route('ventas.ficha-del-cliente-nota-envio.edit', [
            'nota_envio' => $nota_envio,
            'pendientes' => $pendientes,
        ]);
    }

    public function fichaDelClienteNotaEnvioCreate(Client $cliente, Request $request)
    {
        $pendientes = $request->pendientes;

        return view('ventas.ficha-del-cliente.nota-envio', compact('cliente', 'pendientes'));
    }

    public function fichaDelClienteNotaEnvioStore(Request $request)
    {
        if (!$request->has('items') || empty($request->items)) {
            return redirect()->back()
                ->withErrors(['items' => 'Debe seleccionar al menos un ítem para crear la nota de envío.'])
                ->withInput();
        }

        $user_id = Auth::id();

        $cliente = Client::find($request->IdCliente);
    
        $data['Letra'] = 'X';
        $data['PuntoVenta'] = $request->PuntoVenta;
        $data['Numero'] = $request->Numero;
        $data['NumeroCompleto'] = "NE X 0001-0000$request->Numero";
        $data['FechaEmision'] = $request->FechaEmision;
        $data['FechaVencimiento'] = now();
        $data['AfectarPlanillaTurno'] = 0;
        $data['CondicionPrecios'] = 'A';
        $data['IdCliente'] = $cliente->id;
        $data['RazonSocial'] = $cliente->Nombre;
        $data['IdCondicionIva'] = $cliente->IdCondicionIVA;
        $data['TipoDocumento'] = $cliente->TipoDocumento;
        $data['NumeroDocumentoCliente'] = $cliente->NroDocumento;
        $data['Direccion'] = $cliente->Domicilio;
        $data['Localidad'] = $cliente->localidad->Nombre;
        $data['Provincia'] = $cliente->localidad->provincia->Nombre;
        $data['Estado'] = 'PENDIENTE';
        $data['TipoOperacion'] = null;
        $data['PorcentajeDescuento'] = $request->PorcentajeDescuento;
        $data['Neto'] = $request->Neto;
        $data['IVA'] = $request->IVA;
        $data['Total'] = $request->Total;
        $data['Observaciones'] = $request->Observaciones;
        $data['NumeroTurno'] = 0;
        $data['ReferenciaTurno'] = 2020;
        $data['AjusteCtaCtePlanillaTurno'] = 0;
        $data['FechaCreacion'] = now();
        $data['CreadoPor'] = $user_id;
        $data['FechaActualizacion'] = now();
        $data['ActualizadoPor'] = $user_id;
        $data['Activo'] = 1;
        $data['PuntoVentaNumero'] = $request->PuntoVenta + $request->Numero;
        $data['CantidadImpresiones'] = 0;
        $data['CantidadEnviosPorCorreo'] = 0;

        $nota_envio = NotaEnvio::create($data);

        foreach ($request->items as $index => $itemData) {

            $item_orden_trabajo = ItemOrdenTrabajo::find($itemData['IdItemOrdenTrabajo']);
            
            ItemNotaEnvio::create([
                'IdNotaEnvio' => $nota_envio->id,
                'IdItemOrdenTrabajo' => $item_orden_trabajo->id,
                'ItemNumero' => $index + 1,
                'Descripcion' => $itemData['Descripcion'],
                'Cantidad' => $item_orden_trabajo->Cantidad,
                'Peso' => $item_orden_trabajo->Peso,
                'CodigoComplejidad' => $itemData['CodigoComplejidad'],
                'Coeficiente' => $itemData['Coeficiente'],
                'PrecioUnitario' => $itemData['PrecioUnitario'],
                'PorcentajeDescuento' => $itemData['PorcentajeDescuento'],
                'Total' => $itemData['Total'],
                'Estado' => 'PENDIENTE',
                'FechaCreacion' => now(),
                'CreadoPor' => $user_id,
                'FechaActualizacion' => now(),
                'ActualizadoPor' => $user_id,
                'Activo' => 1,
            ]);

            $item_orden_trabajo->update(['ConNotaEnvio' => 1]);
        }

        session()->forget('nota_envio_state');

        return redirect()->route('ventas.ficha-del-cliente-nota-envio.show', $nota_envio);
    }

    public function fichaDelClienteNotaEnvioCC(UpdateCodigoComplejidadRequest $request, CodigoComplejidad $precio)
    {
        $data = $request->all();

        $data['FechaActualizacion'] = now();
        $data['ActualizadoPor'] = Auth::id();

        $precio = CodigoComplejidad::find($data['IdCodigoComplejidad']);
        
        $precio->update($data);

        $tratamiento = Tratamiento::find($data['IdTratamiento']);
    
        return redirect()->back();
    }

    public function fichaDelClienteNotaEnvioShow(NotaEnvio $nota_envio)
    {
        $pto_ventas = PuntoDeVenta::all();

        return view('ventas.ficha-del-cliente.nota-envio-show', compact('nota_envio', 'pto_ventas'));
    }

    public function fichaDelClienteNotaEnvioPDF(NotaEnvio $nota_envio)
    {
        $nuevo_cantidad_impresiones = $nota_envio->CantidadImpresiones + 1;

        $nota_envio->update(['CantidadImpresiones' => $nuevo_cantidad_impresiones]);

        $items_nota_envio = $nota_envio->itemsNotaEnvio;

        preg_match('/' . $nota_envio->Letra . '\s*([0-9]+-[0-9]+)/', $nota_envio->NumeroCompleto, $m);

        $numero = $m[1] ?? null;

        $pdf = Pdf::loadView('ventas.ficha-del-cliente.nota-envio-pdf', [
            'nota_envio' => $nota_envio,
            'items_nota_envio' => $items_nota_envio,
            'numero' => $numero,

        ])->setPaper('A4');

        return $pdf->stream('nota_envio.pdf');
    }

    public function fichaDelClienteNotaEnvioMail(NotaEnvio $nota_envio, Request $request)
    {
        $adjuntar_notas = $request->ConNotas == 1;

        $ids = explode(',', $request->Emails);

        if (!$ids || count($ids) == 0) {
            $emails = $nota_envio->cliente->emails->pluck('Email')->toArray();
        } else {
            $emails = Email::whereIn('Id', $ids)->pluck('Email')->toArray();
        }

        $nota_envio->CantidadEnviosPorCorreo = ($nota_envio->CantidadEnviosPorCorreo ?? 0) + 1;
        $nota_envio->save();

        $items_nota_envio = $nota_envio->itemsNotaEnvio;

        $numero_completo_nota = $nota_envio->NumeroCompleto;

        $pdf_nota = Pdf::loadView('ventas.ficha-del-cliente.nota-envio-pdf', [
            'nota_envio' => $nota_envio,
            'items_nota_envio' => $items_nota_envio,
            'numero' => $numero_completo_nota,
            'configuracion_global' => ConfiguracionGlobal::first(),
        ])->setPaper('A4');

        Mail::send('emails.nota-envio', [
            'factura' => $nota_envio,
            'numero' => $numero_completo_nota,
            'nombre' => $nota_envio->cliente->Nombre,
        ], function ($message) use ($emails, $pdf_nota, $numero_completo_nota) {

            $message->to($emails)
                    ->subject('NOTA DE ENVIO ' . $numero_completo_nota)
                    ->attachData(
                        $pdf_nota->output(),
                        "{$numero_completo_nota}.pdf",
                        ['mime' => 'application/pdf']
                    );

        });

        return back()->with('success', 'Factura enviada por correo correctamente.');
    }

    public function fichaDelClienteNotaEnvioOrdenTrabajo(Request $request)
    {
        $data = $request->all();
        if (!isset($data['items'])) {
            return back()->with('error', 'No se enviaron ítems.');
        }

        foreach ($data['items'] as $itemId => $itemData) {

            $item = ItemOrdenTrabajo::find($itemId);

            if ($item) {
                $item->update([
                    'Descripcion' => $itemData['Descripcion'],
                    'Cantidad' => $itemData['Cantidad'],
                    'Peso' => $itemData['Peso'],
                    'IdTratamiento' => $itemData['IdTratamiento'],
                    'IdDureza' => $itemData['IdDureza'],
                    'DurezaSolicitadaMinima' => $itemData['DurezaSolicitadaMinima'],
                    'DurezaSolicitadaMaxima' => $itemData['DurezaSolicitadaMaxima'],
                    'IdMaterial' => $itemData['IdMaterial'],
                    'CodigoComplejidad' => $itemData['CodigoComplejidad'],
                    'Estado' => $itemData['Estado'],
                    'Observaciones' => $itemData['Observaciones'],
                ]);

                if ($item->certificado) {

                    if ($itemData['NroPlano']) {
                        $item->certificado->update([
                            'Nombre' => $itemData['NroPlano'],
                            'NroPlano' => $itemData['NroPlano'],
                            'IdUsuario' => Auth::id(),
                        ]);
                    }
                    else{
                        $item->certificado->delete();
                    }

                }
                else{
                    if ($itemData['NroPlano']) {
                        Certificado::create([
                            'IdItemOrdenTrabajo' => $item->id,
                            'Nombre' => $itemData['NroPlano'],
                            'NroPlano' => $itemData['NroPlano'],
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
        }

        return redirect()->back();
    }

    public function fichaDelClienteNotaEnvioEdit(NotaEnvio $nota_envio)
    {
        $pto_ventas = PuntoDeVenta::all();
        $cliente = $nota_envio->cliente;

        return view('ventas.ficha-del-cliente.nota-envio-edit', compact('nota_envio', 'cliente'));
    }

    public function fichaDelClienteNotaEnvioUpdate(Request $request, NotaEnvio $nota_envio)
    {
        $user_id = Auth::id();

        $data['PorcentajeDescuento'] = $request->PorcentajeDescuento;
        $data['Neto'] = $request->Neto;
        $data['IVA'] = $request->IVA;
        $data['Total'] = $request->Total;
        $data['Observaciones'] = $request->Observaciones;
        $data['FechaActualizacion'] = now();
        $data['ActualizadoPor'] = $user_id;

        $nota_envio->update($data);

        $items = $request->items ?? [];
        $ids_en_request = [];

        foreach ($items as $index => $itemData) {

            if (!empty($itemData['IdItemNotaEnvio'])) {

                $item_nota_envio = ItemNotaEnvio::find($itemData['IdItemNotaEnvio']);

                if ($item_nota_envio) {
                    $item_nota_envio->update([
                        'CodigoComplejidad'      => $itemData['CodigoComplejidad'],
                        'Coeficiente'            => $itemData['Coeficiente'],
                        'PorcentajeDescuento'    => $itemData['PorcentajeDescuento'],
                        'PrecioUnitario'         => $itemData['PrecioUnitario'],
                        'Total'                  => $itemData['Total'],
                        'Descripcion'            => $itemData['Descripcion'],
                        'FechaActualizacion'     => now(),
                        'ActualizadoPor'         => $user_id,
                    ]);

                    $ids_en_request[] = $item_nota_envio->id;
                }

            } else {

                if (!isset($itemData['IdItemOrdenTrabajo'])) continue;

                $item_orden_trabajo = ItemOrdenTrabajo::find($itemData['IdItemOrdenTrabajo']);
                if (!$item_orden_trabajo) continue;

                $item_nota_envio = ItemNotaEnvio::create([
                    'IdNotaEnvio'          => $nota_envio->id,
                    'IdItemOrdenTrabajo'   => $item_orden_trabajo->id,
                    'ItemNumero'           => $index + 1,
                    'Descripcion'          => $itemData['Descripcion'],
                    'Cantidad'             => $item_orden_trabajo->Cantidad,
                    'Peso'                 => $item_orden_trabajo->Peso,
                    'CodigoComplejidad'    => $itemData['CodigoComplejidad'],
                    'Coeficiente'          => $itemData['Coeficiente'],
                    'PrecioUnitario'       => $itemData['PrecioUnitario'],
                    'PorcentajeDescuento'  => $itemData['PorcentajeDescuento'],
                    'Total'                => $itemData['Total'],
                    'Estado'               => 'PENDIENTE',
                    'FechaCreacion'        => now(),
                    'CreadoPor'            => $user_id,
                    'FechaActualizacion'   => now(),
                    'ActualizadoPor'       => $user_id,
                    'Activo'               => 1,
                ]);

                $ids_en_request[] = $item_nota_envio->id;

                $item_orden_trabajo->update(['ConNotaEnvio' => 1]);
            }
        }

        $items_a_borrar = $nota_envio->itemsNotaEnvio()
            ->whereNotIn('id', $ids_en_request)
            ->get();

        foreach ($items_a_borrar as $item) {
            if ($item->itemOrdenTrabajo) {
                $item->itemOrdenTrabajo->update(['ConNotaEnvio' => 0]);
            }
        }

        $nota_envio->itemsNotaEnvio()
            ->whereNotIn('id', $ids_en_request)
            ->delete();

        session()->forget('nota_envio_state');

        return redirect()->route('ventas.ficha-del-cliente-nota-envio.show', $nota_envio);
    }

    public function fichaDelClienteNotaEnvioDestroy(NotaEnvio $nota_envio)
    {
        $nota_envio->update([
            'Estado' => 'ANULADO'
        ]);

        return redirect()->route('ventas.ficha-del-cliente.show', $nota_envio->IdCliente);
    }

    public function fichaDelClienteFacturaVentaCreate(Client $cliente)
    {
        $notas_de_envio = NotaEnvio::where('Estado', 'PENDIENTE')->where('IdCliente', $cliente->id)->get();
        $pto_ventas = PuntoDeVenta::all();
        $next_numero = FacturaVenta::max('Numero') + 1;
        $condiciones_venta = CondicionVenta::all();

        return view('ventas.ficha-del-cliente.factura-venta', compact('notas_de_envio', 'pto_ventas', 'next_numero', 'cliente', 'condiciones_venta'));
    }

    public function fichaDelClienteFacturaVentaStore(Request $request, AfipService $afipService)
    {
        if (!$request->has('items') || empty($request->items)) {
            return redirect()->back()
                ->withErrors(['items' => 'Debe seleccionar al menos un ítem para crear la factura de venta.'])
                ->withInput();
        }

        $user_id = Auth::id();

        $cliente = Client::find($request->IdCliente);

        $mapa = [
            1 => 'B',
            2 => 'A',
            3 => 'A',
            4 => 'B',
            5 => 'A',
            6 => 'B',
        ];

        $letra = $mapa[$cliente->condicionIVA->id] ?? 'B';

        function mapearCondicionIvaAfip($id)
        {
            return match ($id) {
                1 => 4, // Exento
                2 => 1, // Responsable Inscripto
                3 => 7, // No categorizado
                4 => 5, // Consumidor Final
                5 => 6, // Monotributo
                6 => 7, // No identificado
                default => 5, // fallback: consumidor final
            };
        }

        $condicion_iva_afip = mapearCondicionIvaAfip($cliente->IdCondicionIVA);

        $data['Letra'] = $letra;
        $data['PuntoVenta'] = $request->PuntoVenta;
        $data['Numero'] = $request->Numero;
        $data['NumeroCompleto'] = "FC $letra 0001-0000$request->Numero";
        $data['FechaEmision'] = $request->FechaEmision;
        $data['FechaVencimiento'] = $request->FechaVencimiento;
        $data['FechaEstadisticas'] = $request->FechaEmision;
        $data['TipoOperacion'] = null;
        $data['CondicionPrecios'] = 'A';
        $data['IdCliente'] = $cliente->id;
        $data['RazonSocial'] = $cliente->Nombre;
        $data['TipoDocumentoCliente'] = $cliente->TipoDocumento;
        $data['NumeroDocumentoCliente'] = $cliente->NroDocumento;
        $data['Direccion'] = $cliente->Domicilio;
        $data['Localidad'] = $cliente->localidad->Nombre;
        $data['IdCondicionIva'] = $cliente->IdCondicionIVA;
        $data['CondicionVenta'] = $request->CondicionVenta;
        $data['Neto'] = $request->Neto;
        $data['NetoNoGravado'] = 0;
        $data['Exento'] = 0;
        $data['IVA'] = $request->IVA;
        $data['ImpuestoInterno'] = 0;
        $data['Total'] = $request->Total;
        $data['AjusteCtaCtePlanillaTurno'] = 0;
        $data['Estado'] = 'PENDIENTE';
        $data['CAE'] = '¡¡REVISAR!!';
        $data['FechaVencimientoCAE'] = $request->FechaEmision;
        $data['IdSolicitudCAE'] = 0;
        $data['Observaciones'] = $request->Observaciones;
        $data['NumeroTurno'] = 0;
        $data['ReferenciaTurno'] = 2020;
        $data['AfectarPlanillaTurno'] = 1;
        $data['EsNotaDeDebito'] = 0;
        $data['NroFacturaNotaDebito'] = '¡¡REVISAR!!';
        $data['EntregarMercaderiaConRemitos'] = 0;
        $data['FechaCreacion'] = now()->toDateString();
        $data['CreadoPor'] = $user_id;
        $data['FechaActualizacion'] = now()->toDateString();
        $data['ActualizadoPor'] = $user_id;
        $data['Activo'] = 1;
        $data['CantidadImpresiones'] = 0;
        $data['CantidadEnviosPorCorreo'] = 0;

        $factura_venta = FacturaVenta::create($data);

        $itemsParaAfip = [];

        foreach ($request->items as $index => $itemData) {
            $item_factura_venta = ItemFacturaVenta::create([
                'IdFacturaVenta' => $factura_venta->id,
                'ItemNumero' => $index + 1,
                'Descripcion' => $itemData['Descripcion'],
                'NroDeposito' => 1,
                'Cantidad' => 1,
                'PrecioCosto' => 0,
                'PrecioUnitarioNeto' => 0,
                'PrecioUnitario' => $itemData['Neto'],
                'IdImpuestoIva' => 1,
                'AlicuotaIVA' => 21,
                'ImpuestosInternos' => 0,
                'ImpuestoCombustible' => 0,
                'ImpuestoTV' => 0,
                'ImpuestoInterno' => 0,
                'Neto' => $itemData['Neto'],
                'IVA' => $itemData['IVA'],
                'Total' => $itemData['Neto'] + $itemData['IVA'],
                'AfectarPlanillaTurno' => 0,
                'ControlarStock' => 0,
                'Estado' => 'PENDIENTE',
                'FechaCreacion' => now(),
                'CreadoPor' => $user_id,
                'FechaActualizacion' => now(),
                'ActualizadoPor' => $user_id,
                'Activo' => 1,
            ]);

            $itemsParaAfip[] = [
                'description' => $itemData['Descripcion'],
                'quantity' => 1,
                'unit_price' => $itemData['Neto'],
                'total' => $itemData['Neto'] + $itemData['IVA'],
            ];

            $nota_envio = NotaEnvio::find($itemData['IdNotaEnvio']);

            $item_factura_venta_nota_envio = ItemFacturaVentaNotaEnvio::create([
                'IdItemFacturaVenta' => $item_factura_venta->id,
                'IdNotaEnvio' => $nota_envio->id,
            ]);

            $nota_envio->update(['Estado' => 'COMPLETO']);
        }

        if ((int)$data['PuntoVenta'] === 5) {

            try {
                function mapearTipoDocumentoAfip($tipo)
                {
                    return match (strtoupper($tipo)) {
                        'CUIT' => 80,
                        'DNI' => 96,
                        default => 99,
                    };
                }

                $payloadAfip = [
                    'numero_de_documento' => $cliente->NroDocumento ?? 0,
                    'tipo_de_documento' => mapearTipoDocumentoAfip($cliente->TipoDocumento),
                    'razon_social' => $cliente->Nombre,
                    'domicilio' => $cliente->Domicilio,
                    'importe_gravado' => $data['Neto'],
                    'importe_iva' => $data['IVA'],
                    'importe_exento_iva' => 0,
                    'punto_de_venta' => $data['PuntoVenta'],
                    'concepto' => 1,
                    'condicion_iva_receptor' => $condicion_iva_afip,
                    'condicion_venta' => $request->CondicionVenta,
                    'items' => $itemsParaAfip,
                ];

                $afipResponse = $letra === 'A'
                    ? $afipService->crearFacturaA($payloadAfip)
                    : $afipService->crearFacturaB($payloadAfip);

                $factura_venta->update([
                    'CAE' => $afipResponse['cae'],
                    'FechaVencimientoCAE' => $afipResponse['cae_vencimiento'],
                    'Numero' => $afipResponse['numero'],
                    'NumeroCompleto' => "FC {$data['Letra']} " . str_pad($data['PuntoVenta'], 4, '0', STR_PAD_LEFT)
                        . '-' . str_pad($afipResponse['numero'], 8, '0', STR_PAD_LEFT),
                ]);

                return redirect()
                    ->route('ventas.ficha-del-cliente-factura-venta.show', $factura_venta)
                    ->with('pdf_url', $afipResponse['file']);
                    
            } catch (\Throwable $e) {

                $factura_venta->update([
                    'Observaciones' => $e->getMessage(),
                ]);

                return redirect()->back()->withErrors([
                    'afip' => $e->getMessage()
                ]);
            }

        }

        return redirect()->route('ventas.ficha-del-cliente-factura-venta.show', $factura_venta);
    }

    public function fichaDelClienteFacturaVentaShow(FacturaVenta $factura_venta)
    {
        $pto_ventas = PuntoDeVenta::all();

        return view('ventas.ficha-del-cliente.factura-venta-show', compact('factura_venta', 'pto_ventas'));
    }

    public function fichaDelClienteFacturaVentaAPDF(FacturaVenta $factura_venta)
    {
        $nuevo_cantidad_impresiones = $factura_venta->CantidadImpresiones + 1;

        $factura_venta->update(['CantidadImpresiones' => $nuevo_cantidad_impresiones]);

        $items_factura_venta = $factura_venta->itemsFacturaVenta;

        $cliente = $factura_venta->cliente;

        preg_match('/' . $factura_venta->Letra . '\s*([0-9]+-[0-9]+)/', $factura_venta->NumeroCompleto, $m);

        $numero = $m[1] ?? null;

        $pdf = Pdf::loadView('ventas.ficha-del-cliente.factura-venta-a-pdf', [
            'cliente' => $cliente,
            'factura_venta' => $factura_venta,
            'items_factura_venta' => $items_factura_venta,
            'numero' => $numero,
            'configuracion_global' => ConfiguracionGlobal::first(),
        ])->setPaper('A4');

        return $pdf->stream('factura_venta.pdf');
    }

    public function fichaDelClienteFacturaVentaBPDF(FacturaVenta $factura_venta)
    {
        $nuevo_cantidad_impresiones = $factura_venta->CantidadImpresiones + 1;

        $factura_venta->update(['CantidadImpresiones' => $nuevo_cantidad_impresiones]);

        $items_factura_venta = $factura_venta->itemsFacturaVenta;

        $cliente = $factura_venta->cliente;

        preg_match('/' . $factura_venta->Letra . '\s*([0-9]+-[0-9]+)/', $factura_venta->NumeroCompleto, $m);

        $numero = $m[1] ?? null;

        $pdf = Pdf::loadView('ventas.ficha-del-cliente.factura-venta-b-pdf', [
            'cliente' => $cliente,
            'factura_venta' => $factura_venta,
            'items_factura_venta' => $items_factura_venta,
            'numero' => $numero,
            'configuracion_global' => ConfiguracionGlobal::first(),
        ])->setPaper('A4');

        return $pdf->stream('factura_venta.pdf');
    }

    public function fichaDelClienteFacturaVentaEdit(FacturaVenta $factura_venta)
    {
        $pto_ventas = PuntoDeVenta::all();
        $cliente = $factura_venta->cliente;

        return view('ventas.ficha-del-cliente.factura-venta-edit', compact('factura_venta', 'cliente'));
    }

    public function fichaDelClienteFacturaVentaUpdate(Request $request, FacturaVenta $factura_venta)
    {
        $user_id = Auth::id();

        $data['CondicionVenta'] = $request->CondicionVenta;
        $data['Observaciones'] = $request->Observaciones;

        $factura_venta->update($data);

        return redirect()->route('ventas.ficha-del-cliente-factura-venta.show', $factura_venta);
    }

    public function fichaDelClienteFacturaVentaDestroyPendiente(FacturaVenta $factura_venta)
    {
        $factura_venta->update([
            'Estado' => 'COMPLETO'
        ]);

        return redirect()->route('ventas.ficha-del-cliente.show', $factura_venta->IdCliente);
    }

    public function fichaDelClienteFacturaVentaDestroyCompleto(FacturaVenta $factura_venta)
    {
        $factura_venta->update([
            'Estado' => 'PENDIENTE'
        ]);

        return redirect()->route('ventas.ficha-del-cliente.show', $factura_venta->IdCliente);
    }

    public function fichaDelClienteFacturaVentaMail(FacturaVenta $factura_venta, Request $request)
    {
        $adjuntar_notas = $request->ConNotas == 1;

        $ids = explode(',', $request->Emails);

        if (!$ids || count($ids) == 0) {
            $emails = $factura_venta->cliente->emails->pluck('Email')->toArray();
        } else {
            $emails = Email::whereIn('Id', $ids)->pluck('Email')->toArray();
        }

        $factura_venta->CantidadEnviosPorCorreo = ($factura_venta->CantidadEnviosPorCorreo ?? 0) + 1;
        $factura_venta->save();

        $items_factura_venta = $factura_venta->itemsFacturaVenta;

        $numero_completo_factura = $factura_venta->NumeroCompleto;

        $cliente = $factura_venta->cliente;

        $pdf_factura = Pdf::loadView('ventas.ficha-del-cliente.factura-venta-pdf', [
            'cliente' => $cliente,
            'factura_venta' => $factura_venta,
            'items_factura_venta' => $items_factura_venta,
            'numero' => $numero_completo_factura,
            'configuracion_global' => ConfiguracionGlobal::first(),
        ])->setPaper('A4');

        $pdfs_notas = [];

        foreach ($items_factura_venta as $item) {

            if (!$item->itemFacturaVentaNotaEnvio) continue;
            if (!$item->itemFacturaVentaNotaEnvio->notaEnvio) continue;

            $nota_envio = $item->itemFacturaVentaNotaEnvio->notaEnvio;

            $numero_completo_nota = $nota_envio->NumeroCompleto;

            $pdf_nota = Pdf::loadView('ventas.ficha-del-cliente.nota-envio-pdf', [
                'nota_envio' => $nota_envio,
                'items_nota_envio' => $nota_envio->itemsNotaEnvio,
                'numero' => $numero_completo_nota,
            ])->setPaper('A4');

            $pdfs_notas[] = [
                'numero_completo' => $numero_completo_nota,
                'pdf' => $pdf_nota,
            ];
        }

        Mail::send('emails.factura-venta', [
            'factura' => $factura_venta,
            'numero' => $numero_completo_factura,
            'nombre' => $factura_venta->cliente->Nombre,
        ], function ($message) use ($emails, $pdf_factura, $numero_completo_factura, $pdfs_notas, $adjuntar_notas) {

            $message->to($emails)
                    ->subject('Factura ' . $numero_completo_factura)
                    ->attachData(
                        $pdf_factura->output(),
                        "{$numero_completo_factura}.pdf",
                        ['mime' => 'application/pdf']
                    );

            if ($adjuntar_notas) {
                foreach ($pdfs_notas as $nota) {
                    $message->attachData(
                        $nota['pdf']->output(),
                        "{$nota['numero_completo']}.pdf",
                        ['mime' => 'application/pdf']
                    );
                }
            }

        });

        return back()->with('success', 'Factura enviada por correo correctamente.');
    }


    public function fichaDelClienteReciboVentaCreate(Client $cliente)
    {
        $facturas_venta = FacturaVenta::where('Estado', 'PENDIENTE')->where('IdCliente', $cliente->id)->get();
        $pto_ventas = PuntoDeVenta::all();
        $next_numero = ReciboVenta::max('Numero') + 1;
        $bancos = Banco::all();

        return view('ventas.ficha-del-cliente.recibo-venta', compact('facturas_venta', 'pto_ventas', 'next_numero', 'cliente', 'bancos'));
    }

    public function fichaDelClienteReciboVentaStore(Request $request)
    {
        if (!$request->has('items') || empty($request->items)) {
            return redirect()->back()
                ->withErrors(['items' => 'Debe seleccionar al menos un ítem para crear el recibo de venta.'])
                ->withInput();
        }

        $user_id = Auth::id();

        $cliente = Client::find($request->IdCliente);
    
        $data['Letra'] = 'X';
        $data['PuntoVenta'] = $request->PuntoVenta;
        $data['Numero'] = $request->Numero;
        $data['NumeroCompleto'] = "RC X 0001-0000$request->Numero";
        $data['FechaEmision'] = $request->FechaEmision;
        $data['IdCliente'] = $cliente->id;
        $data['RazonSocial'] = $cliente->Nombre;
        $data['IdCondicionIva'] = $cliente->IdCondicionIVA;
        $data['TipoDocumentoCliente'] = $cliente->TipoDocumento;
        $data['NumeroDocumentoCliente'] = $cliente->NroDocumento;
        $data['Direccion'] = $cliente->Domicilio;
        $data['Localidad'] = $cliente->localidad->Nombre;
        $data['RetencionDREI'] = $request->RetencionDREI;
        $data['RetencionIIBB'] = $request->RetencionIIBB;
        $data['RetencionIVA'] = $request->RetencionIVA;
        $data['RetencionGanancias'] = $request->RetencionGanancias;
        $data['RetencionSUSS'] = $request->RetencionSUSS;
        $data['Estado'] = 'PENDIENTE'; // REVISAR
        $data['Total'] = $request->Total;
        $data['Observaciones'] = null;
        $data['NumeroTurno'] = 0;
        $data['ReferenciaTurno'] = 0;
        $data['AfectarPlanillaTurno'] = 0;
        $data['FechaCreacion'] = now()->toDateString();
        $data['CreadoPor'] = $user_id;
        $data['FechaActualizacion'] = now()->toDateString();
        $data['ActualizadoPor'] = $user_id;
        $data['Activo'] = 1;
        $data['LetraNumeroCompleto'] = 'X,' . $data['NumeroCompleto'];
        $data['CantidadImpresiones'] = 0;
        $data['CantidadEnviosPorCorreo'] = 0;
        $data['DescripcionSaldoTransportado'] = null;
        $data['ImporteSaldoTransportado'] = 0;

        $recibo_venta = ReciboVenta::create($data);

        foreach ($request->Efectivo as $efectivo) {
            if ($efectivo > 0) {
                Cobro::create([
                    'IdReciboVenta' => $recibo_venta->id,
                    'FormaPago' => 'EFECTIVO',
                    'Descripcion' => 'EFECTIVO',
                    'Total' => $efectivo ?? 0,
                    'FechaCreacion' => now(),
                    'CreadoPor' => $user_id,
                    'FechaActualizacion' => now(),
                    'ActualizadoPor' => $user_id,
                    'Activo' => 1,
                ]);
            }
        }

        foreach ($request->Transferencias as $transferencia) {
            if ($transferencia['IdBanco']) {

                $banco = Banco::find($transferencia['IdBanco']);

                $cobro = Cobro::create([
                    'IdReciboVenta' => $recibo_venta->id,
                    'FormaPago' => 'TRANSFERENCIA',
                    'Descripcion' => $banco->Nombre ?? 'REVISAR!!',
                    'Total' => $transferencia['Total'] ?? 0,
                    'FechaCreacion' => now(),
                    'CreadoPor' => $user_id,
                    'FechaActualizacion' => now(),
                    'ActualizadoPor' => $user_id,
                    'Activo' => 1,
                ]);

                TransferenciaCobro::create([
                    'IdCobro' => $cobro->id,
                    'IdBanco' => $banco->id,
                ]);
            }
        }

        foreach ($request->Cheques as $cheque) {
            if ($cheque['IdBanco'] && $cheque['FechaEmision'] && $cheque['FechaAcreditacion'] && $cheque['Numero'] && $cheque['Plaza']) {
                $cobro = Cobro::create([
                    'IdReciboVenta' => $recibo_venta->id,
                    'FormaPago' => 'CHEQUE',
                    'Descripcion' => Banco::find($cheque['IdBanco'])->Nombre ?? 'REVISAR!!',
                    'Total' => $cheque['Total'] ?? 0,
                    'FechaCreacion' => now(),
                    'CreadoPor' => $user_id,
                    'FechaActualizacion' => now(),
                    'ActualizadoPor' => $user_id,
                    'Activo' => 1,
                ]);

                Chequecobro::create([
                    'IdCobro' =>  $cobro->id,
                    'FechaEmision' => $cheque['FechaEmision'],
                    'FechaAcreditacion' => $cheque['FechaAcreditacion'],
                    'IdBanco' => $cheque['IdBanco'],
                    'Numero' => $cheque['Numero'],
                    'IdDestinoCheque' => $cheque['IdDestinoCheque'] ?? null,
                    'Plaza' => $cheque['Plaza'],
                    'eCheck' => $cheque['eCheck'],
                    'FechaCreacion' => now(),
                    'CreadoPor' => $user_id,
                    'FechaActualizacion' => now(),
                    'ActualizadoPor' => $user_id,
                    'Activo' => 1,
                ]);
            }
        }

        foreach ($request->Tarjetas as $tarjeta) {
            if ($tarjeta['Descripcion'] && $tarjeta['Total'] > 0) {
                Cobro::create([
                    'IdReciboVenta' => $recibo_venta->id,
                    'FormaPago' => 'TARJETA',
                    'Descripcion' => $tarjeta['Descripcion'] ?? 'REVISAR!!',
                    'Total' => $tarjeta['Total'] ?? 0,
                    'FechaCreacion' => now(),
                    'CreadoPor' => $user_id,
                    'FechaActualizacion' => now(),
                    'ActualizadoPor' => $user_id,
                    'Activo' => 1,
                ]);
            }
        }

        foreach ($request->items as $index => $itemData) {
            
            ItemReciboVenta::create([
                'IdReciboVenta' => $recibo_venta->id,
                'IdFacturaVenta' => $itemData['IdFacturaVenta'],
                'IdSubiva' => 0,
                'Descripcion' => FacturaVenta::find($itemData['IdFacturaVenta'])->NumeroCompleto,
                'Total' => $itemData['Total'] ?? 0,
                'FechaCreacion' => now(),
                'CreadoPor' => $user_id,
                'FechaActualizacion' => now(),
                'ActualizadoPor' => $user_id,
                'Activo' => 1,
            ]);

        }

        $factura_venta = FacturaVenta::find($itemData['IdFacturaVenta']);

        $factura_venta->update(['Estado' => 'COMPLETO']);

        return redirect()->route('ventas.ficha-del-cliente-recibo-venta.show', $recibo_venta);
    }

    public function fichaDelClienteReciboVentaShow(ReciboVenta $recibo_venta)
    {
        $pto_ventas = PuntoDeVenta::all();

        return view('ventas.ficha-del-cliente.recibo-venta-show', compact('recibo_venta', 'pto_ventas'));
    }

    public function fichaDelClienteReciboVentaPDF(ReciboVenta $recibo_venta)
    {
        $nuevo_cantidad_impresiones = $recibo_venta->CantidadImpresiones + 1;

        $recibo_venta->update(['CantidadImpresiones' => $nuevo_cantidad_impresiones]);

        $items_recibo_venta = $recibo_venta->itemsReciboVenta;

        preg_match('/' . $recibo_venta->Letra . '\s*([0-9]+-[0-9]+)/', $recibo_venta->NumeroCompleto, $m);

        $numero = $m[1] ?? null;

        $pdf = Pdf::loadView('ventas.ficha-del-cliente.recibo-venta-pdf', [
            'recibo_venta' => $recibo_venta,
            'items_recibo_venta' => $items_recibo_venta,
            'numero' => $numero,
            'configuracion_global' => ConfiguracionGlobal::first(),
        ])->setPaper('A4');

        return $pdf->stream('recibo_venta.pdf');
    }

    public function fichaDelClienteReciboVentaEdit(ReciboVenta $recibo_venta)
    {
        $pto_ventas = PuntoDeVenta::all();
        $cliente = $recibo_venta->cliente;

        return view('ventas.ficha-del-cliente.recibo-venta-edit', compact('recibo_venta', 'cliente'));
    }

    public function fichaDelClienteReciboVentaUpdate(ReciboVenta $recibo_venta, Request $request)
    {
        if (!$request->has('items') || empty($request->items)) {
            return redirect()->back()
                ->withErrors(['items' => 'Debe seleccionar al menos un ítem para editar el recibo de venta.'])
                ->withInput();
        }

        $user_id = Auth::id();

        $itemsExistentes = $recibo_venta->itemsReciboVenta;
        $idsExistentes = $itemsExistentes->pluck('id')->toArray();

        $idsQueLlegaron = [];

        foreach ($request->items as $key => $item) {

            if (!empty($item['IdItemReciboVenta'])) {

                $idItem = (int) $item['IdItemReciboVenta'];
                $idsQueLlegaron[] = $idItem;

                $itemBD = $itemsExistentes->firstWhere('id', $idItem);

                if ($itemBD) {
                    if ((float)$itemBD->Total !== (float)$item['Total']) {
                        $itemBD->FechaActualizacion = now()->toDateString();
                        $itemBD->ActualizadoPor = $user_id;
                        $itemBD->save();
                    }
                }

                continue;
            }

            if (!empty($item['IdFacturaVenta'])) {

                $recibo_venta->itemsReciboVenta()->create([
                    'IdReciboVenta' => $recibo_venta->id,
                    'IdFacturaVenta' => $item['IdFacturaVenta'],
                    'IdSuvida' => 0,
                    'Descripcion' => FacturaVenta::find($item['IdFacturaVenta'])->NumeroCompleto,
                    'Total' => $item['Total'],
                    'FechaCreacion' => now(),
                    'CreadoPor' => $user_id,
                    'FechaActualizacion' => now(),
                    'ActualizadoPor' => $user_id,
                    'Activo' => 1,
                ]);

                $factura_venta = FacturaVenta::find($item['IdFacturaVenta']);

                $factura_venta->update(['Estado' => 'COMPLETO']);

                continue;
            }
        }

        $idsParaEliminar = array_diff($idsExistentes, $idsQueLlegaron);

        if (count($idsParaEliminar) > 0) {

            $itemsAEliminar = $recibo_venta->itemsReciboVenta()
                ->whereIn('id', $idsParaEliminar)
                ->get();

            foreach ($itemsAEliminar as $item) {

                if ($item->facturaVenta) {
                    $item->facturaVenta->update([
                        'Estado' => 'PENDIENTE'
                    ]);
                }

                $item->delete();
            }
        }

        $data['RetencionDREI'] = $request->RetencionDREI;
        $data['RetencionIIBB'] = $request->RetencionIIBB;
        $data['RetencionIVA'] = $request->RetencionIVA;
        $data['RetencionGanancias'] = $request->RetencionGanancias;
        $data['RetencionSUSS'] = $request->RetencionSUSS;
        $data['Total'] = $request->Total;
        $data['FechaActualizacion'] = now()->toDateString();
        $data['ActualizadoPor'] = $user_id;


        $recibo_venta->update($data);


        // EFECTIVO
        $nuevoTotal = floatval($request->Efectivo['Total'] ?? 0);

        $cobro = Cobro::find($request->Efectivo['IdCobro'] ?? null);

        if ($cobro) {

            if ($nuevoTotal <= 0) {
                $cobro->delete();
            }

            elseif ($cobro->Total != $nuevoTotal) {
                $cobro->update([
                    'Total'              => $nuevoTotal,
                    'FechaActualizacion' => now(),
                    'ActualizadoPor'     => $user_id,
                ]);
            }

        }

        else {

            if ($nuevoTotal > 0) {

                $cobro = Cobro::create([
                    'IdReciboVenta' => $recibo_venta->id,
                    'FormaPago' => 'EFECTIVO',
                    'Descripcion' => 'EFECTIVO',
                    'Total' => $nuevoTotal,
                    'FechaCreacion' => now(),
                    'CreadoPor' => $user_id,
                    'FechaActualizacion' => now(),
                    'ActualizadoPor' => $user_id,
                    'Activo' => 1,
                ]);
            }

        }

        // TRANSFERENCIAS
        foreach ($request->Transferencias as $transferencia) {

            if (!empty($transferencia['IdCobro'])) {
            
                $cobro = Cobro::find($transferencia['IdCobro'] ?? null);

                if ($cobro) {

                    if (($transferencia['Total']) <= 0 && $transferencia['IdBanco'] == null) {
                        $cobro->transferenciaCobro->delete();
                        $cobro->delete();
                    }

                    elseif ($cobro->Total != $transferencia['Total'] || $cobro->transferenciaCobro->banco->id != $transferencia['IdBanco']) {

                        $banco = Banco::find($transferencia['IdBanco']);

                        $cobro->update([
                            'Descripcion'        => $banco->Nombre,
                            'Total'              => $transferencia['Total'] ?? 0,
                            'FechaActualizacion' => now(),
                            'ActualizadoPor'     => $user_id,
                        ]);

                        $cobro->transferenciaCobro->update([
                            'IdBanco' => $banco->id,
                        ]);
                    }

                }
            }

            else {

                if (($transferencia['Total']) > 0 && $transferencia['IdBanco'] <> null) {

                    $banco = Banco::find($transferencia['IdBanco']);

                    $cobro = Cobro::create([
                        'IdReciboVenta' => $recibo_venta->id,
                        'FormaPago' => 'TRANSFERENCIA',
                        'Descripcion' => $banco->Nombre,
                        'Total' => $transferencia['Total'],
                        'FechaCreacion' => now(),
                        'CreadoPor' => $user_id,
                        'FechaActualizacion' => now(),
                        'ActualizadoPor' => $user_id,
                        'Activo' => 1,
                    ]);

                    TransferenciaCobro::create([
                        'IdCobro' => $cobro->id,
                        'IdBanco' => $banco->id,
                    ]);
                    
                }
            
            }

        }

        // CHEQUES
        foreach ($request->Cheques as $cheque) {

            if (!empty($cheque['IdCobro'])) {
                
                $cobro = Cobro::find($cheque['IdCobro'] ?? null);

                $chequeCobro = $cobro->cheque ?? null;

                if ($cobro) {
                    if ($cheque['IdBanco'] == null && $cheque['Numero'] == null && $cheque['FechaEmision'] == null && $cheque['Plaza'] == null && $cheque['eCheck'] == 0 && $cheque['Total'] <= 0) {
                        $chequeCobro->delete();

                        $cobro->delete();

                    }

                    elseif (
                        !is_null($cheque['IdBanco']) &&
                        !is_null($cheque['Numero']) &&
                        !is_null($cheque['Plaza']) &&
                        !is_null($cheque['eCheck']) &&
                        (
                            $cheque['IdBanco'] != $chequeCobro->IdBanco ||
                            $cheque['Numero']  != $chequeCobro->Numero ||
                            $cheque['Plaza']   != $chequeCobro->Plaza ||
                            $cheque['eCheck']  != $chequeCobro->eCheck
                        )
                    ) {

                        $chequeCobro->update([
                            'IdBanco'              => $cheque['IdBanco'],
                            'Numero'               => $cheque['Numero'],
                            'Plaza'                => $cheque['Plaza'],
                            'eCheck'               => $cheque['eCheck'],
                            'FechaActualizacion'   => now(),
                            'ActualizadoPor'       => $user_id,
                        ]);

                    }

                    if ($cheque['Total'] != $cobro->Total) {

                        $cobro->update([
                            'Total' => $cheque['Total'],
                            'FechaActualizacion' => now(),
                            'ActualizadoPor' => $user_id,
                        ]);

                    }

                }
            }

            else {

                if (($cheque['IdBanco'] != null && $cheque['Numero'] != null && $cheque['FechaEmision'] != null && $cheque['Plaza'] != null && $cheque['Total'] <= 0)) {

                    $cobro = Cobro::create([
                        'IdReciboVenta' => $recibo_venta->id,
                        'FormaPago' => 'CHEQUE',
                        'Descripcion' => Banco::find($cheque['IdBanco'])->Nombre ?? 'REVISAR!!',
                        'Total' => $cheque['Total'] ?? 0,
                        'FechaCreacion' => now(),
                        'CreadoPor' => $user_id,
                        'FechaActualizacion' => now(),
                        'ActualizadoPor' => $user_id,
                        'Activo' => 1,
                    ]);

                    Chequecobro::create([
                        'IdCobro' =>  $cobro->id,
                        'FechaEmision' => $cheque['FechaEmision'],
                        'FechaAcreditacion' => $cheque['FechaAcreditacion'],
                        'IdBanco' => $cheque['IdBanco'],
                        'Numero' => $cheque['Numero'],
                        'IdDestinoCheque' => $cheque['IdDestinoCheque'] ?? null,
                        'Plaza' => $cheque['Plaza'],
                        'eCheck' => $cheque['eCheck'],
                        'FechaCreacion' => now(),
                        'CreadoPor' => $user_id,
                        'FechaActualizacion' => now(),
                        'ActualizadoPor' => $user_id,
                        'Activo' => 1,
                    ]);
                    
                }
            
            }

        }

        // TARJETAS
        foreach ($request->Tarjetas as $tarjeta) {

            if (!empty($tarjeta['IdCobro'])) {
                
                $cobro = Cobro::find($tarjeta['IdCobro'] ?? null);

                if ($cobro) {

                    if ($tarjeta['Descripcion'] == null && $tarjeta['Total'] <= 0) {
                        $cobro->delete();
                    }

                    elseif (
                        !is_null($tarjeta['Descripcion']) &&
                        !is_null($tarjeta['Total']) &&
                        (
                            $tarjeta['Descripcion'] != $cobro->Descripcion ||
                            $tarjeta['Total']  != $cobro->Total
                        )
                    ) {

                        $cobro->update([
                            'Descripcion' => $tarjeta['Descripcion'],
                            'Total' => $tarjeta['Total'],
                            'FechaActualizacion' => now(),
                            'ActualizadoPor' => $user_id,
                        ]);
                    }

                }

            }

            else {

                if ($tarjeta['Descripcion'] != null && $tarjeta['Total'] > 0) {

                    Cobro::create([
                        'IdReciboVenta' => $recibo_venta->id,
                        'FormaPago' => 'TARJETA',
                        'Descripcion' => $tarjeta['Descripcion'] ?? 'REVISAR!!',
                        'Total' => $tarjeta['Total'] ?? 0,
                        'FechaCreacion' => now(),
                        'CreadoPor' => $user_id,
                        'FechaActualizacion' => now(),
                        'ActualizadoPor' => $user_id,
                        'Activo' => 1,
                    ]);
                    
                }
            
            }

        }

        return redirect()->route('ventas.ficha-del-cliente-recibo-venta.show', $recibo_venta);
    }

    public function fichaDelClienteReciboVentaMail(ReciboVenta $recibo_venta, Request $request)
    {
        $ids = explode(',', $request->Emails);

        if (!$ids || count($ids) == 0) {
            $emails = $recibo_venta->cliente->emails->pluck('Email')->toArray();
        } else {
            $emails = Email::whereIn('Id', $ids)->pluck('Email')->toArray();
        }

        $recibo_venta->CantidadEnviosPorCorreo = ($recibo_venta->CantidadEnviosPorCorreo ?? 0) + 1;
        $recibo_venta->save();

        $items_recibo_venta = $recibo_venta->itemsReciboVenta;

        $numero_completo_recibo = $recibo_venta->NumeroCompleto;

        $pdf_nota = Pdf::loadView('ventas.ficha-del-cliente.recibo-venta-pdf', [
            'recibo_venta' => $recibo_venta,
            'items_recibo_venta' => $items_recibo_venta,
            'numero' => $numero_completo_recibo,
            'configuracion_global' => ConfiguracionGlobal::first(),
        ])->setPaper('A4');

        Mail::send('emails.recibo-venta', [
            'recibo' => $recibo_venta,
            'numero' => $numero_completo_recibo,
            'nombre' => $recibo_venta->cliente->Nombre,
        ], function ($message) use ($emails, $pdf_nota, $numero_completo_recibo) {

            $message->to($emails)
                    ->subject('RECIBO ' . $numero_completo_recibo)
                    ->attachData(
                        $pdf_nota->output(),
                        "{$numero_completo_recibo}.pdf",
                        ['mime' => 'application/pdf']
                    );

        });

        return back()->with('success', 'Recibo enviada por correo correctamente.');
    }

    public function fichaDelClienteNotaCreditoCreate(Client $cliente, FacturaVenta $factura_venta)
    {
        return view('ventas.ficha-del-cliente.nota-credito', compact('cliente', 'factura_venta'));
    }

    public function fichaDelClienteNotaCreditoStore(Request $request, AfipService $afipService)
    {
        if (!$request->has('items') || empty($request->items)) {
            return redirect()->back()
                ->withErrors(['items' => 'Debe seleccionar al menos un ítem para crear la factura de venta.'])
                ->withInput();
        }

        
        $user_id = Auth::id();

        $cliente = Client::find($request->IdCliente);
        $factura_venta = FacturaVenta::find($request->IdFacturaVenta);

        function mapearCondicionIvaAfip($id)
        {
            return match ($id) {
                1 => 4,
                2 => 1,
                3 => 7,
                4 => 5,
                5 => 6,
                6 => 7,
                default => 5,
            };
        }

        $condicion_iva_afip = mapearCondicionIvaAfip($cliente->IdCondicionIVA);

        $data['IdFacturaVenta'] = $request->IdFacturaVenta;
        $data['Letra'] = $factura_venta->Letra;
        $data['PuntoVenta'] = $request->PuntoVenta;
        $data['Numero'] = $request->Numero;
        $data['NumeroCompleto'] = "NC $factura_venta->Letra 0001-0000$request->Numero";
        $data['FechaEmision'] = $request->FechaEmision;
        $data['FechaVencimiento'] = $request->FechaEmision;
        $data['FechaEstadisticas'] = $request->FechaEmision; // REVISAR
        $data['TipoOperacion'] = null;
        $data['CondicionPrecios'] = 'A';
        $data['IdCliente'] = $cliente->id;
        $data['RazonSocial'] = $cliente->Nombre;
        $data['IdCondicionIva'] = $cliente->IdCondicionIVA;
        $data['TipoDocumentoCliente'] = $cliente->TipoDocumento;
        $data['NumeroDocumentoCliente'] = $cliente->NroDocumento;
        $data['Direccion'] = $cliente->Domicilio;
        $data['Localidad'] = $cliente->localidad->Nombre;
        $data['Neto'] = $request->Neto;
        $data['NetoNoGravado'] = 0;
        $data['IVA'] = $request->IVA;
        $data['Exento'] = 0;
        $data['ImpuestoInterno'] = 0;
        $data['Total'] = $request->Total;
        $data['AjusteCtaCtePlanillaTurno'] = 0;
        $data['Estado'] = 'PENDIENTE';
        $data['CAE'] = 0;
        $data['FechaVencimientoCAE'] = $request->FechaEmision;
        $data['IdSolicitudCAE'] = 0;
        $data['Observaciones'] = $request->Observaciones;
        $data['NumeroTurno'] = 0;
        $data['ReferenciaTurno'] = 2020;
        $data['AfectarPlanillaTurno'] = 1;
        $data['FechaCreacion'] = now()->toDateString();
        $data['CreadoPor'] = $user_id;
        $data['FechaActualizacion'] = now()->toDateString();
        $data['ActualizadoPor'] = $user_id;
        $data['Activo'] = 1;
        $data['CantidadImpresiones'] = 0;
        $data['CantidadEnviosPorCorreo'] = 0;

        $nota_credito_venta = NotaCreditoVenta::create($data);

        $itemsParaAfip = [];

        $alicuota = floatval($request->alicuota ?? 21);

        foreach ($request->items as $index => $itemData) {

            $neto = round(floatval($itemData['Total']), 2);
            $iva  = round($neto * 0.21, 2);
            $total = round($neto + $iva, 2);

            ItemNotaCreditoVenta::create([
                'IdNotaCreditoVenta' => $nota_credito_venta->id,
                'ItemNumero' => $index + 1,
                'IdArticulo' => 2,
                'Descripcion' => $itemData['Descripcion'],
                'NroDeposito' => 0,
                'Cantidad' => 1,

                'PrecioCosto' => 0,
                'PrecioUnitarioNeto' => $neto,
                'PrecioUnitario' => $neto,

                'AlicuotaIVA' => $alicuota,
                'ImpuestosInternos' => 0,
                'ImpuestoCombustible' => 0,
                'ImpuestoTV' => 0,
                'ImpuestoInterno' => 0,

                'Neto' => $neto,
                'IdImpuestoIva' => 1,
                'IVA' => $iva,
                'Total' => $total,

                'AfectarPlanillaTurno' => 0,
                'ControlarStock' => 0,
                'FechaCreacion' => now(),
                'CreadoPor' => $user_id,
                'FechaActualizacion' => now(),
                'ActualizadoPor' => $user_id,
                'Activo' => 0,
            ]);

            $itemsParaAfip[] = [
                'description' => $itemData['Descripcion'],
                'quantity' => 1,
                'unit_price' => $neto,
                'total' => $total,
            ];

        }

        if ((int)$data['PuntoVenta'] === 5) {

            try {
                function mapearTipoDocumentoAfip($tipo)
                {
                    return match (strtoupper($tipo)) {
                        'CUIT' => 80,
                        'DNI' => 96,
                        default => 99,
                    };
                }

                $payloadAfip = [
                    'numero_de_documento' => $cliente->NroDocumento ?? 0,
                    'tipo_de_documento' => mapearTipoDocumentoAfip($cliente->TipoDocumento),

                    'razon_social' => $cliente->Nombre,
                    'domicilio' => $cliente->Domicilio,

                    'importe_gravado' => $data['Neto'],
                    'importe_iva' => $data['IVA'],
                    'importe_exento_iva' => 0,

                    'punto_de_venta' => $data['PuntoVenta'],
                    'concepto' => 1,

                    'condicion_iva_receptor' => $condicion_iva_afip,
                    'condicion_venta' => 'Contado',

                    'tipo_factura_asociada' => $factura_venta->Letra === 'A' ? 1 : 6,
                    'punto_factura_asociada' => $factura_venta->PuntoVenta,
                    'numero_factura_asociada' => $factura_venta->Numero,

                    'items' => $itemsParaAfip,
                    'motivo' => $request->Observaciones ?? 'Anulación',
                ];

                $afipResponse = $factura_venta->Letra === 'A' ? $afipService->crearNotaCreditoA($payloadAfip) : $afipService->crearNotaCreditoB($payloadAfip);

                $nota_credito_venta->update([
                    'CAE' => $afipResponse['cae'],
                    'FechaVencimientoCAE' => $afipResponse['cae_vencimiento'],
                    'Numero' => $afipResponse['numero'],
                    'NumeroCompleto' => "NC {$data['Letra']} "
                        . str_pad($data['PuntoVenta'], 4, '0', STR_PAD_LEFT)
                        . '-' . str_pad($afipResponse['numero'], 8, '0', STR_PAD_LEFT),
                ]);

                return redirect()
                    ->route('ventas.ficha-del-cliente-nota-credito.show', $nota_credito_venta)
                    ->with('pdf_url', $afipResponse['file']);

            } catch (\Throwable $e) {

                $nota_credito_venta->update([
                    'Observaciones' => $e->getMessage(),
                ]);

                return redirect()->back()->withErrors([
                    'afip' => $e->getMessage()
                ]);
            }
        }

        $notas_credito_venta = NotaCreditoVenta::where('IdFacturaVenta', $factura_venta->id)->get();

        if ($notas_credito_venta->sum('Total') >= $factura_venta->Total) {
            $factura_venta->update([
                'Estado' => 'COMPLETO'
            ]);
        }

        return redirect()->route('ventas.ficha-del-cliente-nota-credito.show', $nota_credito_venta);
    }

    public function fichaDelClienteNotaCreditoShow(NotaCreditoVenta $nota_credito_venta)
    {
        $pto_ventas = PuntoDeVenta::all();

        return view('ventas.ficha-del-cliente.nota-credito-show', compact('nota_credito_venta', 'pto_ventas'));
    }

    public function fichaDelClienteNotaCreditoEdit(NotaCreditoVenta $nota_credito)
    {
        $pto_ventas = PuntoDeVenta::all();
        $cliente = $nota_credito->cliente;

        return view('ventas.ficha-del-cliente.nota-credito-edit', compact('nota_credito', 'cliente'));
    }

    public function fichaDelClienteNotaCreditoUpdate(NotaCreditoVenta $nota_credito, Request $request)
    {        
        $nota_credito->update([
            "Observaciones" => $request->Observaciones,
        ]);

        return redirect()->route('ventas.ficha-del-cliente.show', $nota_credito->IdCliente);
    }

    public function fichaDelClienteNotaCreditoAPDF(NotaCreditoVenta $nota_credito)
    {
        $nuevo_cantidad_impresiones = $nota_credito->CantidadImpresiones + 1;

        $nota_credito->update(['CantidadImpresiones' => $nuevo_cantidad_impresiones]);

        $cliente = $nota_credito->cliente;

        $items_nota_credito = $nota_credito->itemsNotaCredito;

        preg_match('/' . $nota_credito->Letra . '\s*([0-9]+-[0-9]+)/', $nota_credito->NumeroCompleto, $m);

        $numero = $m[1] ?? null;

        $pdf = Pdf::loadView('ventas.ficha-del-cliente.nota-credito-a-pdf', [
            'cliente' => $cliente,
            'nota_credito' => $nota_credito,
            'items_nota_credito' => $items_nota_credito,
            'numero' => $numero,
            'configuracion_global' => ConfiguracionGlobal::first(),
        ])->setPaper('A4');

        return $pdf->stream('nota_credito.pdf');
    }

    public function fichaDelClienteNotaCreditoBPDF(NotaCreditoVenta $nota_credito)
    {
        $nuevo_cantidad_impresiones = $nota_credito->CantidadImpresiones + 1;

        $nota_credito->update(['CantidadImpresiones' => $nuevo_cantidad_impresiones]);

        $cliente = $nota_credito->cliente;

        $items_nota_credito = $nota_credito->itemsNotaCredito;

        preg_match('/' . $nota_credito->Letra . '\s*([0-9]+-[0-9]+)/', $nota_credito->NumeroCompleto, $m);

        $numero = $m[1] ?? null;

        $pdf = Pdf::loadView('ventas.ficha-del-cliente.nota-credito-b-pdf', [
            'cliente' => $cliente,
            'nota_credito' => $nota_credito,
            'items_nota_credito' => $items_nota_credito,
            'numero' => $numero,
            'configuracion_global' => ConfiguracionGlobal::first(),
        ])->setPaper('A4');

        return $pdf->stream('nota_credito.pdf');
    }

    public function fichaDelClienteNotaCreditoMail(NotaCreditoVenta $nota_credito, Request $request)
    {
        $ids = explode(',', $request->Emails);

        if (!$ids || count($ids) == 0) {
            $emails = $nota_credito->cliente->emails->pluck('Email')->toArray();
        } else {
            $emails = Email::whereIn('Id', $ids)->pluck('Email')->toArray();
        }

        $nota_credito->CantidadEnviosPorCorreo = ($nota_credito->CantidadEnviosPorCorreo ?? 0) + 1;
        $nota_credito->save();

        $items_nota_credito = $nota_credito->itemsNotaCredito;

        $numero_completo_nota = $nota_credito->NumeroCompleto;

        $cliente = $nota_credito->cliente;

        $pdf_nota = Pdf::loadView('ventas.ficha-del-cliente.nota-credito-pdf', [
            'cliente' => $cliente,
            'nota_credito' => $nota_credito,
            'items_nota_credito' => $items_nota_credito,
            'numero' => $numero_completo_nota,
            'configuracion_global' => ConfiguracionGlobal::first(),
        ])->setPaper('A4');

        Mail::send('emails.nota-credito', [
            'nota' => $nota_credito,
            'numero' => $numero_completo_nota,
            'nombre' => $nota_credito->cliente->Nombre,
        ], function ($message) use ($emails, $pdf_nota, $numero_completo_nota) {

            $message->to($emails)
                    ->subject('NOTA DE CREDITO ' . $numero_completo_nota)
                    ->attachData(
                        $pdf_nota->output(),
                        "{$numero_completo_nota}.pdf",
                        ['mime' => 'application/pdf']
                    );

        });

        return back()->with('success', 'Recibo enviada por correo correctamente.');
    }

    public function fichaDelClienteNotaDebitoCreate(Client $cliente, FacturaVenta $factura_venta)
    {
        return view('ventas.ficha-del-cliente.nota-debito', compact('cliente', 'factura_venta'));
    }

    public function fichaDelClienteNotaDebitoStore(Request $request, AfipService $afipService)
    {
        // dd($request->all());
         if (!$request->has('items') || empty($request->items)) {
            return redirect()->back()
                ->withErrors(['items' => 'Debe seleccionar al menos un ítem para crear la nota de débito.'])
                ->withInput();
        }

        $user_id = Auth::id();

        $cliente = Client::find($request->IdCliente);
        $factura_venta = FacturaVenta::find($request->IdFacturaVenta);
    
        $data['Letra'] = $factura_venta->Letra;
        $data['PuntoVenta'] = $request->PuntoVenta;
        $data['Numero'] = $request->Numero;
        $data['NumeroCompleto'] = "ND $factura_venta->Letra 0001-0000$request->Numero";
        $data['FechaEmision'] = $request->FechaEmision;
        $data['FechaVencimiento'] = $request->FechaEmision;
        $data['FechaEstadisticas'] = $request->FechaEmision;
        $data['TipoOperacion'] = null;
        $data['CondicionPrecios'] = 'A';
        $data['IdCliente'] = $cliente->id;
        $data['RazonSocial'] = $cliente->Nombre;
        $data['TipoDocumentoCliente'] = $cliente->TipoDocumento;
        $data['NumeroDocumentoCliente'] = $cliente->NroDocumento;
        $data['Direccion'] = $cliente->Domicilio;
        $data['Localidad'] = $cliente->localidad->Nombre;
        $data['IdCondicionIva'] = $cliente->IdCondicionIVA;
        $data['CondicionVenta'] = $request->CondicionVenta;
        $data['Neto'] = $request->Neto;
        $data['NetoNoGravado'] = 0;
        $data['Exento'] = 0;
        $data['IVA'] = $request->IVA;
        $data['ImpuestoInterno'] = 0;
        $data['Total'] = $request->Total;
        $data['AjusteCtaCtePlanillaTurno'] = 0;
        $data['Estado'] = 'PENDIENTE';
        $data['CAE'] = '¡¡REVISAR!!';
        $data['FechaVencimientoCAE'] = $request->FechaEmision;
        $data['IdSolicitudCAE'] = 0;
        $data['Observaciones'] = $request->Observaciones;
        $data['NumeroTurno'] = 0;
        $data['ReferenciaTurno'] = 2020;
        $data['AfectarPlanillaTurno'] = 1;
        $data['EsNotaDeDebito'] = 1;
        $data['NroFacturaNotaDebito'] = $factura_venta->NumeroCompleto;
        $data['EntregarMercaderiaConRemitos'] = 0;
        $data['FechaCreacion'] = now()->toDateString();
        $data['CreadoPor'] = $user_id;
        $data['FechaActualizacion'] = now()->toDateString();
        $data['ActualizadoPor'] = $user_id;
        $data['Activo'] = 1;
        $data['CantidadImpresiones'] = 0;
        $data['CantidadEnviosPorCorreo'] = 0;

        $nota_debito = FacturaVenta::create($data);

       foreach ($request->items as $index => $itemData) {

            // 🔎 BUSCAR IMPUESTO Y DEFINIR TASA
            switch ($itemData['IvaTipo']) {

                case 'nogravado':
                    $impuesto_iva = ImpuestoIva::where('id', 6)->first();
                    $tasa = -1; // ✅ -1%
                    break;

                case 'exento':
                    $impuesto_iva = ImpuestoIva::where('id', 3)->first();
                    $tasa = 0; // ✅ 0%
                    break;

                default:
                    $impuesto_iva = ImpuestoIva::where('Tasa', $itemData['IvaTipo'])->first();
                    $tasa = (float) $itemData['IvaTipo'];
                    break;
            }

            // ✅ VALORES BASE
            $neto = (float) $itemData['Neto'];

            // ✅ IVA CALCULADO ACÁ
            $iva = round($neto * ($tasa / 100), 2);

            // ✅ TOTAL FINAL
            $total = round($neto + $iva, 2);

            // ✅ GUARDADO FINAL
            ItemFacturaVenta::create([
                'IdFacturaVenta' => $nota_debito->id,
                'ItemNumero' => $index + 1,
                'Descripcion' => $itemData['Descripcion'],
                'NroDeposito' => 1,
                'Cantidad' => 1,
                'PrecioCosto' => 0,
                'PrecioUnitarioNeto' => 0,
                'PrecioUnitario' => $neto,

                'IdImpuestoIva' => $impuesto_iva->id,
                'AlicuotaIVA' => $tasa,

                'ImpuestosInternos' => 0,
                'ImpuestoCombustible' => 0,
                'ImpuestoTV' => 0,
                'ImpuestoInterno' => 0,

                'Neto' => $neto,

                // ✅ AHORA VIENE DEL CÁLCULO REAL
                'IVA' => $iva,
                'Total' => $total,

                'AfectarPlanillaTurno' => 0,
                'ControlarStock' => 0,
                'Estado' => 'PENDIENTE',
                'FechaCreacion' => now(),
                'CreadoPor' => $user_id,
                'FechaActualizacion' => now(),
                'ActualizadoPor' => $user_id,
                'Activo' => 1,
            ]);
        }

        if ((int)$data['PuntoVenta'] === 5) {

            try {

                function mapearTipoDocumentoAfip($tipo)
                {
                    return match (strtoupper($tipo)) {
                        'CUIT' => 80,
                        'DNI' => 96,
                        default => 99,
                    };
                }

                function mapearCondicionIvaAfip($id)
                {
                    return match ($id) {
                        1 => 4, // Exento
                        2 => 1, // Responsable Inscripto
                        3 => 7, // No categorizado
                        4 => 5, // Consumidor Final
                        5 => 6, // Monotributo
                        6 => 7, // No identificado
                        default => 5,
                    };
                }

                $condicion_iva_afip = mapearCondicionIvaAfip($cliente->IdCondicionIVA);

                // 🔥 IMPORTANTE: items para AFIP (con IVA)
                $itemsParaAfip = [];

                foreach ($request->items as $itemData) {

                    $neto = (float) $itemData['Neto'];
                    $tasa = (float) $itemData['IvaTipo'];
                    $iva = round($neto * ($tasa / 100), 2);

                    $itemsParaAfip[] = [
                        'description' => $itemData['Descripcion'],
                        'quantity' => 1,
                        'unit_price' => $neto,
                        'total' => $neto + $iva,
                        'vat_rate' => $tasa,
                    ];
                }

                $payloadAfip = [
                    'numero_de_documento' => $cliente->NroDocumento ?? 0,
                    'tipo_de_documento' => mapearTipoDocumentoAfip($cliente->TipoDocumento),
                    'razon_social' => $cliente->Nombre,
                    'domicilio' => $cliente->Domicilio,

                    'importe_gravado' => $data['Neto'],
                    'importe_iva' => $data['IVA'],
                    'importe_exento_iva' => 0,

                    'punto_de_venta' => $data['PuntoVenta'],
                    'concepto' => 1,

                    'condicion_iva_receptor' => $condicion_iva_afip,
                    'condicion_venta' => $request->CondicionVenta,

                    'tipo_factura_asociada' => $factura_venta->Letra === 'A' ? 1 : 6,
                    'punto_factura_asociada' => $factura_venta->PuntoVenta,
                    'numero_factura_asociada' => $factura_venta->Numero,

                    'items' => $itemsParaAfip,
                    'motivo' => $request->Observaciones ?? 'Nota de Débito',
                ];

                // 🚀 SEGÚN LETRA
                $afipResponse = $data['Letra'] === 'A'
                    ? $afipService->crearNotaDebitoA($payloadAfip)
                    : $afipService->crearNotaDebitoB($payloadAfip);

                // ✅ ACTUALIZAR ND
                $nota_debito->update([
                    'CAE' => $afipResponse['cae'],
                    'FechaVencimientoCAE' => $afipResponse['cae_vencimiento'],
                    'Numero' => $afipResponse['numero'],
                    'NumeroCompleto' => "ND {$data['Letra']} "
                        . str_pad($data['PuntoVenta'], 4, '0', STR_PAD_LEFT)
                        . '-' . str_pad($afipResponse['numero'], 8, '0', STR_PAD_LEFT),
                ]);

                return redirect()
                    ->route('ventas.ficha-del-cliente-nota-debito.show', $nota_debito)
                    ->with('pdf_url', $afipResponse['file']);

            } catch (\Throwable $e) {

                $nota_debito->update([
                    'Observaciones' => $e->getMessage(),
                ]);

                return redirect()->back()->withErrors([
                    'afip' => $e->getMessage()
                ]);
            }
        }

        return redirect()->route('ventas.ficha-del-cliente-nota-debito.show', $nota_debito);
    }

    public function fichaDelClienteNotaDebitoShow(FacturaVenta $nota_debito)
    {
        $pto_ventas = PuntoDeVenta::all();

        return view('ventas.ficha-del-cliente.nota-debito-show', compact('nota_debito', 'pto_ventas'));
    }

    public function fichaDelClienteNotaDebitoEdit(FacturaVenta $nota_debito)
    {
        $pto_ventas = PuntoDeVenta::all();
        $cliente = $nota_debito->cliente;

        return view('ventas.ficha-del-cliente.nota-debito-edit', compact('nota_debito', 'cliente'));
    }

    public function fichaDelClienteNotaDebitoUpdate(FacturaVenta $nota_debito, Request $request)
    {
        $nota_debito->update([
            'CondicionVenta' => $request->CondicionVenta,
            'Observaciones' => $request->Observaciones,
        ]);

        return redirect()->route('ventas.ficha-del-cliente.show', $nota_debito->IdCliente);
    }

    public function fichaDelClienteNotaDebitoAPDF(FacturaVenta $nota_debito)
    {
        $nuevo_cantidad_impresiones = $nota_debito->CantidadImpresiones + 1;

        $nota_debito->update(['CantidadImpresiones' => $nuevo_cantidad_impresiones]);

        $items_nota_debito = $nota_debito->itemsFacturaVenta;

        $cliente = $nota_debito->cliente;

        preg_match('/' . $nota_debito->Letra . '\s*([0-9]+-[0-9]+)/', $nota_debito->NumeroCompleto, $m);

        $numero = $m[1] ?? null;

        $pdf = Pdf::loadView('ventas.ficha-del-cliente.nota-debito-a-pdf', [
            'cliente' => $cliente,
            'nota_debito' => $nota_debito,
            'items_nota_debito' => $items_nota_debito,
            'numero' => $numero,
            'configuracion_global' => ConfiguracionGlobal::first(),
        ])->setPaper('A4');

        return $pdf->stream('nota_debito.pdf');
    }

    public function fichaDelClienteNotaDebitoBPDF(FacturaVenta $nota_debito)
    {
        $nuevo_cantidad_impresiones = $nota_debito->CantidadImpresiones + 1;

        $nota_debito->update(['CantidadImpresiones' => $nuevo_cantidad_impresiones]);

        $items_nota_debito = $nota_debito->itemsFacturaVenta;

        $cliente = $nota_debito->cliente;

        preg_match('/' . $nota_debito->Letra . '\s*([0-9]+-[0-9]+)/', $nota_debito->NumeroCompleto, $m);

        $numero = $m[1] ?? null;

        $pdf = Pdf::loadView('ventas.ficha-del-cliente.nota-debito-b-pdf', [
            'cliente' => $cliente,
            'nota_debito' => $nota_debito,
            'items_nota_debito' => $items_nota_debito,
            'numero' => $numero,
            'configuracion_global' => ConfiguracionGlobal::first(),
        ])->setPaper('A4');

        return $pdf->stream('nota_debito.pdf');
    }

    public function fichaDelClienteNotaDebitoMail(FacturaVenta $nota_debito, Request $request)
    {
        $ids = explode(',', $request->Emails);

        if (!$ids || count($ids) == 0) {
            $emails = $nota_debito->cliente->emails->pluck('Email')->toArray();
        } else {
            $emails = Email::whereIn('Id', $ids)->pluck('Email')->toArray();
        }

        $nota_debito->CantidadEnviosPorCorreo = ($nota_debito->CantidadEnviosPorCorreo ?? 0) + 1;
        $nota_debito->save();

        $items_nota_debito = $nota_debito->itemsFacturaVenta;

        $numero_completo_nota = $nota_debito->NumeroCompleto;

        $cliente = $nota_debito->cliente;

        $pdf_nota = Pdf::loadView('ventas.ficha-del-cliente.nota-debito-pdf', [
            'cliente' => $cliente,
            'nota_debito' => $nota_debito,
            'items_nota_debito' => $items_nota_debito,
            'numero' => $numero_completo_nota,
            'configuracion_global' => ConfiguracionGlobal::first(),
        ])->setPaper('A4');

        Mail::send('emails.nota-debito', [
            'nota' => $nota_debito,
            'numero' => $numero_completo_nota,
            'nombre' => $nota_debito->cliente->Nombre,
        ], function ($message) use ($emails, $pdf_nota, $numero_completo_nota) {

            $message->to($emails)
                    ->subject('NOTA DE DEBITO ' . $numero_completo_nota)
                    ->attachData(
                        $pdf_nota->output(),
                        "{$numero_completo_nota}.pdf",
                        ['mime' => 'application/pdf']
                    );

        });

        return back()->with('success', 'Recibo enviada por correo correctamente.');
    }

    public function fichaDelClienteMinutaCreate(Client $cliente)
    {
        $ordenes_trabajo = OrdenTrabajo::where('');

        return view('ventas.ficha-del-cliente.nota-envio', compact('ordenes_trabajo'));
    }

    public function listadoDeSaldos()
    {
        return view('ventas.listado-de-saldos.index');
    }

    public function resumenCuentaCorriente(Request $request)
    {
        $cliente_id = array_key_first($request->query());

        return view('ventas.resumen-cuenta-corriente.index', compact('cliente_id'));
    }

    public function resumenCuentaCorrientePDF(Client $cliente, Request $request)
    {
        $desde = $request->get('desde', now()->subMonth(3)->toDateString());
        $hasta = $request->get('hasta', now()->toDateString());

        $facturas = $cliente->facturasVenta()
            ->whereBetween('FechaEmision', [$desde, $hasta])
            ->get()
            ->map(fn ($doc) => [
                'tipo' => 'factura',
                'documento' => $doc,
                'FechaEmision' => $doc->FechaEmision
            ]);

        $debitos = $cliente->notasDeDebito()
            ->whereBetween('FechaEmision', [$desde, $hasta])
            ->get()
            ->map(fn ($doc) => [
                'tipo' => 'debito',
                'documento' => $doc,
                'FechaEmision' => $doc->FechaEmision
            ]);

        $recibos = $cliente->recibosVenta()
            ->whereBetween('FechaEmision', [$desde, $hasta])
            ->get()
            ->map(fn ($doc) => [
                'tipo' => 'recibo',
                'documento' => $doc,
                'FechaEmision' => $doc->FechaEmision
            ]);

        $notas = $cliente->notasDeCredito()
            ->whereBetween('FechaEmision', [$desde, $hasta])
            ->get()
            ->map(fn ($doc) => [
                'tipo' => 'nota',
                'documento' => $doc,
                'FechaEmision' => $doc->FechaEmision
            ]);

        $documentos = collect()
            ->merge($facturas)
            ->merge($debitos)
            ->merge($recibos)
            ->merge($notas)
            ->sortBy('FechaEmision')
            ->values();

        $saldo = $cliente->SaldoSistemaAnterior;

        foreach ($documentos as $item) {
            if (in_array($item['tipo'], ['factura', 'debito'])) {
                $saldo += $item['documento']->Total;
            } elseif (in_array($item['tipo'], ['recibo', 'nota'])) {
                $saldo -= $item['documento']->Total;
            }
        }

        $pdf = Pdf::loadView('ventas.resumen-cuenta-corriente.pdf', [
            'cliente'    => $cliente,
            'documentos' => $documentos,
            'saldo'      => $saldo,
            'desde'      => $desde,
            'hasta'      => $hasta,
        ])->setPaper('A4');

        return $pdf->stream('resumen_cuenta_corriente.pdf');
    }

    public function resumenCuentaCorrienteMail(Client $cliente, Request $request)
    {
        $desde = $request->get('desde', now()->subMonth(3)->toDateString());
        $hasta = $request->get('hasta', now()->toDateString());

        /*
        |--------------------------------------------------------------------------
        | Emails desde el modal
        |--------------------------------------------------------------------------
        */
        $emails = collect(explode(',', $request->get('Emails')))
            ->filter()
            ->map(fn ($id) => (int) $id)
            ->pipe(function ($ids) {
                return Email::whereIn('id', $ids)
                    ->pluck('Email')
                    ->filter()
                    ->toArray();
            });

        if (empty($emails)) {
            return back()->with('error', 'No se seleccionaron direcciones de correo válidas.');
        }

        /*
        |--------------------------------------------------------------------------
        | Obtener documentos
        |--------------------------------------------------------------------------
        */
        $facturas = $cliente->facturasVenta()
            ->whereBetween('FechaEmision', [$desde, $hasta])
            ->get()
            ->map(fn ($doc) => ['tipo' => 'factura', 'documento' => $doc, 'FechaEmision' => $doc->FechaEmision]);

        $debitos = $cliente->notasDeDebito()
            ->whereBetween('FechaEmision', [$desde, $hasta])
            ->get()
            ->map(fn ($doc) => ['tipo' => 'debito', 'documento' => $doc, 'FechaEmision' => $doc->FechaEmision]);

        $recibos = $cliente->recibosVenta()
            ->whereBetween('FechaEmision', [$desde, $hasta])
            ->get()
            ->map(fn ($doc) => ['tipo' => 'recibo', 'documento' => $doc, 'FechaEmision' => $doc->FechaEmision]);

        $notas = $cliente->notasDeCredito()
            ->whereBetween('FechaEmision', [$desde, $hasta])
            ->get()
            ->map(fn ($doc) => ['tipo' => 'nota', 'documento' => $doc, 'FechaEmision' => $doc->FechaEmision]);

        $documentos = collect()
            ->merge($facturas)
            ->merge($debitos)
            ->merge($recibos)
            ->merge($notas)
            ->sortBy('FechaEmision')
            ->values();

        /*
        |--------------------------------------------------------------------------
        | Calcular saldo
        |--------------------------------------------------------------------------
        */
        $saldo = $cliente->SaldoSistemaAnterior;

        foreach ($documentos as $item) {
            if (in_array($item['tipo'], ['factura', 'debito'])) {
                $saldo += $item['documento']->Total;
            } else {
                $saldo -= $item['documento']->Total;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Generar PDF
        |--------------------------------------------------------------------------
        */
        $pdf = Pdf::loadView('ventas.resumen-cuenta-corriente.pdf', [
            'cliente'    => $cliente,
            'documentos' => $documentos,
            'saldo'      => $saldo,
            'desde'      => $desde,
            'hasta'      => $hasta,
        ])->setPaper('A4');

        /*
        |--------------------------------------------------------------------------
        | Enviar mail
        |--------------------------------------------------------------------------
        */
        Mail::send('emails.resumen-cuenta-corriente', [
            'cliente' => $cliente,
        ], function ($message) use ($emails, $pdf, $cliente) {

            $message->to($emails)
                    ->subject('Resumen de Cuenta Corriente')
                    ->attachData(
                        $pdf->output(),
                        "Resumen_Cuenta_Corriente_{$cliente->id}.pdf",
                        ['mime' => 'application/pdf']
                    );
        });

        return back()->with('success', 'Resumen de cuenta corriente enviado por mail correctamente.');
    }
    
    public function listadoDeIVA()
    {
        $pto_ventas = PuntoDeVenta::all();
        $articulos = Arti::all();

        $facturas = FacturaVenta::where('EsNotaDeDebito', 0)->get();
        $notas_de_credito = NotaCreditoVenta::all();
        $notas_de_debito = FacturaVenta::where('EsNotaDeDebito', 1)->get();

        $documentos = $facturas
            ->concat($notas_de_credito)
            ->concat($notas_de_debito);

        $documentos = $documentos->sortByDesc('FechaEmision');

        $documentos = $documentos->values();
        
        return view('ventas.listado-de-iva.index', compact('documentos', 'pto_ventas', 'articulos'));
    }

    public function buscarDocumentos()
    {
        return view('ventas.buscar-documentos.index');
    }

}
