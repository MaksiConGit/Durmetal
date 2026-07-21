<?php

namespace App\Livewire;

use App\Models\Client;
use App\Models\Dureza;
use App\Models\Material;
use App\Models\Tratamiento;
use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\OrdenTrabajo;
use App\Models\ItemOrdenTrabajo;
use App\Models\Certificado;

class OrdenTrabajoEdit extends Component
{
    public $selectedId = null;
    public $selectedIdItem = null;
    public $orden_trabajo;
    public $items_orden_trabajo;
    public $clientes;
    public $numero;
    public $pto_ventas;

    public $expandedId = null;
    
    public $cliente_id = null;
    public $cliente_nombre = null;
    public array $items_orden_trabajo_edit = [];
    public $newItems = [];
    public $tempId = -1;

    public $fecha_emision;
    public $pto_venta_seleccionado_id;
    public $numero_remito_cliente = null;
    public $observaciones;

    public $materialesMap;
    public $tratamientosMap;
    public $durezasMap;

    public $searchTratamiento = '';
    public $searchMaterial = '';
    public $searchDureza = '';


    public $activeTabParametros = 'custom-tabs-1';

    // protected $rules = [
    //     // ITEMS
    //     'facturas_seleccionadas' => 'required|array|min:1',
    //     'facturas_seleccionadas.*.IdFacturaVenta' => 'required|exists:factura_venta,id',
    //     'facturas_seleccionadas.*.Total' => 'required|numeric|min:0.01',
    // ];

    public function setActiveTabParametros($tabId)
    {
        $this->activeTabParametros = $tabId;
    }

    public function selectClient($id)
    {
        $this->selectedId = $id;
    }

    public function getTratamientosFiltradosProperty()
    {
        return \App\Models\Tratamiento::query()
            ->when($this->searchTratamiento, function ($query) {
                $query->where('Nombre', 'like', '%' . $this->searchTratamiento . '%');
            })
            ->orderBy('Nombre')
            ->get();
    }

    public function getMaterialesFiltradosProperty()
    {
        return \App\Models\Material::query()
            ->when($this->searchMaterial, function ($query) {
                $query->where('Nombre', 'like', '%' . $this->searchMaterial . '%');
            })
            ->orderBy('Nombre')
            ->get();
    }

    public function getDurezasFiltradasProperty()
    {
        return \App\Models\Dureza::query()
            ->when($this->searchDureza, function ($query) {
                $query->where('Nombre', 'like', '%' . $this->searchDureza . '%');
            })
            ->orderBy('Nombre')
            ->get();
    }

    public function validar()
    {
        try {

            foreach ($this->newItems as $index => $item) {

                $descripcion = $item['Descripcion'] ?? null;
                $cantidad = $item['Cantidad'] ?? null;

                // 🔴 Validar descripción
                if (empty(trim($descripcion))) {
                    $this->addError(
                        "newItems.$index.Descripcion",
                        "El item debe tener descripción."
                    );

                    $this->dispatch('error-modal');
                    return;
                }

                $this->newItems[$index]['is_new'] = false;
            }

            $this->dispatch('close-all');

        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->dispatch('error-modal');
            throw $e;
        }
    }

