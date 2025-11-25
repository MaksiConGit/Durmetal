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
use App\Models\CondicionVenta;
use App\Models\ConfiguracionGlobal;
use App\Models\DestinoCheque;
use App\Models\FacturaVenta;
use App\Models\ItemFacturaVenta;
use App\Models\ItemNotaEnvio;
use App\Models\ItemOrdenTrabajo;
use App\Models\NotaCreditoVenta;
use App\Models\NotaEnvio;
use App\Models\OrdenTrabajo;
use App\Models\PuntoDeVenta;
use App\Models\ReciboVenta;
use App\Models\Tratamiento;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        
        return view('ventas.ficha-del-cliente.show', compact('cliente', 'filtro'));
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
        $data['IdCondicionIva'] = $cliente->IdCondicionIva;
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
                
                $item->certificado->update([
                    'Nombre' => $itemData['NroPlano'],
                    'NroPlano' => $itemData['NroPlano'],
                    'IdUsuario' => Auth::id(),
                ]);
            }
        }

        return redirect()->back();
    }

    public function fichaDelClienteFacturaVentaCreate(Client $cliente)
    {
        $notas_de_envio = NotaEnvio::where('Estado', 'PENDIENTE')->where('IdCliente', $cliente->id)->get();
        $pto_ventas = PuntoDeVenta::all();
        $next_numero = FacturaVenta::max('Numero') + 1;
        $condiciones_venta = CondicionVenta::all();

        return view('ventas.ficha-del-cliente.factura-venta', compact('notas_de_envio', 'pto_ventas', 'next_numero', 'cliente', 'condiciones_venta'));
    }

    public function fichaDelClienteFacturaVentaStore(Request $request)
    {
        if (!$request->has('items') || empty($request->items)) {
            return redirect()->back()
                ->withErrors(['items' => 'Debe seleccionar al menos un ítem para crear la factura de venta.'])
                ->withInput();
        }

        $user_id = Auth::id();

        $cliente = Client::find($request->IdCliente);
    
        $data['Letra'] = 'A';
        $data['PuntoVenta'] = $request->PuntoVenta;
        $data['Numero'] = $request->Numero;
        $data['NumeroCompleto'] = "FC A 0001-0000$request->Numero";
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
        $data['IdCondicionIva'] = $cliente->IdCondicionIva;
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

        foreach ($request->items as $index => $itemData) {
            
            ItemFacturaVenta::create([
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

            $nota_envio = NotaEnvio::find($itemData['IdNotaEnvio']);

            $nota_envio->update(['Estado' => 'COMPLETO']);
            
        }

        return redirect()->route('ventas.ficha-del-cliente.show', $cliente);
    }

    public function fichaDelClienteReciboVentaCreate(Client $cliente)
    {
        $facturas_venta = FacturaVenta::where('Estado', 'PENDIENTE')->where('IdCliente', $cliente->id)->get();
        $pto_ventas = PuntoDeVenta::all();
        $next_numero = ReciboVenta::max('Numero') + 1;
        $bancos = Banco::all();

        return view('ventas.ficha-del-cliente.recibo-venta', compact('facturas_venta', 'pto_ventas', 'next_numero', 'cliente', 'bancos'));
    }

    public function fichaDelClienteNotaCreditoCreate(Client $cliente)
    {
        $ordenes_trabajo = OrdenTrabajo::where('');

        return view('ventas.ficha-del-cliente.nota-envio', compact('ordenes_trabajo'));
    }

    public function fichaDelClienteNotaDebitoCreate(Client $cliente)
    {
        $ordenes_trabajo = OrdenTrabajo::where('');

        return view('ventas.ficha-del-cliente.nota-envio', compact('ordenes_trabajo'));
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
