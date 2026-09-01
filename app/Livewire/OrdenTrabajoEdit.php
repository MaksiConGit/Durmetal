<?php

namespace App\Livewire;

use App\Models\Client;
use App\Models\Dureza;
use App\Models\Material;
use App\Models\User;
use App\Models\Tratamiento;
use App\Models\Email;
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
    public $users;

    public $certificadoSeleccionado = [];
    public $numeroPlano = [];
    public $cantidad = [];
    public $responsableId = [];
    public $observacionesCert = [];

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
    public $searchClienteNombre = '';
    public $searchClienteDocumento = '';

    public $emails = [];

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

    public function getClientesFiltradosProperty()
    {
        return Client::query()
            ->when($this->searchClienteNombre, function ($query) {
                $query->where(
                    'Nombre',
                    'like',
                    '%' . $this->searchClienteNombre . '%'
                );
            })
            ->when($this->searchClienteDocumento, function ($query) {
                $query->where(
                    'NroDocumento',
                    'like',
                    '%' . $this->searchClienteDocumento . '%'
                );
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
                            'CodigoComplejidad' => $item['CC'],
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
        $this->users = User::all();

        $this->emails = Email::pluck('id')->toArray();

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
                'Estado' => $item->Estado,
                'CC' => $item->CodigoComplejidad,
                'NotaEnvio' => $item->itemNotaEnvio->notaEnvio->NumeroCompleto ?? null,
                'NroPlano' => $item->certificados->first()?->NroPlano,

                'CantidadCertificadosImpresos' => $item->CantidadCertificadosImpresos,
                'CantidadCertificadosEnviadosPorCorreo' => $item->CantidadCertificadosEnviadosPorCorreo,

                'DurezaSolicitadaMinima' => $item->DurezaSolicitadaMinima,
                'DurezaSolicitadaMaxima' => $item->DurezaSolicitadaMaxima,
            ];
        }

        $this->materialesMap = Material::all()->keyBy('id');
        $this->tratamientosMap = Tratamiento::all()->keyBy('id');
        $this->durezasMap = Dureza::all()->keyBy('id');

    }

    public function actualizarCantidadCertificado($itemId, $tipo)
    {
        $item = ItemOrdenTrabajo::find($itemId);

        if (!$item) {
            return;
        }

        if ($tipo === 'impresion') {
            $item->CantidadCertificadosImpresos++;
        }

        if ($tipo === 'correo') {
            $item->CantidadCertificadosEnviadosPorCorreo++;
        }

        $item->ActualizadoPor = auth()->id();
        $item->FechaActualizacion = now();

        $item->save();


        // Actualizar Livewire sin recargar
        foreach ($this->newItems as $index => $i) {

            if ($i['id'] == $itemId) {

                $this->newItems[$index]['CantidadCertificadosImpresos'] =
                    $item->CantidadCertificadosImpresos;

                $this->newItems[$index]['CantidadCertificadosEnviadosPorCorreo'] =
                    $item->CantidadCertificadosEnviadosPorCorreo;

                break;
            }
        }
    }

    public function incrementarCorreo($itemId)
    {
        $item = ItemOrdenTrabajo::find($itemId);

        if (!$item) {
            return;
        }

        $item->CantidadCertificadosEnviadosPorCorreo =
            ($item->CantidadCertificadosEnviadosPorCorreo ?? 0) + 1;

        $item->save();

        foreach ($this->newItems as $index => $i) {
            if ($i['id'] == $itemId) {
                $this->newItems[$index]['CantidadCertificadosEnviadosPorCorreo'] =
                    $item->CantidadCertificadosEnviadosPorCorreo;
                break;
            }
        }
    }

    public function imprimirCertificado($itemId)
    {

        $this->validate([
            "numeroPlano.$itemId"   => 'required|string|max:255',
            "cantidad.$itemId"      => 'required|numeric|min:1',
            "responsableId.$itemId" => 'required|exists:users,id',
            "observacionesCert.$itemId" => 'nullable|string|max:1000',
        ]);

        if (!empty($this->certificadoSeleccionado[$itemId])) {

            $certificado = Certificado::find($this->certificadoSeleccionado[$itemId]);

            if ($certificado) {
                $certificado->update([
                    'Nombre'        => $this->numeroPlano[$itemId],
                    'NroPlano'      => $this->numeroPlano[$itemId],
                    'Observaciones' => $this->observacionesCert[$itemId],
                    'Cantidad'      => $this->cantidad[$itemId],
                    'IdUsuario' => $this->responsableId[$itemId],
                ]);
            }

            $url = route('ingreso-datos.pdf', $certificado);

            $this->dispatch('abrirPdf', url: $url);

            $this->actualizarCantidadCertificado($itemId, 'impresion');

            return;
        }

        $certificado = Certificado::create([
            'IdItemOrdenTrabajo'       => $itemId,
            'Nombre'                   => $this->numeroPlano[$itemId],
            'NroPlano'                 => $this->numeroPlano[$itemId],
            'Observaciones'            => $this->observacionesCert[$itemId] ?? null,
            'Cantidad'                 => $this->cantidad[$itemId],
            'IdUsuario'                => $this->responsableId[$itemId],
            'CantidadImpresiones'      => 0,
            'CantidadEnviosPorCorreo'  => 0,
            'Predeterminado'           => 1,
        ]);

        $url = route('ingreso-datos.pdf', $certificado->id);

        $this->dispatch('abrirPdf', url: $url);

    }

    // public function enviarCertificadoPorCorreo($itemId)
    // {
    //     $this->actualizarCantidadCertificado($itemId, 'correo');

    //     // 🔹 Validar emails
    //     if (
    //         !isset($this->emailsSeleccionados[$itemId]) ||
    //         count($this->emailsSeleccionados[$itemId]) === 0
    //     ) {
    //         $this->addError("emails.$itemId", 'Debe seleccionar al menos un email.');
    //         return;
    //     }

    //     // 🔹 Si existe certificado → usarlo
    //     if (!empty($this->certificadoSeleccionado[$itemId])) {

    //         return redirect()->to(
    //             route('ingreso-datos.email', $this->certificadoSeleccionado[$itemId])
    //             . '?Emails=' . implode(',', $this->emailsSeleccionados[$itemId])
    //         );

    //     }

    //     // 🔹 Validaciones SOLO si es nuevo
    //     $this->validate([
    //         "numeroPlano.$itemId"   => 'required|string|max:255',
    //         "cantidad.$itemId"      => 'required|numeric|min:1',
    //         "responsableId.$itemId" => 'required|exists:users,id',
    //     ]);

    //     // 🔹 Crear certificado
    //     $certificado = Certificado::create([
    //         'IdItemOrdenTrabajo'       => $itemId,
    //         'Nombre'                   => $this->numeroPlano[$itemId],
    //         'NroPlano'                 => $this->numeroPlano[$itemId],
    //         'Observaciones'            => $this->observacionesCert[$itemId] ?? null,
    //         'Cantidad'                 => $this->cantidad[$itemId],
    //         'ResponsableId'            => $this->responsableId[$itemId],
    //         'CantidadImpresiones'      => 0,
    //         'CantidadEnviosPorCorreo'  => 0,
    //         'Predeterminado'           => 1,
    //     ]);


    //     return redirect()->to(
    //         route('ingreso-datos.email', $certificado->id)
    //         . '?Emails=' . implode(',', $this->emailsSeleccionados[$itemId])
    //     );
    // }