    public function guardar()
    {
        DB::beginTransaction();

        try {

            $cliente = $this->cliente_id ? Client::find($this->cliente_id) : null;

            // 1. CREAR ORDEN DE TRABAJO
            $orden = $this->orden_trabajo
                ? OrdenTrabajo::find($this->orden_trabajo->id)
                : new OrdenTrabajo();

            $isNew = !$orden->exists;

            $orden->PuntoVenta = $this->pto_venta_seleccionado_id ?? 1;
            $orden->FechaEmision = $this->fecha_emision;
            $orden->NumeroRemitoCliente = $this->numero_remito_cliente ?? null;

            $orden->IdCliente = $this->cliente_id;
            $orden->RazonSocial = $cliente->Nombre ?? null;
            $orden->IdCondicionIva = $cliente->IdCondicionIVA ?? null;
            $orden->TipoDocumentoCliente = $cliente->TipoDocumento ?? null;
            $orden->NumeroDocumentoCliente = $cliente->NroDocumento ?? null;
            $orden->Direccion = $cliente->Domicilio ?? null;
            $orden->Localidad = $cliente->localidad->Nombre ?? null;
            $orden->Provincia = $cliente->localidad->provincia->Nombre ?? null;

            $orden->Archivado = $this->archivado ?? 0;

            if ($isNew) {

                $orden->Letra = 'X';
                $orden->Numero = $this->numero ?? 0;

                $orden->NumeroCompleto =
                    "OT X 0001-" . str_pad($orden->Numero, 8, "0", STR_PAD_LEFT);

                $orden->Estado = "PENDIENTE";
                $orden->Total = 0;
                $orden->Observaciones = null;

                $orden->NumeroTurno = 0;
                $orden->ReferenciaTurno = 0;
                $orden->AjusteCtaCtePlanillaTurno = 0;

                $orden->AfectarPlanillaTurno = 0;
                $orden->CondicionPrecios = 'A';

                $orden->PuntoVentaNumero = 0;
                $orden->IdClienteEstado = 0;
                $orden->IdClienteFechaEmisionPuntoVentaNumero = 0;

                $orden->CantidadImpresiones = 0;
                $orden->CantidadEnviosPorCorreo = 0;

                $orden->CreadoPor = auth()->id();
                $orden->FechaCreacion = now();
            }

            $orden->ActualizadoPor = auth()->id();
            $orden->FechaActualizacion = now();

            $orden->Activo = 1;
            $orden->FechaVencimiento = now();

            // $orden->Letra = 'X';
            // $orden->PuntoVenta = $this->pto_venta_seleccionado_id ?? 1;
            // $orden->Numero = $this->numero ?? 0;
            // $orden->NumeroCompleto = "OT X 0001-" . str_pad($orden->Numero, 8, "0", STR_PAD_LEFT);
            // $orden->NumeroRemitoCliente = $this->numero_remito_cliente ?? null;
            // $orden->FechaEmision = $this->fecha_emision;
            // $orden->FechaVencimiento = now();
            // $orden->AfectarPlanillaTurno = 0;
            // $orden->CondicionPrecios = 'A';
            // $orden->IdCliente = $this->cliente_id;
            // $orden->RazonSocial = $cliente->Nombre ?? null;
            // $orden->IdCondicionIva = $cliente->IdCondicionIVA ?? null;
            // $orden->TipoDocumentoCliente = $cliente->TipoDocumento ?? null;
            // $orden->NumeroDocumentoCliente = $cliente->NroDocumento ?? null;
            // $orden->Direccion = $cliente->Domicilio ?? null;
            // $orden->Localidad = $cliente->localidad->Nombre ?? null;
            // $orden->Provincia = $cliente->localidad->provincia->Nombre ?? null;
            // $orden->Estado = "PENDIENTE";
            // $orden->Total = 0;
            // $orden->Observaciones = null;
            // $orden->NumeroTurno = 0;
            // $orden->ReferenciaTurno = 0;
            // $orden->AjusteCtaCtePlanillaTurno = 0;
            // $orden->IdEntorno = null;
            // $orden->CreadoPor = auth()->id();
            // $orden->FechaCreacion = now();
            // $orden->ActualizadoPor = auth()->id();
            // $orden->FechaActualizacion = now();
            // $orden->Activo = 1;
            // $orden->PuntoVentaNumero = 0;
            // $orden->IdClienteEstado = 0;
            // $orden->IdClienteFechaEmisionPuntoVentaNumero = 0;
            // $orden->CantidadImpresiones = 0;
            // $orden->CantidadEnviosPorCorreo = 0;
            // $orden->Archivado = 0;

            $orden->save();

            // 2. CREAR ITEMS (EQUIVALENTE A TU FOREACH $request->items)
            foreach ($this->newItems as $item) {

                $isNew = $item['id'] < 0; // o is_new si lo tenés

                if ($isNew) {

                    // CREATE
                    $itemModel = $orden->itemsOrdenTrabajo()->create([
                        'Descripcion' => $item['Descripcion'],
                        'Cantidad' => $item['Cantidad'],
                        'Peso' => $item['Peso'],
                        'ItemNumero' => $orden->itemsOrdenTrabajo()->max('ItemNumero') + 1,
                        'IdMaterial' => $item['material_id'],
                        'IdTratamiento' => $item['tratamiento_id'],
                        'IdDureza' => $item['dureza_id'],
                        'NroPlano' => $item['NroPlano'] ?? null,
                        'DurezaSolicitadaMinima' => $item['DurezaSolicitadaMinima'],
                        'DurezaSolicitadaMaxima' => $item['DurezaSolicitadaMaxima'],

                        'NroDeposito' => 0,
                        'CodigoComplejidad' => 0,
                        'Coeficiente' => 0,
                        'PrecioUnitario' => 0,
                        'Total' => 0,
                        'AfectaPlanillaTurno' => 0,
                        'ControlarStock' => 0,
                        'FechaActualizacionEstado' => now(),
                        'CertificadoEmitido' => 0,
                        'CantidadCertificadosImpresos' => 0,
                        'CantidadCertificadosEnviadosPorCorreo' => 0,
                        'Observaciones' => null ,
                        'CantidadProgramaciones' => 0,
                        'ConNotaEnvio' => 0,
                        'IDEstadoConNotaEnvio' => 0,
                        'IDIdOrdenTrabajoIdMaterialIdTratamientoCodigoComplejidadEstado' => 0,

                        'CreadoPor' => auth()->id(),
                        'FechaCreacion' => now(),
                        'ActualizadoPor' => auth()->id(),
                        'FechaActualizacion' => now(),
                        'Activo' => 1,
                        'Estado' => 'PENDIENTE',
                    ]);

                } else {

                    // UPDATE
                    $itemModel = ItemOrdenTrabajo::find($item['id']);

                    if ($itemModel) {
                        $itemModel->update([
                            'Descripcion' => $item['Descripcion'],
                            'Cantidad' => $item['Cantidad'],
                            'Peso' => $item['Peso'],
                            'IdMaterial' => $item['material_id'],
                            'IdTratamiento' => $item['tratamiento_id'],
                            'IdDureza' => $item['dureza_id'],
                            'NroPlano' => $item['NroPlano'] ?? null,
                            'DurezaSolicitadaMinima' => $item['DurezaSolicitadaMinima'],
                            'DurezaSolicitadaMaxima' => $item['DurezaSolicitadaMaxima'],

                            'ActualizadoPor' => auth()->id(),
                            'FechaActualizacion' => now(),
                        ]);
                    }
                }

                // CERTIFICADO (igual lógica)
                if (!empty($item['NroPlano'])) {

                    Certificado::updateOrCreate(
                        ['IdItemOrdenTrabajo' => $itemModel->id],
                        [
                            'Nombre' => $item['NroPlano'],
                            'NroPlano' => $item['NroPlano'],
                            'Observaciones' => null,
                            'CantidadImpresiones' => 0,
                            'CantidadEnviosPorCorreo' => 0,
                            'Cantidad' => $itemModel->Cantidad,
                            'IdUsuario' => auth()->id(),
                            'Predeterminado' => 1,
                        ]
                    );
                }
            }

            DB::commit();

            $this->dispatch('success', message: 'Orden creada correctamente');

            return redirect()->route('orden-trabajo.show', $orden->id);

        } catch (\Exception $e) {

            DB::rollBack();

            $this->dispatch('error-modal');

            throw $e;
        }
    }

