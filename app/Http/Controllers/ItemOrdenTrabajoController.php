<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreItemOrdenTrabajoRequest;
use App\Models\Client;
use App\Models\Dureza;
use App\Models\ItemOrdenTrabajo;
use App\Models\Material;
use App\Models\OrdenTrabajo;
use App\Models\PointOfSale;
use App\Models\PuntoDeVenta;
use App\Models\Tratamiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ItemOrdenTrabajoController extends Controller
{
    public function create(OrdenTrabajo $orden_trabajo, Request $request)
    {
        $count_items = ItemOrdenTrabajo::where('IdOrdenTrabajo', $orden_trabajo->id)->count() + 1;

        $durezas = Dureza::all();
        $tratamientos = Tratamiento::all();
        $materiales = Material::all();
        $pto_ventas = PuntoDeVenta::all();
        $clientes = Client::all();

        $punto_venta = $request->query('PuntoVenta');
        $id_cliente = $request->query('IdCliente');
        $numero = $request->query('Numero');
        $fecha_emision = $request->query('FechaEmision');
        $numero_remito_cliente = $request->query('NumeroRemitoCliente');

        return view('produccion.item-orden-trabajo.create', compact(
            'orden_trabajo',
            'count_items',
            'durezas',
            'tratamientos',
            'materiales',
            'pto_ventas',
            'clientes',
            'punto_venta',
            'id_cliente',
            'numero',
            'fecha_emision',
            'numero_remito_cliente'
        ));
    }

    public function store(StoreItemOrdenTrabajoRequest $request)
    {
        $data = $request->validated();

        $user_id = Auth::id();
    
        $data['FechaActualizacionEstado'] = now();
        $data['CreadoPor'] = $user_id;
        $data['FechaCreacion'] = now();
        $data['ActualizadoPor'] = $user_id;
        $data['FechaActualizacion'] = now();
        $data['Activo'] = 1;

        $data['NroDeposito'] = 1;
        $data['CodigoComplejidad'] = 1;
        $data['Coeficiente'] = '0.000';
        $data['PrecioUnitario'] = '0.000';
        $data['Total'] = '0.00';
        $data['AfectaPlanillaTurno'] = 1;
        $data['ControlarStock'] = 1;
        $data['CertificadoEmitido'] = 1;
        $data['CantidadCertificadosImpresos'] = 1;
        $data['CantidadCertificadosEnviadosPorCorreo'] = 1;
        $data['CantidadProgramaciones'] = 1;
        $data['ConNotaEnvio'] = 1;
        $data['IDEstadoConNotaEnvio'] = 1;
        $data['IDIdOrdenTrabajoIdMaterialIdTratamientoCodigoComplejidadEstado'] = 1;
        
        $item_orden_trabajo = ItemOrdenTrabajo::create($data);


        $orden_trabajo = OrdenTrabajo::find($item_orden_trabajo->IdOrdenTrabajo);

        $punto_venta = $request->input('PuntoVenta');
        $id_cliente = $request->input('IdCliente');
        $numero = $request->input('Numero');
        $fecha_emision = $request->input('FechaEmision');
        $numero_remito_cliente = $request->input('NumeroRemitoCliente');

        if ($orden_trabajo) {
            $orden_trabajo->PuntoVenta = $punto_venta;
            $orden_trabajo->IdCliente = $id_cliente;
            $orden_trabajo->Numero = $numero;
            $orden_trabajo->FechaEmision = $fecha_emision;
            $orden_trabajo->NumeroRemitoCliente = $numero_remito_cliente;
            $orden_trabajo->save();
        }
    
        return redirect()->route('orden-trabajo.edit', $item_orden_trabajo->IdOrdenTrabajo);
    }

    public function edit(ItemOrdenTrabajo $item_orden_trabajo)
    {   
        $durezas = Dureza::all();
        $tratamientos = Tratamiento::all();
        $materiales = Material::all();
        $pto_ventas = PuntoDeVenta::all();
        $clientes = Client::all();
        $orden_trabajo = $item_orden_trabajo->ordenTrabajo;

        return view('produccion.item-orden-trabajo.edit', compact('item_orden_trabajo', 'durezas', 'tratamientos', 'materiales', 'pto_ventas', 'clientes', 'orden_trabajo'));
    }

    public function update(StoreItemOrdenTrabajoRequest $request, ItemOrdenTrabajo $item_orden_trabajo)
    {
        $data = $request->validated();

        $user_id = Auth::id();
    
        $data['FechaActualizacionEstado'] = now();
        $data['CreadoPor'] = $user_id;
        $data['FechaCreacion'] = now();
        $data['ActualizadoPor'] = $user_id;
        $data['FechaActualizacion'] = now();
        $data['Activo'] = 1;

        $data['ItemNumero'] = 1;
        $data['NroDeposito'] = 1;
        $data['CodigoComplejidad'] = 1;
        $data['Coeficiente'] = '0.000';
        $data['PrecioUnitario'] = '0.000';
        $data['Total'] = '0.00';
        $data['AfectaPlanillaTurno'] = 1;
        $data['ControlarStock'] = 1;
        $data['CertificadoEmitido'] = 1;
        $data['CantidadCertificadosImpresos'] = 1;
        $data['CantidadCertificadosEnviadosPorCorreo'] = 1;
        $data['CantidadProgramaciones'] = 1;
        $data['ConNotaEnvio'] = 1;
        $data['IDEstadoConNotaEnvio'] = 1;
        $data['IDIdOrdenTrabajoIdMaterialIdTratamientoCodigoComplejidadEstado'] = 1;

        $item_orden_trabajo->update($data);
    
        return redirect()->route('orden-trabajo.show', $item_orden_trabajo->ordenTrabajo);
    }

    public function destroy(ItemOrdenTrabajo $item_orden_trabajo)
    {
        $orden_trabajo = $item_orden_trabajo->IdOrdenTrabajo;
        
        $item_orden_trabajo->delete();
    
        return redirect()->route('orden-trabajo.show', $orden_trabajo);
    }

}
