<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUSDARSRequest;
use App\Models\Arti;
use App\Models\Banco;
use App\Models\Chequecobro;
use App\Models\Client;
use App\Models\ClientType;
use App\Models\CondicionVenta;
use App\Models\ConfiguracionGlobal;
use App\Models\DestinoCheque;
use App\Models\FacturaVenta;
use App\Models\ItemNotaEnvio;
use App\Models\ItemOrdenTrabajo;
use App\Models\NotaCreditoVenta;
use App\Models\NotaEnvio;
use App\Models\OrdenTrabajo;
use App\Models\PuntoDeVenta;
use App\Models\ReciboVenta;
use App\Models\Tratamiento;
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
                ->with('error', 'Debe seleccionar al menos un ítem para crear la nota de envío.')
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
                'ItemNumero' => $index,
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

        return redirect()->route('ventas.ficha-del-cliente.show', $cliente);
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
        $user_id = Auth::id();

        $cliente = Client::find($request->IdCliente);
    
        $data['Letra'] = 'X';
        $data['PuntoVenta'] = $request->PuntoVenta;
        $data['Numero'] = $request->Numero;
        $data['NumeroCompleto'] = "FC X 0001-0000$request->Numero";
        $data['FechaEmision'] = now()->toDateString();
        $data['FechaVencimiento'] = now()->toDateString();
        $data['FechaEstadisticas'] = now()->toDateString();
        $data['TipoOperacion'] = 1;
        $data['CondicionPrecios'] = 1;
        $data['IdCliente'] = 1;
        $data['RazonSocial'] = 1;
        $data['TipoDocumentoCliente'] = 1;
        $data['Direccion'] = 1;
        $data['Localidad'] = 1;
        $data['IdCondicionIva'] = 1;
        $data['CondicionVenta'] = 1;
        $data['Neto'] = 1;
        $data['NetoNoGravado'] = 1;
        $data['Exento'] = 1;
        $data['IVA'] = 1;
        $data['ImpuestoInterno'] = 1;
        $data['Total'] = 1;
        $data['AjusteCtaCtePlanillaTurno'] = 1;
        $data['Estado'] = 1;
        $data['CAE'] = 1;
        $data['FechaVencimientoCAE'] = now()->toDateString();
        $data['IdSolicitudCAE'] = 1;
        $data['Observaciones'] = 1;
        $data['NumeroTurno'] = 1;
        $data['ReferenciaTurno'] = 1;
        $data['AfectarPlanillaTurno'] = 1;
        $data['EsNotaDeDebito'] = 1;
        $data['NroFacturaNotaDebito'] = 1;
        $data['EntregarMercaderiaConRemitos'] = 1;
        $data['FechaCreacion'] = now()->toDateString();
        $data['CreadoPor'] = $user_id;
        $data['FechaActualizacion'] = now()->toDateString();
        $data['ActualizadoPor'] = $user_id;
        $data['Activo'] = 1;
        $data['CantidadImpresiones'] = 1;
        $data['CantidadEnviosPorCorreo'] = 1;

        FacturaVenta::create($data);

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