    public function cancelarItem($itemId)
    {
        foreach ($this->newItems as $index => $item) {

            if ($item['id'] == $itemId) {

                if ($item['id'] < 0) {
                    unset($this->newItems[$index]);
                    $this->newItems = array_values($this->newItems);
                }

                break;
            }
        }

        if ($this->selectedIdItem === $itemId) {
            $this->selectedIdItem = null;
        }
    }
    
    public function mount($orden_trabajo, $items_orden_trabajo, $pto_ventas)
    {
        $this->items_orden_trabajo = $items_orden_trabajo;
        $this->pto_ventas = $pto_ventas;
        $this->numero = $orden_trabajo->Numero ?? OrdenTrabajo::max('Numero') + 1;
        $this->clientes = Client::all();


        if ($this->orden_trabajo) {
            $this->fecha_emision = $orden_trabajo->FechaEmision;
            $this->cliente_id = $orden_trabajo->cliente->id;
            $this->cliente_nombre = $orden_trabajo->cliente->Nombre;
        }
        else {
            $this->fecha_emision = Carbon::today()->format('Y-m-d');
            $this->cliente_id = 1;

        }

        if ($items_orden_trabajo && $items_orden_trabajo->count() > 0) {

            $this->items_orden_trabajo = $items_orden_trabajo->load('certificados');
            
        }

        foreach ($this->items_orden_trabajo as $item) {

        $this->newItems[] = [
            'id' => $item->id,
                'is_new' => false, // bandera opcional

                'tratamiento_id' => $item->IdTratamiento,
                'dureza_id' => $item->IdDureza,
                'material_id' => $item->IdMaterial,
                'Descripcion' => $item->Descripcion,
                'Cantidad' => $item->Cantidad,
                'Peso' => $item->Peso,
                'NroPlano' => $item->certificados->first()?->NroPlano,

                'DurezaSolicitadaMinima' => $item->DurezaSolicitadaMinima,
                'DurezaSolicitadaMaxima' => $item->DurezaSolicitadaMaxima,
            ];
        }

        $this->materialesMap = Material::all()->keyBy('id');
        $this->tratamientosMap = Tratamiento::all()->keyBy('id');
        $this->durezasMap = Dureza::all()->keyBy('id');

    }

public function toggleExpand($index)
{
    $this->expandedId = $this->expandedId === $index ? null : $index;
}

public function addNewItem()
{

    foreach ($this->newItems as $item) {
        if (!empty($item['is_new'])) {
            return;
        }
    }

    $newItemId = $this->tempId--; // 👈 CLAVE

    $defaultMaterial = Material::where('Predeterminado', 1)->first()->id ?? 1;
    $defaultTratamiento = Tratamiento::where('Predeterminado', 1)->first()->id ?? 1;
    $defaultDureza = Dureza::where('Predeterminado', 1)->first()->id ?? 1;
    $this->newItems[] = [
        'id' => $newItemId, // lo mantenés
            'is_new' => true,

            'Descripcion' => null,
            'Cantidad' => null,
            'Peso' => null,
            'material_id' => $defaultMaterial,
            'tratamiento_id' => $defaultTratamiento,
            'NroPlano' => null,
            'dureza_id' => $defaultDureza,
            'DurezaSolicitadaMinima' => null,
            'DurezaSolicitadaMaxima' => null,
        ];

$this->expandedId = $newItemId;
$this->selectedIdItem = $newItemId;

$this->dispatch('open-item', id: $newItemId);
    // $this->dispatch('item-added', index: array_key_last($this->newItems));
}
    