public function enviarCertificadoPorCorreo($itemId)
    {
        // 🔹 Validación
        $this->validate([
            "numeroPlano.$itemId"   => 'required|string|max:255',
            "cantidad.$itemId"      => 'required|numeric|min:1',
            "responsableId.$itemId" => 'required|exists:users,id',
            "observacionesCert.$itemId" => 'nullable|string|max:1000',
        ]);

        // 🔹 Crear o actualizar certificado
        if (!empty($this->certificadoSeleccionado[$itemId])) {

            $certificado = Certificado::find($this->certificadoSeleccionado[$itemId]);

            if ($certificado) {
                $certificado->update([
                    'Nombre'        => $this->numeroPlano[$itemId],
                    'NroPlano'      => $this->numeroPlano[$itemId],
                    'Observaciones' => $this->observacionesCert[$itemId],
                    'Cantidad'      => $this->cantidad[$itemId],
                    'IdUsuario'     => $this->responsableId[$itemId],
                ]);
            }

        } else {

            $certificado = Certificado::create([
                'IdItemOrdenTrabajo'       => $itemId,
                'Nombre'                   => $this->numeroPlano[$itemId],
                'NroPlano'                 => $this->numeroPlano[$itemId],
                'Observaciones'            => $this->observacionesCert[$itemId] ?? null,
                'Cantidad'                 => $this->cantidad[$itemId],
                'IdUsuario'                => $this->responsableId[$itemId],
                'CantidadImpresiones'      => 0,
                'CantidadEnviosPorCorreo'  => 0,
                'Predeterminado'           => 1,
            ]);
        }

        // 🔹 Obtener emails seleccionados
        $emails = Email::whereIn('id', $this->emails)->pluck('id')->implode(',');


        // 🔹 Convertir a string tipo: mail1,mail2,mail3


        // 🔹 Actualizar contador
        $this->actualizarCantidadCertificado($itemId, 'correo');

        // 🔥 REDIRECCIÓN (igual que el <a>)
        return redirect()->to(
            url("ingreso-datos/{$certificado->id}/email") . '?Emails=' . $emails
        );
    }

    public function updatedCertificadoSeleccionado($value, $itemId)
    {
        if (!$value) {
            // Nuevo
            $this->numeroPlano[$itemId] = null;
            $this->cantidad[$itemId] = null;
            $this->responsableId[$itemId] = null;
            $this->observacionesCert[$itemId] = null;
            return;
        }

        $certificado = Certificado::find($value);

        if ($certificado) {
            $this->numeroPlano[$itemId]   = $certificado->NroPlano;
            $this->cantidad[$itemId]      = $certificado->Cantidad;
            $this->responsableId[$itemId] = $certificado->IdUsuario;
            $this->observacionesCert[$itemId] = $certificado->Observaciones;
        }
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
                'Estado' => 'PENDIENTE',
                'CC' => NULL,
                'NotaEnvio' => NULL,
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

    public function seleccionarCC($index, $cc)
    {
        if (isset($this->newItems[$index])) {
            $this->newItems[$index]['CC'] = $cc;
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
            'tratamientos' => Tratamiento::orderBy('nombre')->get(),
            'durezas' => Dureza::orderBy('nombre')->get(),
            'materiales' => Material::orderBy('nombre')->get(),
        ]);
    }
}
