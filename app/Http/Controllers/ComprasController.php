<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCuentaGastosRequest;
use App\Http\Requests\StoreFacturacompraRequest;
use App\Http\Requests\StoreMinutaCompraRequest;
use App\Http\Requests\StoreNotaCreditoCompraRequest;
use App\Http\Requests\StoreOrdenpagoRequest;
use App\Http\Requests\StoreProveedorRequest;
use App\Models\Chequepago;
use App\Models\City;
use App\Models\CuentaGastos;
use App\Models\CuentaOtrosEgresos;
use App\Models\Facturacompra;
use App\Models\Itemfacturacompra;
use App\Models\IvaCondition;
use App\Models\MinutaCompra;
use App\Models\MovimientoCuentaGastos;
use App\Models\NotaCreditoCompra;
use App\Models\Ordenpago;
use App\Models\Proveedor;
use App\Models\Province;
use App\Models\RetencionIIBB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComprasController extends Controller
{
    // Otros Egresos
    public function proveedoresIndex()
    {
        $proveedores = Proveedor::all();
        $cuentas_otros_egresos = CuentaOtrosEgresos::all();


        return view('compras.actualizaciones.proveedores.index', compact('proveedores', 'cuentas_otros_egresos'));
    }

    public function proveedoresCreate()
    {
        $localidades = City::all();
        $provincias = Province::all();
        $condiciones_IVA = IvaCondition::all();
        $retenciones_IIBB = RetencionIIBB::all();
        $cuentas_de_gastos = CuentaGastos::all();
        $next_id = Proveedor::max('id') + 1;

        return view('compras.actualizaciones.proveedores.create', compact('localidades', 'provincias', 'condiciones_IVA', 'retenciones_IIBB', 'cuentas_de_gastos', 'next_id'));
    }

    public function proveedoresStore(StoreProveedorRequest $request)
    {
        $data = $request->except('emails');

        $localidad = City::find($request->IdLocalidad);
        $provincia = $localidad->provincia;

        $data['Localidad'] = $localidad->Nombre;
        $data['Provincia'] = $provincia->Nombre;
        $data['SaldoSistemaAnterior'] = 0;
        $data['FechaCreacion'] = now();
        $data['CreadoPor'] = Auth::id();
        $data['FechaActualizacion'] = now();
        $data['ActualizadoPor'] = Auth::id();
        $data['Activo'] = 1;

        $proveedor = Proveedor::create($data);

        foreach ($request->emails as $email) {
            if ($email) {
                $proveedor->emails()->create([
                    'IdProveedor' => $proveedor->id,
                    'Email' => $email,
                    'FechaCreacion' => now(),
                    'CreadoPor' => Auth::id(),
                    'FechaActualizacion' => now(),
                    'ActualizadoPor' => Auth::id(),
                    'Activo' => 1,
                    'IdProveedorEmail' => $proveedor->id . ',' . $email,
                ]);
            }
        }    
        return redirect()->route('compras.actualizaciones.proveedores.index');
    }

    public function proveedoresEdit(Proveedor $proveedor)
    {
        $localidades = City::all();
        $provincias = Province::all();
        $condiciones_IVA = IvaCondition::all();
        $retenciones_IIBB = RetencionIIBB::all();
        $cuentas_de_gastos = CuentaGastos::all();

        return view('compras.actualizaciones.proveedores.edit', compact('proveedor', 'localidades', 'provincias', 'condiciones_IVA', 'retenciones_IIBB', 'cuentas_de_gastos'));
    }

    public function proveedoresUpdate(StoreProveedorRequest $request, Proveedor $proveedor)
    {
        $data = $request->except('emails');

        $localidad = City::find($request->IdLocalidad);
        $provincia = $localidad->provincia;

        $data['Localidad'] = $localidad->Nombre;
        $data['Provincia'] = $provincia->Nombre;
        $data['FechaActualizacion'] = now();
        $data['ActualizadoPor'] = Auth::id();

        $proveedor->update($data);

        $proveedor->emails()->delete();
    
        foreach ($request->emails as $email) {
            if ($email) {
                $proveedor->emails()->create([
                    'IdProveedor' => $proveedor->id,
                    'Email' => $email,
                    'FechaCreacion' => now(),
                    'CreadoPor' => Auth::id(),
                    'FechaActualizacion' => now(),
                    'ActualizadoPor' => Auth::id(),
                    'Activo' => 1,
                    'IdProveedorEmail' => $proveedor->id . ',' . $email,
                ]);
            }
        }    
    
        return redirect()->route('compras.actualizaciones.proveedores.index');
    }

    public function proveedoresDestroy(Proveedor $proveedor)
    {
        $proveedor->emails()->delete();

        $proveedor->delete();
    
        return redirect()->route('compras.actualizaciones.proveedores.index');
    }

    // Cuentas de Gastos
    public function cuentaDeGastosIndex()
    {
        $cuentas_de_gastos = CuentaGastos::all();

        return view('compras.actualizaciones.cuentas-de-gastos.index', compact('cuentas_de_gastos'));
    }

    public function cuentaDeGastosCreate()
    {
        return view('compras.actualizaciones.cuentas-de-gastos.create');
    }

    public function cuentaDeGastosStore(StoreCuentaGastosRequest $request)
    {
        $data = $request->all();

        $data['FechaCreacion'] = now();
        $data['CreadoPor'] = Auth::id();
        $data['FechaActualizacion'] = now();
        $data['ActualizadoPor'] = Auth::id();
        $data['Activo'] = 1;
        $data['Archivado'] = 0;

        CuentaGastos::create($data);

        return redirect()->route('compras.actualizaciones.cuentas-de-gastos.index');
    }

    public function cuentaDeGastosEdit(CuentaGastos $cuenta_de_gastos)
    {
        return view('compras.actualizaciones.cuentas-de-gastos.edit', compact('cuenta_de_gastos'));
    }

    public function cuentaDeGastosUpdate(StoreCuentaGastosRequest $request, CuentaGastos $cuenta_de_gastos)
    {
        $data = $request->all();

        $data['FechaActualizacion'] = now();
        $data['ActualizadoPor'] = Auth::id();

        $cuenta_de_gastos->update($data);

        return redirect()->route('compras.actualizaciones.cuentas-de-gastos.index');
    }

    public function cuentaDeGastosDestroy(CuentaGastos $cuenta_de_gastos)
    {
        foreach ($cuenta_de_gastos->proveedores as $proveedor) {
            $proveedor->update([
                'IdCuentaGastos' => null
            ]);
        }

        $cuenta_de_gastos->delete();
    
        return redirect()->route('compras.actualizaciones.cuentas-de-gastos.index');
    }

    // Listado de cheques proveedores
    public function listadoDeChequesProveedores()
    {
        $cheques_pago = Chequepago::all();

        return view('compras.listado-de-cheques-proveedores.index', compact('cheques_pago'));
    }

    // Listado de IVA 
    public function listadoDeIva()
    {
        $facturas_compra = Facturacompra::all();
        $notas_credito_compra = NotaCreditoCompra::all();
        $cuentas_de_gastos = CuentaGastos::all();

        return view('compras.listado-de-iva.index', compact('facturas_compra', 'notas_credito_compra', 'cuentas_de_gastos'));
    }

    // Resumen mensual de egresos 
    public function resumenMensualEgresos()
    {
        $cuentas_gastos = CuentaGastos::all();
        $movimientos_cuenta_gastos = MovimientoCuentaGastos::all();
        $cuentas_otros_egresos = CuentaOtrosEgresos::all();
        $items_facturas_compra = Itemfacturacompra::all();

        return view('compras.resumen-mensual-egresos.index', compact('cuentas_gastos', 'cuentas_otros_egresos', 'items_facturas_compra', 'movimientos_cuenta_gastos'));
    }

    // Resumen de cuenta corriente proveedor
    public function resumenCuentaCorriente()
    {
        $proveedor_id = request('proveedor_id');

        return view('compras.resumen-cuenta-corriente.index', compact('proveedor_id'));
    }

    // Listado de movimientos por cuentas de gastos
    public function listadoMovimientosCuentasGastos()
    {
        $cuentas_de_gastos = CuentaGastos::all();   
        $facturas_compra = Facturacompra::orderBy('FechaEmision', 'asc')->get();
        $notas_credito_compra = NotaCreditoCompra::orderBy('FechaEmision', 'asc')->get();

        return view('compras.listado-movimientos-por-cuentas-gastos.index', compact('cuentas_de_gastos', 'facturas_compra', 'notas_credito_compra'));
    }

    // Listado de saldos de proveedores
    public function listadoSaldosProveedores()
    {
        $proveedores = Proveedor::all();
        $total_general = 0;

        foreach ($proveedores as $proveedor) {

            $items_facturas_total = $proveedor->facturasCompra->flatMap->items->sum('Total');
            $items_notas_debito_total = $proveedor->notasDebitoCompra->flatMap->items->sum('Total');
            $items_notas_credito_total = $proveedor->notasCreditoCompra->flatMap->items->sum('Total');

            $proveedor->saldo = $proveedor->SaldoSistemaAnterior
                + $items_facturas_total
                + $items_notas_debito_total
                - $items_notas_credito_total;

            $total_general += $proveedor->saldo;

            $factura_mas_atrasada = FacturaCompra::where('IdProveedor', $proveedor->id)
                ->where('Estado', 'PENDIENTE')
                ->orderBy('FechaVencimiento', 'asc')
                ->select('FechaEmision', 'FechaVencimiento')
                ->first();

            if ($factura_mas_atrasada) {
                $proveedor->factura_atrasada_emision = $factura_mas_atrasada->FechaEmision;
                $proveedor->factura_atrasada_vencimiento = $factura_mas_atrasada->FechaVencimiento;
            } else {
                $proveedor->factura_atrasada_emision = null;
                $proveedor->factura_atrasada_vencimiento = null;
            }
        }

        return view('compras.listado-de-saldos-proveedores.index', compact('proveedores', 'total_general'));
    }


    // Ficha del proveedor
    public function fichaDelProveedorIndex()
    {
        $proveedores = Proveedor::all();

        return view('compras.ficha-del-proveedor.index', compact('proveedores'));
    }

    public function fichaDelProveedorShow(Proveedor $proveedor)
    {
        $facturas_compra = $proveedor->facturasCompra;
        $ordenes_pago = $proveedor->ordenesPago;
        $notas_credito_compra = $proveedor->notasCreditoCompra;
        $notas_debito_compra = $proveedor->notasDebitoCompra;
        $minutas_compra = $proveedor->minutasCompra;

        return view('compras.ficha-del-proveedor.show', compact('proveedor', 'facturas_compra', 'ordenes_pago', 'notas_credito_compra', 'notas_debito_compra', 'minutas_compra'));
    }

    // Factura Compra CRUD
    public function fichaFacturaCompraCreate(Proveedor $proveedor)
    {
        return view('compras.ficha-del-proveedor.factura-compra.create', compact('proveedor'));
    }

    public function fichaFacturaCompraStore(StoreFacturacompraRequest $request)
    {
        $data = $request->all();

        $data['FechaCreacion'] = now();
        $data['CreadoPor'] = Auth::id();
        $data['FechaActualizacion'] = now();
        $data['ActualizadoPor'] = Auth::id();
        $data['Activo'] = 1;

        $factura_compra = Facturacompra::create($data);

        $proveedor = Proveedor::find($factura_compra->IdProveedor);

        return redirect()->route('compras.ficha-del-proveedor.show', $proveedor);
    }

    public function fichaFacturaCompraEdit(Facturacompra $factura_compra)
    {
        return view('compras.ficha-del-proveedor.factura-compra.edit', compact('factura_compra'));
    }

    public function fichaFacturaCompraUpdate(StoreFacturacompraRequest $request, Facturacompra $factura_compra)
    {
        $data = $request->all();

        $data['FechaActualizacion'] = now();
        $data['ActualizadoPor'] = Auth::id();
        $data['Activo'] = 1;

        $factura_compra->update($data);

        $proveedor = Proveedor::find($factura_compra->IdProveedor);

        return redirect()->route('compras.ficha-del-proveedor.show', $proveedor);
    }

    public function fichaFacturaCompraDestroy(Facturacompra $factura_compra)
    {
        foreach ($factura_compra->items as $item_factura_compra) {
            $item_factura_compra->delete();
        }

        foreach ($factura_compra->notasCredito as $nota_credito) {
            $nota_credito->update([
                'IdFacturaCompra' => null
            ]);
        }

        $proveedor = Proveedor::find($factura_compra->IdProveedor);

        $factura_compra->delete();

        return redirect()->route('compras.ficha-del-proveedor.show', $proveedor);
    }

    // Orden Pago CRUD
    public function fichaOrdenPagoCreate(Proveedor $proveedor)
    {
        return view('compras.ficha-del-proveedor.orden-pago.create', compact('proveedor'));
    }

    public function fichaOrdenPagoStore(StoreOrdenpagoRequest $request)
    {
        $data = $request->all();

        $data['FechaCreacion'] = now();
        $data['CreadoPor'] = Auth::id();
        $data['FechaActualizacion'] = now();
        $data['ActualizadoPor'] = Auth::id();
        $data['Activo'] = 1;

        $orden_pago = Ordenpago::create($data);

        $proveedor = Proveedor::find($orden_pago->IdProveedor);

        return redirect()->route('compras.ficha-del-proveedor.show', $proveedor);
    }

    public function fichaOrdenPagoEdit(Ordenpago $orden_pago)
    {
        return view('compras.ficha-del-proveedor.orden-pago.edit', compact('orden_pago'));
    }

    public function fichaOrdenPagoUpdate(StoreOrdenpagoRequest $request, Ordenpago $orden_pago)
    {
        $data = $request->all();

        $data['FechaActualizacion'] = now();
        $data['ActualizadoPor'] = Auth::id();
        $data['Activo'] = 1;

        $orden_pago->update($data);

        $proveedor = Proveedor::find($orden_pago->IdProveedor);

        return redirect()->route('compras.ficha-del-proveedor.show', $proveedor);
    }

    public function fichaOrdenPagoDestroy(Ordenpago $orden_pago)
    {
        foreach ($orden_pago->pagos as $pago) {

            foreach ($pago->chequesPago as $cheque_pago) {

                $cheque_pago->delete();

            }

            $pago->delete();
        }

        $proveedor = Proveedor::find($orden_pago->IdProveedor);

        $orden_pago->delete();

        return redirect()->route('compras.ficha-del-proveedor.show', $proveedor);
    }

    // Notas de Credito CRUD
    public function fichaNotaCreditoCreate(Proveedor $proveedor)
    {
        return view('compras.ficha-del-proveedor.nota-credito.create', compact('proveedor'));
    }

    public function fichaNotaCreditoStore(StoreNotaCreditoCompraRequest $request)
    {
        $data = $request->all();

        $data['FechaCreacion'] = now();
        $data['CreadoPor'] = Auth::id();
        $data['FechaActualizacion'] = now();
        $data['ActualizadoPor'] = Auth::id();
        $data['Activo'] = 1;

        $nota_credito = NotaCreditoCompra::create($data);

        $proveedor = Proveedor::find($nota_credito->IdProveedor);

        return redirect()->route('compras.ficha-del-proveedor.show', $proveedor);
    }

    public function fichaNotaCreditoEdit(NotaCreditoCompra $nota_credito)
    {
        return view('compras.ficha-del-proveedor.nota-credito.edit', compact('nota_credito'));
    }

    public function fichaNotaCreditoUpdate(StoreNotaCreditoCompraRequest $request, NotaCreditoCompra $nota_credito)
    {
        $data = $request->all();

        $data['FechaActualizacion'] = now();
        $data['ActualizadoPor'] = Auth::id();
        $data['Activo'] = 1;

        $nota_credito->update($data);

        $proveedor = Proveedor::find($nota_credito->IdProveedor);

        return redirect()->route('compras.ficha-del-proveedor.show', $proveedor);
    }

    public function fichaNotaCreditoDestroy(NotaCreditoCompra $nota_credito)
    {
        foreach ($nota_credito->items as $item_nota_credito) {
            $item_nota_credito->delete();
        }

        $proveedor = Proveedor::find($nota_credito->IdProveedor);

        $nota_credito->delete();

        return redirect()->route('compras.ficha-del-proveedor.show', $proveedor);
    }

    // Nota de Débito CRUD
    public function fichaNotaDebitoCreate(Proveedor $proveedor)
    {
        return view('compras.ficha-del-proveedor.nota-debito.create', compact('proveedor'));
    }

    public function fichaNotaDebitoStore(StoreFacturacompraRequest $request)
    {
        $data = $request->all();

        $data['EsNotaDeDebito'] = 1;

        $data['FechaCreacion'] = now();
        $data['CreadoPor'] = Auth::id();
        $data['FechaActualizacion'] = now();
        $data['ActualizadoPor'] = Auth::id();
        $data['Activo'] = 1;

        $nota_debito = Facturacompra::create($data);

        $proveedor = Proveedor::find($nota_debito->IdProveedor);

        return redirect()->route('compras.ficha-del-proveedor.show', $proveedor);
    }

    public function fichaNotaDebitoEdit(Facturacompra $nota_debito)
    {
        return view('compras.ficha-del-proveedor.nota-debito.edit', compact('nota_debito'));
    }

    public function fichaNotaDebitoUpdate(StoreFacturacompraRequest $request, Facturacompra $nota_debito)
    {
        $data = $request->all();

        $data['FechaActualizacion'] = now();
        $data['ActualizadoPor'] = Auth::id();
        $data['Activo'] = 1;

        $nota_debito->update($data);

        $proveedor = Proveedor::find($nota_debito->IdProveedor);

        return redirect()->route('compras.ficha-del-proveedor.show', $proveedor);
    }

    public function fichaNotaDebitoDestroy(Facturacompra $nota_debito)
    {
        foreach ($nota_debito->items as $item_nota_debito) {
            $item_nota_debito->delete();
        }

        $proveedor = Proveedor::find($nota_debito->IdProveedor);

        $nota_debito->delete();

        return redirect()->route('compras.ficha-del-proveedor.show', $proveedor);
    }

    // Minutas CRUD
    public function fichaMinutaCreate(Proveedor $proveedor)
    {
        return view('compras.ficha-del-proveedor.minuta.create', compact('proveedor'));
    }

    public function fichaMinutaStore(StoreMinutaCompraRequest $request)
    {
        $data = $request->all();

        $data['FechaCreacion'] = now();
        $data['CreadoPor'] = Auth::id();
        $data['FechaActualizacion'] = now();
        $data['ActualizadoPor'] = Auth::id();
        $data['Activo'] = 1;

        $minuta = MinutaCompra::create($data);

        $proveedor = Proveedor::find($minuta->IdProveedor);

        return redirect()->route('compras.ficha-del-proveedor.show', $proveedor);
    }

    public function fichaMinutaEdit(MinutaCompra $minuta)
    {
        return view('compras.ficha-del-proveedor.minuta.edit', compact('minuta'));
    }

    public function fichaMinutaUpdate(StoreMinutaCompraRequest $request, MinutaCompra $minuta)
    {
        $data = $request->all();

        $data['FechaActualizacion'] = now();
        $data['ActualizadoPor'] = Auth::id();
        $data['Activo'] = 1;

        $minuta->update($data);

        $proveedor = Proveedor::find($minuta->IdProveedor);

        return redirect()->route('compras.ficha-del-proveedor.show', $proveedor);
    }

    public function fichaMinutaDestroy(MinutaCompra $minuta_compra)
    {
        foreach ($minuta_compra->items as $item_minuta_compra) {
            $item_minuta_compra->delete();
        }

        $proveedor = Proveedor::find($minuta_compra->IdProveedor);

        $minuta_compra->delete();

        return redirect()->route('compras.ficha-del-proveedor.show', $proveedor);
    }

    // Buscar comprobantes
    public function buscarComprobantes()
    {
        $proveedores = Proveedor::all();

        $proveedor = Proveedor::first();

        $facturas_compra = $proveedor->facturasCompra;
        $notas_debito_compra = $proveedor->notasDebitoCompra;
        $notas_credito_compra = $proveedor->notasCreditoCompra;
        $ordenes_pago = $proveedor->ordenesPago;

        $documentos = $facturas_compra
            ->concat($notas_debito_compra)
            ->concat($notas_credito_compra)
            ->concat($ordenes_pago);

        $documentos = $documentos->sortByDesc('FechaEmision')->values();

        return view('compras.buscar-comprobantes.index', compact('proveedores', 'proveedor', 'facturas_compra', 'notas_debito_compra', 'notas_credito_compra', 'ordenes_pago', 'documentos'));
    }
}