    public function cancelarCliente()
    {
        $this->cliente_id = null;
        $this->cliente_nombre = null;
    }

    public function updatedClienteId($value)
    {
        $cliente = Client::find($value);

        if ($cliente) {
            $this->cliente_nombre = $cliente->Nombre;
        } else {
            $this->cliente_nombre = null;
        }
    }

    public function seleccionarCliente($id)
    {
        $cliente = Client::find($id);

        if ($cliente) {
            $this->cliente_id = $cliente->id;
            $this->cliente_nombre = $cliente->Nombre;
        }
    }

    // public function deleteItem($id)
    // {
    //     if (isset($this->newItems[$id])) {
    //         unset($this->newItems[$id]);
    //     } else {
    //         $item = $this->items_orden_trabajo->find($id);
    //         if ($item) {
    //             $item->certificados()->delete();
    //             $item->delete();
    //             $this->items_orden_trabajo = $this->items_orden_trabajo->except($id);
    //         }
    //     }

    //     $this->expanded = array_diff($this->expanded, [$id]);

    //     if ($this->selectedIdItem == $id) {
    //         $this->selectedIdItem = null;
    //     }
    // }

    public function seleccionarTratamiento($itemId, $tratamientoId)
    {
        if (isset($this->newItems[$itemId])) {
            $this->newItems[$itemId]['tratamiento_id'] = $tratamientoId;
        }
    }

    public function seleccionarDureza($itemId, $durezaId)
    {
        if (isset($this->newItems[$itemId])) {
            $this->newItems[$itemId]['dureza_id'] = $durezaId;
        }
    }

    public function seleccionarMaterial($itemId, $materialId)
    {
        if (isset($this->newItems[$itemId])) {
            $this->newItems[$itemId]['material_id'] = $materialId;
        }
    }

    public function seleccionarTratamientoExistente($itemId, $tratamientoId)
    {
        if(isset($this->items_orden_trabajo_edit[$itemId])) {
            $this->items_orden_trabajo_edit[$itemId]['tratamiento_id'] = $tratamientoId;
        }
    }

    public function seleccionarDurezaExistente($itemId, $durezaId)
    {
        if(isset($this->items_orden_trabajo_edit[$itemId])) {
            $this->items_orden_trabajo_edit[$itemId]['dureza_id'] = $durezaId;
        }
    }

    public function seleccionarMaterialExistente($itemId, $materialId)
    {
        if(isset($this->items_orden_trabajo_edit[$itemId])) {
            $this->items_orden_trabajo_edit[$itemId]['material_id'] = $materialId;
        }
    }

    public function render()
    {
        return view('livewire.orden-trabajo-edit', [
            'expandedId' => $this->expandedId,
            'tratamientos' => Tratamiento::all(),
            'durezas' => Dureza::all(),
            'materiales' => Material::all(),
        ]);
    }
}
