<div>
    <x-layout2-sidebar>
        <x-slot name="title">Editar Orden de Trabajo</x-slot>

        <x-slot name="filtros">

            <div class="form-inline mt-5 mr-3 d-flex flex-column align-items-center">

                <div class="form-group mb-3">
                    <button type="button" wire:click="addNewItem" class="btn btn-app bg-primary">
                        <i class="fas fa-plus"></i> Nuevo
                    </button>
                </div>

                <div class="form-group mb-3">
                    <button
                        type="button"
                        class="btn btn-app bg-primary {{ !$selectedIdItem ? 'disabled' : '' }}"
                        wire:click="deleteItem({{ $selectedIdItem }})"
                        wire:loading.attr="disabled"
                        onclick="return confirm('¿Estás seguro que deseas eliminar este item?')"
                        data-bs-toggle="tooltip"
                        title="Eliminar item órden de trabajo"
                    >
                        <i class="fas fa-trash-can"></i> Eliminar
                    </button>
                </div>

            </div>

        </x-slot>

        <form action="{{ route('orden-trabajo.update', $orden_trabajo) }}" method="POST">
            @csrf
            @method('PUT')

            <x-data-table-acordion3>

                <x-slot name="filtros">

                    <div class="row mb-3">

                        <div class="col-2">
                            <div class="form-group mb-0">
                                <label for="PuntoVenta" class="font-weight-normal">PUNTO DE VENTA</label>
                                <select name="PuntoVenta" id="PuntoVenta" class="form-control form-control-sm">
                                    @foreach ($pto_ventas as $pto_venta)
                                        <option value="{{ $pto_venta->id }}" {{$pto_venta->id == session('PuntoVenta') ? 'selected' : ''}}>{{ $pto_venta->Nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group mb-0">
                                <label for="Numero" class="font-weight-normal">NUMERO</label>
                                <input type="text" id="Numero" name="Numero" value="{{old('Numero', session('Numero'))}}" class="form-control form-control-sm filtro-input" disabled>
                            </div>
                        </div>

                        <div class="col-2 d-flex flex-column justify-content-end">
                            <div class="bg-info text-white d-flex justify-content-center align-items-center mx-auto" 
                                style="width: 3rem; height: 3rem; font-weight: bold;">
                                OT
                            </div>
                        </div>

                        <div class="col-2">
                            <div class="form-group mb-0">
                                <label for="FechaEmision" class="font-weight-normal">FECHA DE EMISION</label>
                                <input type="date" id="FechaEmision" name="FechaEmision" value="{{old('FechaEmision', session('FechaEmision'))}}" class="form-control form-control-sm filtro-input">
                            </div>
                        </div>

                        <div class="col-2">
                            <div class="form-group mb-0">
                                <label for="NumeroRemitoCliente" class="font-weight-normal">N° REMITO CLIENTE</label>
                                <input type="text" id="NumeroRemitoCliente" name="NumeroRemitoCliente" value="{{old('NumeroRemitoCliente', session('NumeroRemitoCliente'))}}" class="form-control form-control-sm filtro-input">
                            </div>
                        </div>

                        <div class="row d-flex justify-content-end ml-5">
                            <div>
                                <button class="btn btn-app bg-primary">
                                    <i class="fas fa-floppy-disk"></i> Guardar
                                </button>
                            </div>
                        </div>

                    </div>

                    <div class="row mb-3">

                        <div class="col-2">

                            <div class="form-group mb-0">
                                <label for="filtro1" class="font-weight-normal">CODIGO CLIENTE</label>
                            </div>
                            <div class="input-group">
                                <input id="sidebarSearch" value="{{ session('IdCliente') }}"
                                    class="form-control form-control-sm bg-white text-dark" 
                                    type="search" aria-label="Search" wire:model.live="cliente_id" name="IdCliente">
                                <div class="input-group-append">
                                <button type="button" 
                                        class="btn btn-sidebar btn-sm bg-orange" 
                                        data-toggle="modal" 
                                        data-target="#modal-cliente">
                                    <i class="fas fa-search fa-fw text-white"></i>
                                </button>
                                </div>
                            </div>
                        </div>

                        <div class="col-2  mb-3">
                            <div class="form-group mb-0">
                                <label for="Numero" class="font-weight-normal">NOMBRE</label>
                                <input type="text" id="Numero" name="Numero" value="{{ $cliente_nombre }}" class="form-control form-control-sm filtro-input" disabled>
                            </div>
                        </div>

                        <div class="col-2"></div>

                        <div class="col-4 mt-4">
                            <div class="custom-control custom-checkbox">
                                <input type="hidden" name="Archivado" value="0">
                                <input class="custom-control-input" type="checkbox" id="Archivado" name="Archivado" value="1" {{old('Archivado', $orden_trabajo->Archivado) == 1 ? 'checked' : ''}}>
                                <label for="Archivado" class="custom-control-label">ARCHIVADO</label>
                            </div>
                        </div>

                        
                        <div class="row d-flex justify-content-end ml-5">
                            <div>
                                <a class="btn btn-app bg-primary" href="{{ route('orden-trabajo.show', $orden_trabajo) }}">
                                    <i class="fas fa-share"></i> Enviar
                                </a>
                            </div>
                        </div>

                    </div>

                </x-slot>

                <x-slot name="thead">
                    <tr>
                        <th>DESCRIPCION</th>
                        <th>MATERIAL</th>
                        <th>CANT.</th>
                        <th>PESO</th>
                        <th>TRAT.</th>
                        <th>DUREZA</th>
                        <th>DSMIN</th>
                        <th>DSMAX</th>
                        <th>ESTADO</th>
                        <th>CC</th>
                        <th>CERT.</th>
                        <th>NOTA DE ENVIO</th>
                    </tr>
                </x-slot>
                <x-slot name="tbody">
                    @foreach ($items_orden_trabajo as $item_orden_trabajo)

                        <tr data-widget="expandable-table" 
                            aria-expanded="{{ in_array($item_orden_trabajo->id, $expanded) ? 'true' : 'false' }}"
                            wire:click="toggleExpand({{ $item_orden_trabajo->id }})">

                            <td>{{ $item_orden_trabajo->Descripcion }}</td>
                            <td>{{ optional($materiales->firstWhere('id', $items_orden_trabajo_edit[$item_orden_trabajo->id]['material_id'] ?? $item_orden_trabajo->IdMaterial))->Nombre }}</td>
                            <td>{{ $item_orden_trabajo->Cantidad }}</td>
                            <td>{{ $item_orden_trabajo->Peso }}</td>
                            <td>{{ optional($tratamientos->firstWhere('id', $items_orden_trabajo_edit[$item_orden_trabajo->id]['tratamiento_id'] ?? $item_orden_trabajo->IdTratamiento))->Nombre }}</td>
                            <td>{{ optional($durezas->firstWhere('id', $items_orden_trabajo_edit[$item_orden_trabajo->id]['dureza_id'] ?? $item_orden_trabajo->IdDureza))->Nombre }}</td>
                            <td>{{ $item_orden_trabajo->DurezaSolicitadaMinima }}</td>
                            <td>{{ $item_orden_trabajo->DurezaSolicitadaMaxima }}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>

                        <tr class="expandable-body" style="display: {{ in_array($item_orden_trabajo->id, $expanded) ? 'table-row' : 'none' }}; font-size: 0.8rem;">
                            <td colspan="15" class="p-0">
                                <div class="p-0 m-0">
                                    <x-panel-horizontal2>
                                        <x-slot name="pestañas">
                                            <li class="nav-item">
                                                <a class="nav-link {{ $activeTabParametros === 'custom-tabs-1' ? 'active' : '' }}"
                                                wire:click.prevent="setActiveTabParametros('custom-tabs-1')"
                                                id="custom-tabs-1-tab" data-toggle="pill"
                                                href="#custom-tabs-1" role="tab"
                                                aria-controls="custom-tabs-1" aria-selected="true"
                                                style="padding: 3px 8px; font-size: 0.75rem;">
                                                ITEM
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link {{ $activeTabParametros === 'custom-tabs-2' ? 'active' : '' }}"
                                                wire:click.prevent="setActiveTabParametros('custom-tabs-2')"
                                                id="custom-tabs-2-tab" data-toggle="pill"
                                                href="#custom-tabs-2" role="tab"
                                                aria-controls="custom-tabs-2" aria-selected="true"
                                                style="padding: 3px 8px; font-size: 0.75rem;">
                                                OBSERVACIONES
                                                </a>
                                            </li>
                                        </x-slot>

                                        <x-slot name="ventanas">
                                            <div class="tab-pane fade show {{ $activeTabParametros === 'custom-tabs-1' ? 'active' : '' }}"
                                                id="custom-tabs-1" role="tabpanel" aria-labelledby="custom-tabs-1-tab"
                                                style="height: 18rem; padding: 0.5rem;">
                                                <div class="row justify-content-center m-0">
                                                    <div class="col-10 card p-1">
                                                        <div class="card-body p-2">
                                                            <div class="row justify-content-center m-0">
                                                                <div class="col-4 mb-2 px-1">
                                                                    <label class="font-weight-normal mb-1" style="font-size: 0.75rem;">ITEM NRO</label>
                                                                    <input type="hidden" name="items[{{ $item_orden_trabajo->id }}][ItemNumero]" value="{{ old('ItemNumero', $item_orden_trabajo->ItemNumero) }}">
                                                                    <input type="text" value="{{ old('ItemNumero', $item_orden_trabajo->ItemNumero) }}" disabled class="form-control form-control-sm p-1" style="height: 22px;">
                                                                </div>
                                                                <div class="col-4 mb-2 px-1">
                                                                    <label class="font-weight-normal mb-1" style="font-size: 0.75rem;">DESCRIPCIÓN</label>
                                                                    <input type="text" name="items[{{ $item_orden_trabajo->id }}][Descripcion]" value="{{ old('items[$item_orden_trabajo->id][Descripcion]', $item_orden_trabajo->Descripcion) }}" class="form-control form-control-sm p-1" style="height: 22px;">
                                                                </div>
                                                                <div class="col-4 mb-2 px-1">
                                                                    <label class="font-weight-normal mb-1" style="font-size: 0.75rem;">NRO PLANO</label>
                                                                    <input type="text" name="items[{{ $item_orden_trabajo->id }}][NroPlano]" value="{{ old('NroPlano', $item_orden_trabajo->certificados->first()->NroPlano ?? '') }}" class="form-control form-control-sm p-1" style="height: 22px;">
                                                                </div>
                                                            </div>

                                                            <div class="row justify-content-center m-0">
                                                                <div class="col-4 mb-2 px-1">
                                                                    <label class="font-weight-normal mb-1" style="font-size: 0.75rem;">CANTIDAD</label>
                                                                    <input type="text" name="items[{{ $item_orden_trabajo->id }}][Cantidad]" value="{{ old('items[$item_orden_trabajo->id][Cantidad]', $item_orden_trabajo->Cantidad) }}" class="form-control form-control-sm p-1" style="height: 22px;">
                                                                </div>
                                                                <div class="col-4 mb-2 px-1">
                                                                    <label class="font-weight-normal mb-1" style="font-size: 0.75rem;">PESO</label>
                                                                    <input type="text" name="items[{{ $item_orden_trabajo->id }}][Peso]" value="{{ old('items[$item_orden_trabajo->id][Peso]', $item_orden_trabajo->Peso) }}" class="form-control form-control-sm p-1" style="height: 22px;">
                                                                </div>
                                                                <div class="col-4 mb-2 px-1">
                                                                    <label class="font-weight-normal mb-1" style="font-size: 0.7rem;">TRATAMIENTO</label>
                                                                    <div class="input-group input-group-sm">
                                                                        <select 
                                                                            wire:model="items_orden_trabajo_edit.{{ $item_orden_trabajo->id }}.tratamiento_id" 
                                                                            class="form-control form-control-sm p-1" 
                                                                            name="items[{{ $item_orden_trabajo->id }}][IdTratamiento]" 
                                                                            style="height: 22px; font-size: 0.7rem; line-height: 1; padding-right: 20px;"
                                                                        >
                                                                            @foreach ($tratamientos as $tratamiento)
                                                                                <option 
                                                                                    value="{{ $tratamiento->id }}" 
                                                                                    {{ $item_orden_trabajo->IdTratamiento == $tratamiento->id ? 'selected' : '' }}
                                                                                    style="font-size: 0.7rem; white-space: nowrap;"
                                                                                >
                                                                                    {{ $tratamiento->Nombre }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                        <div class="input-group-append">
                                                                            <button 
                                                                                type="button" 
                                                                                class="btn btn-sidebar btn-xs bg-orange p-1" 
                                                                                data-toggle="modal" 
                                                                                data-target="#modal-items-{{ $item_orden_trabajo->id }}-tratamiento"
                                                                                style="height: 22px;"
                                                                            >
                                                                                <i class="fas fa-search fa-xs text-white"></i>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                                                                                <!-- Modal Tratamiento -->
                                                                <div class="modal fade" id="modal-items-{{ $item_orden_trabajo->id }}-tratamiento" wire:ignore.self>
                                                                    <div class="modal-dialog modal-dialog-centered">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title">BUSCAR TRATAMIENTO</h5>
                                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                    <span aria-hidden="true">&times;</span>
                                                                                </button>
                                                                            </div>
                                                                            <div class="modal-body">

                                                                                <div class="table-responsive" style="max-height: 70vh; overflow-y: auto;">
                                                                                    <x-simple-table2 class="table table-bordered table-hover table-striped w-100" style="font-size: 1rem;">
                                                                                        <x-slot name="thead">
                                                                                            <tr>
                                                                                                <th style="padding: 14px 18px; font-size: 1.1rem;">NOMBRE</th>
                                                                                            </tr>
                                                                                        </x-slot>

                                                                                        <x-slot name="tbody">
                                                                                            @forelse ($tratamientos as $tratamiento)
                                                                                                <tr wire:click.prevent="seleccionarTratamientoExistente({{ $item_orden_trabajo->id }}, {{ $tratamiento->id }})"
                                                                                                    data-dismiss="modal"
                                                                                                    style="cursor:pointer; height: 55px;"
                                                                                                    class="{{ $items_orden_trabajo_edit[$item_orden_trabajo->id]['tratamiento_id'] == $tratamiento->id ? 'table-primary' : '' }}">
                                                                                                    <td style="padding: 12px 18px;">{{ $tratamiento->Nombre }}</td>
                                                                                                </tr>
                                                                                            @empty
                                                                                                <tr><td colspan="8">No se encontraron resultados.</td></tr>
                                                                                            @endforelse
                                                                                        </x-slot>
                                                                                    </x-simple-table2>
                                                                                    </div>
                                                                                    </div>
                                                                                </div>

                                                                            </div>

                                                                            <div class="modal-footer justify-content-end">

                                                                                <button class="btn btn-sidebar btn-sm bg-orange" data-dismiss="modal">
                                                                                    <span class="text-white">Aceptar</span>
                                                                                    <i class="fas fa-check fa-fw text-white ml-2"></i>
                                                                                </button>

                                                                                <button class="btn btn-sidebar btn-sm bg-orange" data-dismiss="modal">
                                                                                    <span class="text-white">Cancelar</span>
                                                                                    <i class="fas fa-xmark fa-fw text-white ml-2"></i>
                                                                                </button>

                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>

                                                            <div class="row m-0">
                                                                <div class="col-4 mb-2 px-1">
                                                                    <label class="font-weight-normal mb-1" style="font-size: 0.7rem;">DUREZA</label>
                                                                    <div class="input-group input-group-sm">
                                                                        <select
                                                                            wire:model="items_orden_trabajo_edit.{{ $item_orden_trabajo->id }}.dureza_id"
                                                                            class="form-control form-control-sm p-1"
                                                                            name="items[{{ $item_orden_trabajo->id }}][IdDureza]"
                                                                            style="height: 22px; font-size: 0.7rem; line-height: 1; padding-right: 20px;">
                                                                            @foreach ($durezas as $dureza)
                                                                                <option value="{{ $dureza->id }}"
                                                                                        style="font-size: 0.7rem; white-space: nowrap;">
                                                                                    {{ $dureza->Nombre }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                        <div class="input-group-append">
                                                                            <button type="button"
                                                                                    class="btn btn-sidebar btn-xs bg-orange p-1"
                                                                                    data-toggle="modal"
                                                                                    data-target="#modal-items-{{ $item_orden_trabajo->id }}-dureza">
                                                                                <i class="fas fa-search fa-xs text-white"></i>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <!-- Modal Dureza -->
                                                                <div class="modal fade" id="modal-items-{{ $item_orden_trabajo->id }}-dureza" wire:ignore.self>
                                                                    <div class="modal-dialog modal-dialog-centered">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title">BUSCAR DUREZA</h5>
                                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                    <span aria-hidden="true">&times;</span>
                                                                                </button>
                                                                            </div>
                                                                            <div class="modal-body">

                                                                                <div class="table-responsive" style="max-height: 70vh; overflow-y: auto;">
                                                                                    <x-simple-table2 class="table table-bordered table-hover table-striped w-100" style="font-size: 1rem;">
                                                                                        <x-slot name="thead">
                                                                                            <tr>
                                                                                                <th style="padding: 14px 18px; font-size: 1.1rem;">NOMBRE</th>
                                                                                            </tr>
                                                                                        </x-slot>

                                                                                        <x-slot name="tbody">
                                                                                            @forelse ($durezas as $dureza)
                                                                                                <tr wire:click.prevent="seleccionarDurezaExistente({{ $item_orden_trabajo->id }}, {{ $dureza->id }})"
                                                                                                    data-dismiss="modal"
                                                                                                    style="cursor:pointer; height: 55px;"
                                                                                                    class="{{ $items_orden_trabajo_edit[$item_orden_trabajo->id]['dureza_id'] == $dureza->id ? 'table-primary' : '' }}">
                                                                                                    <td style="padding: 12px 18px;">{{ $dureza->Nombre }}</td>
                                                                                                </tr>
                                                                                            @empty
                                                                                                <tr><td colspan="8">No se encontraron resultados.</td></tr>
                                                                                            @endforelse
                                                                                        </x-slot>
                                                                                    </x-simple-table2>
                                                                                    </div>
                                                                                    </div>
                                                                                </div>

                                                                            </div>

                                                                            <div class="modal-footer justify-content-end">

                                                                                <button class="btn btn-sidebar btn-sm bg-orange" data-dismiss="modal">
                                                                                    <span class="text-white">Aceptar</span>
                                                                                    <i class="fas fa-check fa-fw text-white ml-2"></i>
                                                                                </button>

                                                                                <button class="btn btn-sidebar btn-sm bg-orange" data-dismiss="modal">
                                                                                    <span class="text-white">Cancelar</span>
                                                                                    <i class="fas fa-xmark fa-fw text-white ml-2"></i>
                                                                                </button>

                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                </div>


                                                                <div class="col-4 mb-2 px-1">
                                                                    <label class="font-weight-normal mb-1" style="font-size: 0.75rem;">DSMIN</label>
                                                                    <input type="text" name="items[{{ $item_orden_trabajo->id }}][DurezaSolicitadaMinima]" value="{{ old('items[$item_orden_trabajo->id][DurezaSolicitadaMinima]', $item_orden_trabajo->DurezaSolicitadaMinima) }}" class="form-control form-control-sm p-1" style="height: 22px;">
                                                                </div>

                                                                <div class="col-4 mb-2 px-1">
                                                                    <label class="font-weight-normal mb-1" style="font-size: 0.75rem;">DSMAX</label>
                                                                    <input type="text" name="items[{{ $item_orden_trabajo->id }}][DurezaSolicitadaMaxima]" value="{{ old('items[$item_orden_trabajo->id][DurezaSolicitadaMaxima]', $item_orden_trabajo->DurezaSolicitadaMaxima) }}" class="form-control form-control-sm p-1" style="height: 22px;">
                                                                </div>

                                                                <div class="col-4 mb-2 px-1">
                                                                    <label class="font-weight-normal mb-1" style="font-size: 0.7rem;">MATERIAL</label>
                                                                    <div class="input-group input-group-sm">
                                                                        <select 
                                                                            wire:model="items_orden_trabajo_edit.{{ $item_orden_trabajo->id }}.material_id" 
                                                                            class="form-control form-control-sm p-1" 
                                                                            name="items[{{ $item_orden_trabajo->id }}][IdMaterial]" 
                                                                            style="height: 22px; font-size: 0.7rem; line-height: 1; padding-right: 20px;"
                                                                        >
                                                                            @foreach ($materiales as $material)
                                                                                <option 
                                                                                    value="{{ $material->id }}" 
                                                                                    style="font-size: 0.7rem; white-space: nowrap;"
                                                                                >
                                                                                    {{ $material->Nombre }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                        <div class="input-group-append">
                                                                            <button 
                                                                                type="button" 
                                                                                class="btn btn-sidebar btn-xs bg-orange p-1" 
                                                                                data-toggle="modal" 
                                                                                data-target="#modal-items-{{ $item_orden_trabajo->id }}-material"
                                                                                style="height: 22px;"
                                                                            >
                                                                                <i class="fas fa-search fa-xs text-white"></i>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
   																<!-- Modal Material -->
                                                                <div class="modal fade" id="modal-items-{{ $item_orden_trabajo->id }}-material" wire:ignore.self>
                                                                    <div class="modal-dialog modal-dialog-centered">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title">BUSCAR MATERIAL</h5>
                                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                    <span aria-hidden="true">&times;</span>
                                                                                </button>
                                                                            </div>
                                                                            <div class="modal-body">

                                                                                <div class="table-responsive" style="max-height: 70vh; overflow-y: auto;">
                                                                                    <x-simple-table2 class="table table-bordered table-hover table-striped w-100" style="font-size: 1rem;">
                                                                                        <x-slot name="thead">
                                                                                            <tr>
                                                                                                <th style="padding: 14px 18px; font-size: 1.1rem;">NOMBRE</th>
                                                                                            </tr>
                                                                                        </x-slot>

                                                                                        <x-slot name="tbody">
                                                                                            @forelse ($materiales as $material)
                                                                                                <tr wire:click.prevent="seleccionarMaterialExistente({{ $item_orden_trabajo->id }}, {{ $material->id }})"
                                                                                                    data-dismiss="modal"
                                                                                                    style="cursor:pointer; height: 55px;"
                                                                                                    class="{{ $items_orden_trabajo_edit[$item_orden_trabajo->id]['material_id'] == $material->id ? 'table-primary' : '' }}">
                                                                                                    <td style="padding: 12px 18px;">{{ $material->Nombre }}</td>
                                                                                                </tr>
                                                                                            @empty
                                                                                                <tr><td colspan="8">No se encontraron resultados.</td></tr>
                                                                                            @endforelse
                                                                                        </x-slot>
                                                                                    </x-simple-table2>
                                                                                    </div>
                                                                                    </div>
                                                                                </div>

                                                                            </div>

                                                                            <div class="modal-footer justify-content-end">

                                                                                <button class="btn btn-sidebar btn-sm bg-orange" data-dismiss="modal">
                                                                                    <span class="text-white">Aceptar</span>
                                                                                    <i class="fas fa-check fa-fw text-white ml-2"></i>
                                                                                </button>

                                                                                <button class="btn btn-sidebar btn-sm bg-orange" data-dismiss="modal">
                                                                                    <span class="text-white">Cancelar</span>
                                                                                    <i class="fas fa-xmark fa-fw text-white ml-2"></i>
                                                                                </button>

                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>

                                                            <div class="d-flex justify-content-end mt-2">
                                                                <button class="btn btn-sidebar btn-xs bg-orange px-2 py-1"
                                                                onclick="this.disabled=true; this.form.submit();">
                                                                    <span class="text-white">Aceptar</span>
                                                                    <i class="fas fa-check fa-xs text-white ml-1"></i>
                                                                </button>
                                                                <button class="btn btn-sidebar btn-xs bg-orange px-2 py-1 ml-2">
                                                                    <span class="text-white">Cancelar</span>
                                                                    <i class="fas fa-xmark fa-xs text-white ml-1"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="tab-pane fade show {{ $activeTabParametros === 'custom-tabs-2' ? 'active' : '' }}"
                                                id="custom-tabs-2" role="tabpanel"
                                                aria-labelledby="custom-tabs-2-tab"
                                                style="height: 18rem; padding: 0.5rem;">
                                                <textarea class="form-control w-100 p-1"
                                                        rows="10"
                                                        placeholder="Escriba aquí..."
                                                        style="resize: none; font-size: 0.8rem;"
                                                        name="items[{{ $item_orden_trabajo->id }}][Observaciones]">{{ old('items[$item_orden_trabajo->id][Observaciones]', $item_orden_trabajo->Observaciones) }}</textarea>
                                            </div>
                                        </x-slot>
                                    </x-panel-horizontal2>
                                </div>
                            </td>
                        </tr>


                    @endforeach

                    @foreach ($newItems as $newItem)
                        <tr data-widget="expandable-table"
                            aria-expanded="{{ in_array($newItem['id'], $expanded) ? 'true' : 'false' }}"
                            wire:click="toggleExpand({{ $newItem['id'] }})">

                            <td>{{ $newItem['Descripcion'] }}</td>
                            <td>{{ $newItem['material_id'] ? $materiales->find($newItem['material_id'])->Nombre : '---' }}</td>
                            <td>{{ $newItem['Cantidad'] }}</td>
                            <td>{{ $newItem['Peso'] }}</td>
                            <td>{{ $newItem['tratamiento_id'] ? $tratamientos->find($newItem['tratamiento_id'])->Nombre : '---' }}</td>
                            <td>{{ $newItem['dureza_id'] ? $durezas->find($newItem['dureza_id'])->Nombre : '---' }}</td>
                            <td>{{ $newItem['DurezaSolicitadaMinima'] }}</td>
                            <td>{{ $newItem['DurezaSolicitadaMaxima'] }}</td>
                            <td colspan="4"></td>
                        </tr>

                        <tr class="expandable-body" style="display: {{ in_array($newItem['id'], $expanded) ? 'table-row' : 'none' }}; font-size: 0.8rem;">
                            <td colspan="15" class="p-0">
                                <div class="p-0 m-0">
                                    <x-panel-horizontal2>
                                        <x-slot name="pestañas">
                                            <li class="nav-item">
                                                <a class="nav-link {{ $activeTabParametros === 'custom-tabs-1' ? 'active' : '' }}"
                                                wire:click.prevent="setActiveTabParametros('custom-tabs-1')"
                                                id="custom-tabs-1-tab" data-toggle="pill"
                                                href="#custom-tabs-1" role="tab"
                                                aria-controls="custom-tabs-1" aria-selected="true"
                                                style="padding: 3px 8px; font-size: 0.75rem;">
                                                ITEM
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link {{ $activeTabParametros === 'custom-tabs-2' ? 'active' : '' }}"
                                                wire:click.prevent="setActiveTabParametros('custom-tabs-2')"
                                                id="custom-tabs-2-tab" data-toggle="pill"
                                                href="#custom-tabs-2" role="tab"
                                                aria-controls="custom-tabs-2" aria-selected="true"
                                                style="padding: 3px 8px; font-size: 0.75rem;">
                                                OBSERVACIONES
                                                </a>
                                            </li>
                                        </x-slot>

                                        <x-slot name="ventanas">
                                            <div class="tab-pane fade show {{ $activeTabParametros === 'custom-tabs-1' ? 'active' : '' }}"
                                                id="custom-tabs-1" role="tabpanel" aria-labelledby="custom-tabs-1-tab"
                                                style="height: 18rem; padding: 0.5rem;">
                                                <div class="row justify-content-center m-0">
                                                    <div class="col-10 card p-1">
                                                        <div class="card-body p-2">
                                                            <div class="row justify-content-center m-0">
                                                                <div class="col-4 mb-2 px-1">
                                                                    <label class="font-weight-normal mb-1" style="font-size: 0.75rem;">ITEM NRO</label>
                                                                    <input type="hidden" name="items[{{ $newItem['id'] }}][ItemNumero]" value="{{ ($item_orden_trabajo->ItemNumero ?? 0) + 1 }}">
                                                                    <input type="text" value="{{ ($item_orden_trabajo->ItemNumero ?? 0) + 1 }}" disabled class="form-control form-control-sm p-1" style="height: 22px;">
                                                                </div>
                                                                <div class="col-4 mb-2 px-1">
                                                                    <label class="font-weight-normal mb-1" style="font-size: 0.75rem;">DESCRIPCIÓN</label>
                                                                    <input type="text" name="items[{{ $newItem['id'] }}][Descripcion]" value="{{ old('items.' . $newItem['id'] . '.Descripcion', $newItem['Descripcion']) }}" class="form-control form-control-sm p-1" style="height: 22px;">
                                                                </div>
                                                                <div class="col-4 mb-2 px-1">
                                                                    <label class="font-weight-normal mb-1" style="font-size: 0.75rem;">NRO PLANO</label>
                                                                    <input type="text" name="items[{{ $newItem['id'] }}][NroPlano]" class="form-control form-control-sm p-1" style="height: 22px;">
                                                                </div>
                                                            </div>

                                                            <div class="row justify-content-center m-0">
                                                                <div class="col-4 mb-2 px-1">
                                                                    <label class="font-weight-normal mb-1" style="font-size: 0.75rem;">CANTIDAD</label>
                                                                    <input type="text" name="items[{{ $newItem['id'] }}][Cantidad]" value="{{ old('items.' . $newItem['id'] . '.Cantidad', $newItem['Cantidad']) }}" class="form-control form-control-sm p-1" style="height: 22px;">
                                                                </div>
                                                                <div class="col-4 mb-2 px-1">
                                                                    <label class="font-weight-normal mb-1" style="font-size: 0.75rem;">PESO</label>
                                                                    <input type="text" name="items[{{ $newItem['id'] }}][Peso]" value="{{ old('items.' . $newItem['id'] . '.Peso', $newItem['Peso']) }}" class="form-control form-control-sm p-1" style="height: 22px;">
                                                                </div>
                                                                <div class="col-4 mb-2 px-1">
                                                                    <label class="font-weight-normal mb-1" style="font-size: 0.7rem;">TRATAMIENTO</label>
                                                                    <div class="input-group input-group-sm">
                                                                        <select
                                                                            wire:model="newItems.{{ $newItem['id'] }}.tratamiento_id"
                                                                            class="form-control form-control-sm p-1"
                                                                            name="items[{{ $newItem['id'] }}][IdTratamiento]"
                                                                            style="height: 22px; font-size: 0.7rem; line-height: 1; padding-right: 20px;">
                                                                            @foreach ($tratamientos as $tratamiento)
                                                                                <option value="{{ $tratamiento->id }}"
                                                                                        style="font-size: 0.7rem; white-space: nowrap;">
                                                                                    {{ $tratamiento->Nombre }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                        <div class="input-group-append">
                                                                            <button type="button"
                                                                                    class="btn btn-sidebar btn-xs bg-orange p-1"
                                                                                    data-toggle="modal"
                                                                                    data-target="#modal-items-{{ $newItem['id'] }}-tratamiento">
                                                                                <i class="fas fa-search fa-xs text-white"></i>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <!-- .modal -->
                                                                <div class="modal fade" id="modal-items-{{ $newItem['id'] }}-tratamiento" wire:ignore.self>
                                                                    <div class="modal-dialog modal-dialog-centered">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                            <h5 class="modal-title">
                                                                                BUSCAR TRATAMIENTO
                                                                            </h5>
                                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                                </button>
                                                                            </div>
                                                                            <div class="modal-body">

                                                                                <div class="table-responsive" style="max-height: 70vh; overflow-y: auto;">
                                                                                    <x-simple-table2 class="table table-bordered table-hover table-striped w-100" style="font-size: 1rem;">
                                                                                        <x-slot name="thead">
                                                                                            <tr>
                                                                                                <th style="padding: 14px 18px; font-size: 1.1rem;">NOMBRE</th>
                                                                                            </tr>
                                                                                        </x-slot>

                                                                                        <x-slot name="tbody">

                                                                                            @forelse ($tratamientos as $tratamiento)
                                                                                                <tr wire:click.prevent="seleccionarTratamiento({{ $newItem['id'] }}, {{ $tratamiento->id }})"
                                                                                                    data-dismiss="modal"
                                                                                                    style="cursor:pointer; height: 55px;"
                                                                                                    class="{{ $newItem['tratamiento_id'] == $tratamiento->id ? 'table-primary' : '' }}">
                                                                                                    <td style="padding: 12px 18px;">{{ $tratamiento->Nombre }}</td>
                                                                                                </tr>
                                                                                            @empty
                                                                                                <tr><td colspan="8">No se encontraron resultados.</td></tr>
                                                                                            @endforelse

                                                                                        </x-slot>
                                                                                    </x-simple-table2>
                                                                                    </div>
                                                                                    </div>
                                                                                </div>

                                                                            </div>

                                                                            <div class="modal-footer justify-content-end">

                                                                                <button class="btn btn-sidebar btn-sm bg-orange" data-dismiss="modal">
                                                                                    <span class="text-white">Aceptar</span>
                                                                                    <i class="fas fa-check fa-fw text-white ml-2"></i>
                                                                                </button>

                                                                                <button class="btn btn-sidebar btn-sm bg-orange" data-dismiss="modal">
                                                                                    <span class="text-white">Cancelar</span>
                                                                                    <i class="fas fa-xmark fa-fw text-white ml-2"></i>
                                                                                </button>

                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- /.modal -->

                                                            </div>

                                                            <div class="row m-0">
                                                                <div class="col-4 mb-2 px-1">
                                                                    <label class="font-weight-normal mb-1" style="font-size: 0.7rem;">DUREZA</label>
                                                                    <div class="input-group input-group-sm">
                                                                        <select
                                                                            wire:model="newItems.{{ $newItem['id'] }}.dureza_id"
                                                                            class="form-control form-control-sm p-1"
                                                                            name="items[{{ $newItem['id'] }}][IdDureza]"
                                                                            style="height: 22px; font-size: 0.7rem; line-height: 1; padding-right: 20px;">
                                                                            @foreach ($durezas as $dureza)
                                                                                <option value="{{ $dureza->id }}"
                                                                                        style="font-size: 0.7rem; white-space: nowrap;">
                                                                                    {{ $dureza->Nombre }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                        <div class="input-group-append">
                                                                            <button type="button"
                                                                                    class="btn btn-sidebar btn-xs bg-orange p-1"
                                                                                    data-toggle="modal"
                                                                                    data-target="#modal-items-{{ $newItem['id'] }}-dureza">
                                                                                <i class="fas fa-search fa-xs text-white"></i>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <!-- Modal de DUREZA -->
                                                                <div class="modal fade" id="modal-items-{{ $newItem['id'] }}-dureza" wire:ignore.self>
                                                                    <div class="modal-dialog modal-dialog-centered">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title">BUSCAR DUREZA</h5>
                                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                    <span aria-hidden="true">&times;</span>
                                                                                </button>
                                                                            </div>

                                                                            <div class="modal-body">
                                                                                <div class="table-responsive" style="max-height: 70vh; overflow-y: auto;">
                                                                                    <x-simple-table2 class="table table-bordered table-hover table-striped w-100" style="font-size: 1rem;">
                                                                                        <x-slot name="thead">
                                                                                            <tr>
                                                                                                <th style="padding: 14px 18px; font-size: 1.1rem;">NOMBRE</th>
                                                                                            </tr>
                                                                                        </x-slot>

                                                                                        <x-slot name="tbody">
                                                                                            @forelse ($durezas as $dureza)
                                                                                                <tr wire:click.prevent="seleccionarDureza({{ $newItem['id'] }}, {{ $dureza->id }})"
                                                                                                    data-dismiss="modal"
                                                                                                    style="cursor:pointer; height: 55px;"
                                                                                                    class="{{ $newItem['dureza_id'] == $dureza->id ? 'table-primary' : '' }}">
                                                                                                    <td style="padding: 12px 18px;">{{ $dureza->Nombre }}</td>
                                                                                                </tr>
                                                                                            @empty
                                                                                                <tr><td class="text-center" style="padding: 12px;">No se encontraron resultados.</td></tr>
                                                                                            @endforelse
                                                                                        </x-slot>
                                                                                    </x-simple-table2>
                                                                                    </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="modal-footer justify-content-end">
                                                                                <button class="btn btn-sidebar btn-sm bg-orange" data-dismiss="modal">
                                                                                    <span class="text-white">Aceptar</span>
                                                                                    <i class="fas fa-check fa-fw text-white ml-2"></i>
                                                                                </button>
                                                                                <button class="btn btn-sidebar btn-sm bg-orange" data-dismiss="modal">
                                                                                    <span class="text-white">Cancelar</span>
                                                                                    <i class="fas fa-xmark fa-fw text-white ml-2"></i>
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-4 mb-2 px-1">
                                                                    <label class="font-weight-normal mb-1" style="font-size: 0.75rem;">DSMIN</label>
                                                                    <input type="text" name="items[{{ $newItem['id'] }}][DurezaSolicitadaMinima]" value="{{ old('items.' . $newItem['id'] . '.DurezaSolicitadaMinima', $newItem['DurezaSolicitadaMinima']) }}" class="form-control form-control-sm p-1" style="height: 22px;">
                                                                </div>

                                                                <div class="col-4 mb-2 px-1">
                                                                    <label class="font-weight-normal mb-1" style="font-size: 0.75rem;">DSMAX</label>
                                                                    <input type="text" name="items[{{ $newItem['id'] }}][DurezaSolicitadaMaxima]" value="{{ old('items.' . $newItem['id'] . '.DurezaSolicitadaMaxima', $newItem['DurezaSolicitadaMaxima']) }}" class="form-control form-control-sm p-1" style="height: 22px;">
                                                                </div>

                                                                <div class="col-4 mb-2 px-1">
                                                                    <label class="font-weight-normal mb-1" style="font-size: 0.7rem;">MATERIAL</label>
                                                                    <div class="input-group input-group-sm">
                                                                        <select
                                                                            wire:model="newItems.{{ $newItem['id'] }}.material_id"
                                                                            class="form-control form-control-sm p-1"
                                                                            name="items[{{ $newItem['id'] }}][IdMaterial]"
                                                                            style="height: 22px; font-size: 0.7rem; line-height: 1; padding-right: 20px;">
                                                                            @foreach ($materiales as $material)
                                                                                <option value="{{ $material->id }}"
                                                                                        {{ $material->Predeterminado == 1 ? 'selected' : '' }}
                                                                                        style="font-size: 0.7rem; white-space: nowrap;">
                                                                                    {{ $material->Nombre }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                        <div class="input-group-append">
                                                                            <button type="button"
                                                                                    class="btn btn-sidebar btn-xs bg-orange p-1"
                                                                                    data-toggle="modal"
                                                                                    data-target="#modal-items-{{ $newItem['id'] }}-material">
                                                                                <i class="fas fa-search fa-xs text-white"></i>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- Modal MATERIAL -->
                                                                <div class="modal fade" id="modal-items-{{ $newItem['id'] }}-material" wire:ignore.self>
                                                                    <div class="modal-dialog modal-dialog-centered">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title">BUSCAR MATERIAL</h5>
                                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                    <span aria-hidden="true">&times;</span>
                                                                                </button>
                                                                            </div>

                                                                            <div class="modal-body">
                                                                                <div class="table-responsive" style="max-height: 70vh; overflow-y: auto;">
                                                                                    <x-simple-table2 class="table table-bordered table-hover table-striped w-100" style="font-size: 1rem;">
                                                                                        <x-slot name="thead">
                                                                                            <tr>
                                                                                                <th style="padding: 14px 18px; font-size: 1.1rem;">NOMBRE</th>
                                                                                            </tr>
                                                                                        </x-slot>

                                                                                        <x-slot name="tbody">
                                                                                            @forelse ($materiales as $material)
                                                                                                <tr wire:click.prevent="seleccionarMaterial({{ $newItem['id'] }}, {{ $material->id }})"
                                                                                                    data-dismiss="modal"
                                                                                                    style="cursor:pointer; height: 55px;"
                                                                                                    class="{{ $newItem['material_id'] == $material->id ? 'table-primary' : '' }}">
                                                                                                    <td style="padding: 12px 18px;">{{ $material->Nombre }}</td>
                                                                                                </tr>
                                                                                            @empty
                                                                                                <tr><td class="text-center" style="padding: 12px;">No se encontraron resultados.</td></tr>
                                                                                            @endforelse
                                                                                        </x-slot>
                                                                                    </x-simple-table2>
                                                                                    </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="modal-footer justify-content-end">
                                                                                <button class="btn btn-sidebar btn-sm bg-orange" data-dismiss="modal">
                                                                                    <span class="text-white">Aceptar</span>
                                                                                    <i class="fas fa-check fa-fw text-white ml-2"></i>
                                                                                </button>
                                                                                <button class="btn btn-sidebar btn-sm bg-orange" data-dismiss="modal">
                                                                                    <span class="text-white">Cancelar</span>
                                                                                    <i class="fas fa-xmark fa-fw text-white ml-2"></i>
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>

                                                            <div class="d-flex justify-content-end mt-2">
                                                                <button class="btn btn-sidebar btn-xs bg-orange px-2 py-1"
                                                                onclick="this.disabled=true; this.form.submit();">
                                                                    <span class="text-white">Aceptar</span>
                                                                    <i class="fas fa-check fa-xs text-white ml-1"></i>
                                                                </button>
                                                                <button class="btn btn-sidebar btn-xs bg-orange px-2 py-1 ml-2">
                                                                    <span class="text-white">Cancelar</span>
                                                                    <i class="fas fa-xmark fa-xs text-white ml-1"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="tab-pane fade show {{ $activeTabParametros === 'custom-tabs-2' ? 'active' : '' }}"
                                                id="custom-tabs-2" role="tabpanel"
                                                aria-labelledby="custom-tabs-2-tab"
                                                style="height: 18rem; padding: 0.5rem;">
                                                <textarea class="form-control w-100 p-1"
                                                        rows="10"
                                                        placeholder="Escriba aquí..."
                                                        style="resize: none; font-size: 0.8rem;"
                                                        name="items[{{ $newItem['id'] }}][Observaciones]">{{ old('items.' . $newItem['id'] . '.Observaciones', $newItem['Observaciones'] ?? '') }}</textarea>
                                            </div>
                                        </x-slot>
                                    </x-panel-horizontal2>
                                </div>
                            </td>
                        </tr>

                    @endforeach


                    @php
                        $filasFaltantes = max(0, 12 - count($items_orden_trabajo));
                    @endphp

                    @for ($i = 8; $i < 12; $i++)
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                    @endfor

                </x-slot>

            </x-data-table-acordion3>

        </form>
        
    <!-- .modal -->
    <div class="modal fade" id="modal-cliente" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title">
                    BUSCAR CLIENTE
                </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                <div class="row">

                    <x-simple-table2>

                        <x-slot name="filtros">

                            <div class="row">
                                <div class="col-3">
                                    <div class="form-group mb-0">
                                        <label for="filtro1" class="font-weight-normal">NOMBRE</label>
                                        <input type="text" id="filtro1" name="filtro1" class="form-control form-control-sm">
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group mb-0">
                                        <label for="filtro2" class="font-weight-normal">NUMERO DE DOCUMENTO</label>
                                        <input type="text" id="filtro2" name="filtro1" class="form-control form-control-sm">
                                    </div>
                                </div>
                            </div>

                        </x-slot>

                        <x-slot name="thead">
                            <tr>
                                <th>CODIGO</th>
                                <th>NOMBRE</th>
                                <th>TIPO DE DOCUMENTO</th>
                                <th>NUMERO</th>
                                <th>DOMICILIO</th>
                                <th>LOCALIDAD</th>
                                <th>PROVINCIA</th>
                                <th>ACTIVO</th>
                            </tr>
                        </x-slot>
                        <x-slot name="tbody">
                            
                            @forelse ($clientes as $cliente)
                                <tr wire:click.prevent="seleccionarCliente({{ $cliente->id }})"
                                    style="cursor:pointer;"
                                    class="{{ $cliente_id == $cliente->id ? 'table-primary' : '' }}"
                                    data-dismiss="modal">
                                    <td>{{ $cliente->id }}</td>
                                    <td>{{ $cliente->Nombre }}</td>
                                    <td>{{ $cliente->TipoDocumento }}</td>
                                    <td>{{ $cliente->NroDocumento }}</td>
                                    <td>{{ $cliente->Domicilio }}</td>
                                    <td>{{ $cliente->localidad->Nombre ?? 'Ciudad no asignada' }}</td>
                                    <td>{{ $cliente->localidad->provincia->Nombre ?? 'Provincia no asignada' }}</td>
                                    <td><input type="checkbox" name="" id="" disabled {{ $cliente->Activo == 1 ? 'checked' : '' }}></td>
                                </tr>
                            @empty
                                <tr><td colspan="8">No se encontraron resultados.</td></tr>
                            @endforelse
                        </x-slot>
                    </x-simple-table2>
                    </div>
                    </div>

                </div>

                </div>

                <div class="modal-footer justify-content-end">

                    <button class="btn btn-sidebar btn-sm bg-orange" data-dismiss="modal">
                        <span class="text-white">Aceptar</span>
                        <i class="fas fa-check fa-fw text-white ml-2"></i>
                    </button>

                    <button class="btn btn-sidebar btn-sm bg-orange" data-dismiss="modal" wire:click="cancelarCliente">
                        <span class="text-white">Cancelar</span>
                        <i class="fas fa-xmark fa-fw text-white ml-2"></i>
                    </button>

                </div>

            </div>
        </div>
    </div>
    <!-- /.modal -->

    </x-layout2-sidebar>
    
</div>