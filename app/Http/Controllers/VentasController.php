<?php

namespace App\Http\Controllers;

use App\Models\Chequecobro;
use App\Models\Client;
use App\Models\ConfiguracionGlobal;
use App\Models\DestinoCheque;
use App\Models\ItemOrdenTrabajo;
use App\Models\OrdenTrabajo;
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

    public function fichaDelClienteOrdenCreate(Client $cliente)
    {
        $next_orden_numero = OrdenTrabajo::max('Numero') + 1;

        $orden_trabajo = OrdenTrabajo::create([
                'PuntoVenta' => 1,
                'Numero' => $next_orden_numero,
        ]);

        return redirect()->route('orden-trabajo.edit', $orden_trabajo);
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
}
