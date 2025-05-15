<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreItemOrdenTrabajoRequest;
use App\Models\Dureza;
use App\Models\ItemOrdenTrabajo;
use App\Models\Material;
use App\Models\OrdenTrabajo;
use App\Models\PointOfSale;
use App\Models\Tratamiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ItemOrdenTrabajoController extends Controller
{
    public function create(OrdenTrabajo $orden_trabajo)
    {
        $next_item_id = ItemOrdenTrabajo::max('id') + 1;

        $durezas = Dureza::all();
        $tratamientos = Tratamiento::all();
        $materiales = Material::all();
        // cc?

        return view('item-orden-trabajo.create', compact('orden_trabajo', 'next_item_id', 'durezas', 'tratamientos', 'materiales'));
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
        
        $item_orden_trabajo = ItemOrdenTrabajo::create($data);

    
        return redirect()->route('orden-trabajo.edit', $item_orden_trabajo->IdOrdenTrabajo);
    }

    public function edit(ItemOrdenTrabajo $item_orden_trabajo)
    {   
        $durezas = Dureza::all();
        $tratamientos = Tratamiento::all();
        $materiales = Material::all();

        return view('item-orden-trabajo.edit', compact('item_orden_trabajo', 'durezas', 'tratamientos', 'materiales'));
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
