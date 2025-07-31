<?php

namespace App\Http\Controllers;

use App\Models\Chequecobro;
use App\Models\Client;
use App\Models\CondicionVenta;
use App\Models\ConfiguracionGlobal;
use App\Models\DestinoCheque;
use App\Models\FacturaVenta;
use App\Models\ItemOrdenTrabajo;
use App\Models\NotaEnvio;
use App\Models\OrdenTrabajo;
use App\Models\PuntoDeVenta;
use App\Models\ReciboVenta;
use App\Models\Tratamiento;
use Illuminate\Http\Request;

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

    public function fichaDelClienteShow(Client $cliente)
    {
        $ordenes_trabajo = $cliente->OrdenesTrabajo;
        $notas_de_envio = $cliente->notasDeEnvio;
        $facturas = $cliente->facturasVenta;
        $recibos = $cliente->recibosVenta;
        $notas_de_credito = $cliente->notasDeCredito;
        $notas_de_debito = $cliente->facturasVenta->where('EsNotaDeDebito', 1);
        $minutas = $cliente->minutas;

        return view('ventas.ficha-del-cliente.show', compact('cliente', 'ordenes_trabajo', 'notas_de_envio', 'facturas', 'recibos', 'notas_de_credito', 'notas_de_debito', 'minutas'));
    }

    public function listadoDeCheques()
    {
        $cheques_cobro = Chequecobro::all();
        $destinos_cheque = DestinoCheque::all();

        return view('ventas.listado-de-cheques.index', compact('cheques_cobro', 'destinos_cheque'));
    }

    public function valorizarTrabajos()
    {
        $ordenes_trabajo = OrdenTrabajo::where('');

        return view('ventas.valorizar-trabajos.index', compact('ordenes_trabajo'));
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

    public function fichaDelClienteNotaEnvioCreate(Client $cliente)
    {
        $ordenes_trabajo = OrdenTrabajo::where('IdCliente', $cliente->id)->get();

        $next_nota_numero = NotaEnvio::max('Numero') + 1;

        foreach ($ordenes_trabajo as $orden_trabajo) {

            foreach ($orden_trabajo->itemsOrdenTrabajo as $item_orden_trabajo) {

                $tratamientos[] = $item_orden_trabajo->tratamiento; 
                $items_orden_trabajo[] = $item_orden_trabajo;

            }

        }

        $pto_ventas = PuntoDeVenta::all();

        return view('ventas.ficha-del-cliente.nota-envio', compact('items_orden_trabajo', 'tratamientos', 'next_nota_numero', 'cliente', 'pto_ventas'));
    }

    public function fichaDelClienteFacturaVentaCreate(Client $cliente)
    {
        $notas_de_envio = NotaEnvio::where('Estado', 'PENDIENTE')->get();
        $pto_ventas = PuntoDeVenta::all();
        $next_numero = FacturaVenta::max('Numero') + 1;
        $condiciones_venta = CondicionVenta::all();

        return view('ventas.ficha-del-cliente.factura-venta', compact('notas_de_envio', 'pto_ventas', 'next_numero', 'cliente', 'condiciones_venta'));
    }

    public function fichaDelClienteReciboVentaCreate(Client $cliente)
    {
        $ordenes_trabajo = OrdenTrabajo::where('');

        return view('ventas.ficha-del-cliente.nota-envio', compact('ordenes_trabajo'));
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
    
}
