<?php

namespace App\Http\Controllers;

use App\Models\Arti;
use App\Models\Banco;
use App\Models\Chequecobro;
use App\Models\Client;
use App\Models\ClientType;
use App\Models\CondicionVenta;
use App\Models\ConfiguracionGlobal;
use App\Models\DestinoCheque;
use App\Models\FacturaVenta;
use App\Models\ItemOrdenTrabajo;
use App\Models\NotaCreditoVenta;
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

    public function fichaDelClienteNotaEnvioCreate(Client $cliente)
    {
        $ordenes_trabajo = OrdenTrabajo::where('Estado', 'PENDIENTE')->where('IdCliente', $cliente->id)->get();

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
        $notas_de_envio = NotaEnvio::where('Estado', 'PENDIENTE')->where('IdCliente', $cliente->id)->get();
        $pto_ventas = PuntoDeVenta::all();
        $next_numero = FacturaVenta::max('Numero') + 1;
        $condiciones_venta = CondicionVenta::all();

        return view('ventas.ficha-del-cliente.factura-venta', compact('notas_de_envio', 'pto_ventas', 'next_numero', 'cliente', 'condiciones_venta'));
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
        $clientes = Client::all();

        foreach ($clientes as $cliente) {

            $nota_envio_total = NotaEnvio::where('IdCliente', $cliente->id)->sum('Total');
            $recibo_total = ReciboVenta::where('IdCliente', $cliente->id)->sum('Total');
            $nota_credito_total = NotaCreditoVenta::where('IdCliente', $cliente->id)->sum('Total');

            $cliente->saldo = $cliente->SaldoSistemaAnterior
                + $nota_envio_total
                - $recibo_total
                - $nota_credito_total;

            $factura_mas_atrasada = FacturaVenta::where('IdCliente', $cliente->id)
                ->where('Estado', 'PENDIENTE')
                ->orderBy('FechaVencimiento', 'asc')
                ->select('FechaEmision', 'FechaVencimiento')
                ->first();

            if ($factura_mas_atrasada) {
                $cliente->factura_atrasada_emision = $factura_mas_atrasada->FechaEmision;
                $cliente->factura_atrasada_vencimiento = $factura_mas_atrasada->FechaVencimiento;
            } else {
                $cliente->factura_atrasada_emision = null;
                $cliente->factura_atrasada_vencimiento = null;
            }
        }

        return view('ventas.listado-de-saldos.index', compact('clientes'));
    }

    public function resumenCuentaCorriente()
    {
        $clientes = Client::all();

        $cliente = Client::find(1);

        $facturas = $cliente->facturasVenta;
        $recibos = $cliente->recibosVenta;

        return view('ventas.resumen-cuenta-corriente.index', compact('clientes', 'facturas', 'recibos', 'cliente'));
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
        $cliente = Client::find(1);

        $clientes = Client::all();

        $notas_de_envio = $cliente->notasDeEnvio;
        $facturas = $cliente->facturasVenta->where('EsNotaDeDebito', 0);;
        $notas_de_debito = $cliente->facturasVenta->where('EsNotaDeDebito', 1);
        $notas_de_credito = $cliente->notasDeCredito;
        $recibos = $cliente->recibosVenta;

        $documentos = $facturas
            ->concat($notas_de_envio)
            ->concat($facturas)
            ->concat($notas_de_debito)
            ->concat($notas_de_credito)
            ->concat($recibos);

        $documentos = $documentos->sortByDesc('FechaEmision');

        $documentos = $documentos->values();

        return view('ventas.buscar-documentos.index', compact('cliente', 'notas_de_envio', 'facturas', 'notas_de_debito', 'notas_de_credito', 'recibos', 'documentos', 'clientes'));
    }

}
