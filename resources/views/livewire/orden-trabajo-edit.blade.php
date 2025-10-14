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

            <x-data-table-acordion2>

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

                    </div>

                </x-slot>

                <x-slot name="thead">
                    <tr class="bg-secondary text-white">
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
                            <td>{{ $item_orden_trabajo->material->Nombre }}</td>
                            <td>{{ $item_orden_trabajo->Cantidad }}</td>
                            <td>{{ $item_orden_trabajo->Peso }}</td>
    <td>{{ optional($tratamientos->firstWhere('id', $items_orden_trabajo_edit[$item_orden_trabajo->id]['tratamiento_id'] ?? $item_orden_trabajo->IdTratamiento))->Nombre }}</td>
                            <td>{{ $item_orden_trabajo->dureza->Nombre }}</td>
                            <td>{{ $item_orden_trabajo->DurezaSolicitadaMinima }}</td>
                            <td>{{ $item_orden_trabajo->DurezaSolicitadaMaxima }}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>

                        <tr class="expandable-body" style="display: {{ in_array($item_orden_trabajo->id, $expanded) ? 'table-row' : 'none' }};">
                            <td colspan="15">
                                <div class="p-0">
                                    <x-panel-horizontal2>

                                        <x-slot name="pestañas">

                                            <li class="nav-item">
                                                <a class="nav-link {{ $activeTabParametros === 'custom-tabs-1' ? 'active' : '' }}" wire:click.prevent="setActiveTabParametros('custom-tabs-1')" id="custom-tabs-1-tab" data-toggle="pill" href="#custom-tabs-1" role="tab" aria-controls="custom-tabs-1" aria-selected="true">ITEM</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link {{ $activeTabParametros === 'custom-tabs-2' ? 'active' : '' }}" wire:click.prevent="setActiveTabParametros('custom-tabs-2')" id="custom-tabs-2-tab" data-toggle="pill" href="#custom-tabs-2" role="tab" aria-controls="custom-tabs-2" aria-selected="true">OBSERVACIONES</a>
                                            </li>

                                        </x-slot>

                                        <x-slot name="ventanas">

                                            <div class="tab-pane fade show {{ $activeTabParametros === 'custom-tabs-1' ? 'active' : '' }}" id="custom-tabs-1" role="tabpanel" aria-labelledby="custom-tabs-1-tab"  style="height:23rem">

                                                <div class="row">
                                                    <div class="col-2"></div>
                                                    <div class="card col-8">
                                                        <div class="card-body">

                                                            <div class="row justify-content-center">

                                                                <div class="col-4 mb-3 mt-2">
                                                                    <div class="form-group mb-0">
                                                                        <label for="" class="font-weight-normal">ITEM NRO</label>
                                                                        <input type="hidden" name="items[{{ $item_orden_trabajo->id }}][ItemNumero]" value="{{ old('ItemNumero', $item_orden_trabajo->ItemNumero) }}">
                                                                        <input type="text" id="email1" name="" value="{{ old('ItemNumero', $item_orden_trabajo->ItemNumero) }}" disabled
                                                                            class="form-control form-control-sm">
                                                                    </div>
                                                                </div>
                                                                <div class="col-4 mb-3 mt-2">
                                                                    <div class="form-group mb-0">
                                                                        <label for="email2" class="font-weight-normal">DESCRIPCION</label>
                                                                        <input type="text" id="email2" name="items[{{ $item_orden_trabajo->id }}][Descripcion]" value="{{ old('items[$item_orden_trabajo->id][Descripcion]', $item_orden_trabajo->Descripcion) }}"
                                                                            class="form-control form-control-sm">
                                                                    </div>
                                                                </div>
                                                                <div class="col-4 mb-3 mt-2">
                                                                    <div class="form-group mb-0">
                                                                        <label for="email2" class="font-weight-normal">NRO PLANO</label>
                                                                        <input type="text" id="email2" name="" value=""
                                                                            class="form-control form-control-sm">
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            
                                                            <div class="row justify-content-center">

                                                                <div class="col-4 mb-3">
                                                                    <div class="form-group mb-0">
                                                                        <label for="email3" class="font-weight-normal">CANTIDAD</label>
                                                                        <input type="text" id="email3" name="items[{{ $item_orden_trabajo->id }}][Cantidad]"
                                                                            value="{{ old('items[$item_orden_trabajo->id][Cantidad]', $item_orden_trabajo->Cantidad) }}"
                                                                            class="form-control form-control-sm">
                                                                    </div>
                                                                </div>
                                                                <div class="col-4 mb-3">
                                                                    <div class="form-group mb-0">
                                                                        <label for="email4" class="font-weight-normal">PESO</label>
                                                                        <input type="text" id="email4" name="items[{{ $item_orden_trabajo->id }}][Peso]" value="{{ old('items[$item_orden_trabajo->id][Peso]', $item_orden_trabajo->Peso) }}"
                                                                            class="form-control form-control-sm">
                                                                    </div>
                                                                </div>

                                                                <div class="col-4 mb-3">

                                                                    <div class="form-group mb-0">
                                                                        <label for="filtro1" class="font-weight-normal">TRATAMIENTO</label>
                                                                    </div>
                                                                    <div class="input-group">
                                                                        <select wire:model="items_orden_trabajo_edit.{{ $item_orden_trabajo->id }}.tratamiento_id"
                                                                                class="form-control form-control-sm"
                                                                                name="items[{{ $item_orden_trabajo->id }}][IdTratamiento]">
                                                                            @foreach ($tratamientos as $tratamiento)
                                                                                <option value="{{ $tratamiento->id }}" {{ $item_orden_trabajo->IdTratamiento == $tratamiento->id ? 'selected' : '' }}>
                                                                                    {{ $tratamiento->Nombre }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                        <div class="input-group-append">
                                                                            <button type="button" class="btn btn-sidebar btn-sm bg-orange"
                                                                                    data-toggle="modal"
                                                                                    data-target="#modal-items-{{ $item_orden_trabajo->id }}-tratamiento">
                                                                                <i class="fas fa-search fa-fw text-white"></i>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal fade" id="modal-items-{{ $item_orden_trabajo->id }}-tratamiento" wire:ignore.self>
                                                                    <div class="modal-dialog modal-dialog-centered">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title">BUSCAR TRATAMIENTO</h5>
                                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <table class="table table-hover">
                                                                                    <tbody>
                                                                                        @foreach ($tratamientos as $tratamiento)
                                                                                            <tr wire:click.prevent="seleccionarTratamientoExistente({{ $item_orden_trabajo->id }}, {{ $tratamiento->id }})" 
                                                                                                data-dismiss="modal" 
                                                                                                style="cursor:pointer"
                                                                                                class="{{ $items_orden_trabajo_edit[$item_orden_trabajo->id]['tratamiento_id'] == $tratamiento->id ? 'table-primary' : '' }}">
                                                                                                <td>{{ $tratamiento->Nombre }}</td>
                                                                                            </tr>
                                                                                        @endforeach
                                                                                    </tbody>
                                                                                </table>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>

                                                            <div class="row">

                                                                <div class="col-4 mb-3">
                                                                    <div class="form-group mb-0">
                                                                        <label for="filtro1" class="font-weight-normal">DUREZA</label>
                                                                    </div>
                                                                    <div class="input-group">
                                                                        <select wire:model="items_orden_trabajo_edit.{{ $item_orden_trabajo->id }}.dureza_id"
                                                                                class="form-control form-control-sm"
                                                                                name="items[{{ $item_orden_trabajo->id }}][IdDureza]">
                                                                            @foreach ($durezas as $dureza)
                                                                                <option value="{{ $dureza->id }}">
                                                                                    {{ $dureza->Nombre }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>

                                                                        <div class="input-group-append">
                                                                            <button type="button" class="btn btn-sidebar btn-sm bg-orange"
                                                                                    data-toggle="modal"
                                                                                    data-target="#modal-items-{{ $item_orden_trabajo->id }}-dureza">
                                                                                <i class="fas fa-search fa-fw text-white"></i>
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
                                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <table class="table table-hover">
                                                                                    <tbody>
                                                                                        @foreach ($durezas as $dureza)
                                                                                            <tr wire:click.prevent="seleccionarDurezaExistente({{ $item_orden_trabajo->id }}, {{ $dureza->id }})"
                                                                                                data-dismiss="modal"
                                                                                                style="cursor:pointer"
                                                                                                class="{{ $items_orden_trabajo_edit[$item_orden_trabajo->id]['dureza_id'] == $dureza->id ? 'table-primary' : '' }}">
                                                                                                <td>{{ $dureza->Nombre }}</td>
                                                                                            </tr>
                                                                                        @endforeach
                                                                                    </tbody>
                                                                                </table>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-4 mb-3">
                                                                    <div class="form-group mb-0">
                                                                        <label for="email4" class="font-weight-normal">DSMIN</label>
                                                                        <input type="text" id="email4" name="items[{{ $item_orden_trabajo->id }}][DurezaSolicitadaMinima]" value="{{ old('items[$item_orden_trabajo->id][DurezaSolicitadaMinima]', $item_orden_trabajo->DurezaSolicitadaMinima) }}"
                                                                            class="form-control form-control-sm">
                                                                    </div>
                                                                </div>

                                                                <div class="col-4 mb-3">
                                                                    <div class="form-group mb-0">
                                                                        <label for="email4" class="font-weight-normal">DSMAX</label>
                                                                        <input type="text" id="email4" name="items[{{ $item_orden_trabajo->id }}][DurezaSolicitadaMaxima]" value="{{ old('items[$item_orden_trabajo->id][DurezaSolicitadaMaxima]', $item_orden_trabajo->DurezaSolicitadaMaxima) }}"
                                                                            class="form-control form-control-sm">
                                                                    </div>
                                                                </div>

                                                                <div class="col-4 mb-3">
                                                                    <div class="form-group mb-0">
                                                                        <label for="filtro1" class="font-weight-normal">MATERIAL</label>
                                                                    </div>
                                                                    <div class="input-group">
                                                                        <select wire:model="items_orden_trabajo_edit.{{ $item_orden_trabajo->id }}.material_id"
                                                                                class="form-control form-control-sm"
                                                                                name="items[{{ $item_orden_trabajo->id }}][IdMaterial]">
                                                                            @foreach ($materiales as $material)
                                                                                <option value="{{ $material->id }}">
                                                                                    {{ $material->Nombre }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>

                                                                        <div class="input-group-append">
                                                                            <button type="button" class="btn btn-sidebar btn-sm bg-orange"
                                                                                    data-toggle="modal"
                                                                                    data-target="#modal-items-{{ $item_orden_trabajo->id }}-material">
                                                                                <i class="fas fa-search fa-fw text-white"></i>
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
                                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <table class="table table-hover">
                                                                                    <tbody>
                                                                                        @foreach ($materiales as $material)
                                                                                            <tr wire:click.prevent="seleccionarMaterialExistente({{ $item_orden_trabajo->id }}, {{ $material->id }})"
                                                                                                data-dismiss="modal"
                                                                                                style="cursor:pointer"
                                                                                                class="{{ $items_orden_trabajo_edit[$item_orden_trabajo->id]['material_id'] == $material->id ? 'table-primary' : '' }}">
                                                                                                <td>{{ $material->Nombre }}</td>
                                                                                            </tr>
                                                                                        @endforeach
                                                                                    </tbody>
                                                                                </table>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="col-2"></div>
                                                </div>

                                            </div>

                                            <div class="tab-pane fade show {{ $activeTabParametros === 'custom-tabs-2' ? 'active' : '' }}" id="custom-tabs-2" role="tabpanel" aria-labelledby="custom-tabs-2-tab" style="height:23rem">

                                                <textarea class="form-control w-100" rows="13" placeholder="Escriba aquí..." style="resize: none;" name="items[{{ $item_orden_trabajo->id }}][Observaciones]">{{ old('items[$item_orden_trabajo->id][Observaciones]', $item_orden_trabajo->Observaciones) }}</textarea>

                                            </div>

                                            <div class="d-flex justify-content-end">
                                                <button class="btn btn-sidebar btn-sm bg-orange" data-dismiss="modal">
                                                    <span class="text-white">Aceptar</span>
                                                    <i class="fas fa-check fa-fw text-white ml-2"></i>
                                                </button>

                                                <button class="btn btn-sidebar btn-sm bg-orange ml-2" data-dismiss="modal">
                                                    <span class="text-white">Cancelar</span>
                                                    <i class="fas fa-xmark fa-fw text-white ml-2"></i>
                                                </button>
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

                        <tr class="expandable-body" style="display: {{ in_array($newItem['id'], $expanded) ? 'table-row' : 'none' }};">
                            <td colspan="15">
                                <div class="p-0">
                                    <x-panel-horizontal2>

                                        <x-slot name="pestañas">

                                            <li class="nav-item">
                                                <a class="nav-link {{ $activeTabParametros === 'custom-tabs-1' ? 'active' : '' }}" wire:click.prevent="setActiveTabParametros('custom-tabs-1')" id="custom-tabs-1-tab" data-toggle="pill" href="#custom-tabs-1" role="tab" aria-controls="custom-tabs-1" aria-selected="true">ITEM</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link {{ $activeTabParametros === 'custom-tabs-2' ? 'active' : '' }}" wire:click.prevent="setActiveTabParametros('custom-tabs-2')" id="custom-tabs-2-tab" data-toggle="pill" href="#custom-tabs-2" role="tab" aria-controls="custom-tabs-2" aria-selected="true">OBSERVACIONES</a>
                                            </li>

                                        </x-slot>

                                        <x-slot name="ventanas">

                                            <div class="tab-pane fade show {{ $activeTabParametros === 'custom-tabs-1' ? 'active' : '' }}" id="custom-tabs-1" role="tabpanel" aria-labelledby="custom-tabs-1-tab"  style="height:23rem">

                                                <div class="row">
                                                    <div class="col-2"></div>
                                                    <div class="card col-8">
                                                        <div class="card-body">

                                                            <div class="row justify-content-center">

                                                                <div class="col-4 mb-3 mt-2">
                                                                    <div class="form-group mb-0">
                                                                        <label for="" class="font-weight-normal">ITEM NRO</label>
                                                                        <input type="hidden" name="items[{{ $newItem['id'] }}][ItemNumero]" value="{{ ($item_orden_trabajo->ItemNumero ?? 0) + 1 }}">
                                                                        <input type="text" id="email1" name="" disabled value="{{ ($item_orden_trabajo->ItemNumero ?? 0) + 1 }}"
                                                                            class="form-control form-control-sm">
                                                                    </div>
                                                                </div>
                                                                <div class="col-4 mb-3 mt-2">
                                                                    <div class="form-group mb-0">
                                                                        <label for="email2" class="font-weight-normal">DESCRIPCION</label>
                                                                        <input type="text" id="email2" name="items[{{ $newItem['id'] }}][Descripcion]" value="{{ old('items.' . $newItem['id'] . '.Descripcion', $newItem['Descripcion']) }}"
                                                                            class="form-control form-control-sm">
                                                                    </div>
                                                                </div>
                                                                <div class="col-4 mb-3 mt-2">
                                                                    <div class="form-group mb-0">
                                                                        <label for="email2" class="font-weight-normal">NRO PLANO</label>
                                                                        <input type="text" id="email2" name="" value=""
                                                                            class="form-control form-control-sm">
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            
                                                            <div class="row justify-content-center">

                                                                <div class="col-4 mb-3">
                                                                    <div class="form-group mb-0">
                                                                        <label for="email3" class="font-weight-normal">CANTIDAD</label>
                                                                        <input type="text" id="email3" name="items[{{ $newItem['id'] }}][Cantidad]" value="{{ old('items.' . $newItem['id'] . '.Cantidad', $newItem['Cantidad']) }}"
                                                                            class="form-control form-control-sm">
                                                                    </div>
                                                                </div>
                                                                <div class="col-4 mb-3">
                                                                    <div class="form-group mb-0">
                                                                        <label for="email4" class="font-weight-normal">PESO</label>
                                                                        <input type="text" id="email4" name="items[{{ $newItem['id'] }}][Peso]" value="{{ old('items.' . $newItem['id'] . '.Peso', $newItem['Peso']) }}"
                                                                            class="form-control form-control-sm">
                                                                    </div>
                                                                </div>

                                                                <div class="col-4 mb-3">

                                                                    <div class="form-group mb-0">
                                                                        <label for="filtro1" class="font-weight-normal">TRATAMIENTO</label>
                                                                    </div>
                                                                    <div class="input-group">
                                                                        <select wire:model="newItems.{{ $newItem['id'] }}.tratamiento_id"
                                                                                class="form-control form-control-sm"
                                                                                name="items[{{ $newItem['id'] }}][IdTratamiento]">
                                                                            @foreach ($tratamientos as $tratamiento)
                                                                                <option value="{{ $tratamiento->id }}">
                                                                                    {{ $tratamiento->Nombre }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>

                                                                        <div class="input-group-append">
                                                                            <button type="button" 
                                                                                    class="btn btn-sidebar btn-sm bg-orange" 
                                                                                    data-toggle="modal" 
                                                                                    data-target="#modal-items-{{ $newItem['id'] }}-tratamiento">
                                                                                <i class="fas fa-search fa-fw text-white"></i>
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

                                                            <div class="row">

                                                                <div class="col-4 mb-3">
                                                                    <div class="form-group mb-0">
                                                                        <label class="font-weight-normal">DUREZA</label>
                                                                    </div>
                                                                    <div class="input-group">
                                                                        <select
                                                                            wire:model="newItems.{{ $newItem['id'] }}.dureza_id"
                                                                            class="form-control form-control-sm"
                                                                            name="items[{{ $newItem['id'] }}][IdDureza]"
                                                                        >
                                                                            @foreach ($durezas as $dureza)
                                                                                <option value="{{ $dureza->id }}">
                                                                                    {{ $dureza->Nombre }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>

                                                                        <div class="input-group-append">
                                                                            <button type="button" 
                                                                                    class="btn btn-sidebar btn-sm bg-orange" 
                                                                                    data-toggle="modal" 
                                                                                    data-target="#modal-items-{{ $newItem['id'] }}-dureza">
                                                                                <i class="fas fa-search fa-fw text-white"></i>
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


                                                                <div class="col-4 mb-3">
                                                                    <div class="form-group mb-0">
                                                                        <label for="email4" class="font-weight-normal">DSMIN</label>
                                                                        <input type="text" id="email4" name="items[{{ $newItem['id'] }}][DurezaSolicitadaMinima]" value="{{ old('items.' . $newItem['id'] . '.DurezaSolicitadaMinima', $newItem['DurezaSolicitadaMinima']) }}"
                                                                            class="form-control form-control-sm">
                                                                    </div>
                                                                </div>

                                                                <div class="col-4 mb-3">
                                                                    <div class="form-group mb-0">
                                                                        <label for="email4" class="font-weight-normal">DSMAX</label>
                                                                        <input type="text" id="email4" name="items[{{ $newItem['id'] }}][DurezaSolicitadaMaxima]" value="{{ old('items.' . $newItem['id'] . '.DurezaSolicitadaMaxima', $newItem['DurezaSolicitadaMaxima']) }}"
                                                                            class="form-control form-control-sm">
                                                                    </div>
                                                                </div>

                                                                    <div class="col-4 mb-3">
                                                                        <div class="form-group mb-0">
                                                                            <label class="font-weight-normal">MATERIAL</label>
                                                                        </div>
                                                                        <div class="input-group">
                                                                            <select
                                                                                wire:model="newItems.{{ $newItem['id'] }}.material_id"
                                                                                class="form-control form-control-sm"
                                                                                name="items[{{ $newItem['id'] }}][IdMaterial]"
                                                                            >
                                                                                @foreach ($materiales as $material)
                                                                                    <option value="{{ $material->id }}">
                                                                                        {{ $material->Nombre }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>

                                                                            <div class="input-group-append">
                                                                                <button type="button" 
                                                                                        class="btn btn-sidebar btn-sm bg-orange" 
                                                                                        data-toggle="modal" 
                                                                                        data-target="#modal-items-{{ $newItem['id'] }}-material">
                                                                                    <i class="fas fa-search fa-fw text-white"></i>
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

                                                        </div>
                                                    </div>
                                                    <div class="col-2"></div>
                                                </div>

                                            </div>

                                            <div class="tab-pane fade show {{ $activeTabParametros === 'custom-tabs-2' ? 'active' : '' }}" id="custom-tabs-2" role="tabpanel" aria-labelledby="custom-tabs-2-tab" style="height:23rem">

                                                <textarea class="form-control w-100" rows="13" placeholder="Escriba aquí..." style="resize: none;" name="items[{{ $newItem['id'] }}][Observaciones]">{{ old('items.' . $newItem['id'] . '.Observaciones', $newItem['Observaciones'] ?? '') }}</textarea>

                                            </div>

                                            <div class="d-flex justify-content-end">
                                                <button class="btn btn-sidebar btn-sm bg-orange" data-dismiss="modal">
                                                    <span class="text-white">Aceptar</span>
                                                    <i class="fas fa-check fa-fw text-white ml-2"></i>
                                                </button>

                                                <button class="btn btn-sidebar btn-sm bg-orange ml-2" data-dismiss="modal">
                                                    <span class="text-white">Cancelar</span>
                                                    <i class="fas fa-xmark fa-fw text-white ml-2"></i>
                                                </button>
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

                    @for ($i = 0; $i < $filasFaltantes; $i++)
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

            </x-data-table-acordion2>

            <div class="row d-flex justify-content-end">
                <div>
                    <button class="btn btn-app bg-primary">
                        <i class="fas fa-floppy-disk"></i> Guardar
                    </button>
                </div>
            </div>

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
                                    class="{{ $cliente_id == $cliente->id ? 'table-primary' : '' }}">
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