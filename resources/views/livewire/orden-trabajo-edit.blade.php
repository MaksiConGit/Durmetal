<div>

<div x-data="{ open: null }"
     x-on:open-item.window="open = $event.detail.id">
    <x-layout2-sidebar>
        <x-slot name="title">Editar Orden de Trabajo</x-slot>

        <x-slot name="filtros">

            <div class="form-inline mt-5 mr-3 d-flex flex-column align-items-center">

                <div class="form-group mb-3">
                <button 
                    type="button"
                    wire:click="addNewItem"
                    class="btn btn-app bg-primary"
                >
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

        <x-data-table-acordion3>

            <x-slot name="filtros">

                <div class="row mb-3">

                    <div class="col-2">
                        <div class="form-group mb-0">
                            <label for="PuntoVenta" class="font-weight-normal">PUNTO DE VENTA</label>
                            <select name="PuntoVenta" id="PuntoVenta" class="form-control form-control-sm">
                                @foreach ($pto_ventas as $pto_venta)
                                    <option value="{{ $pto_venta->id }}" {{$pto_venta->id == $pto_venta_seleccionado_id ? 'selected' : ''}}>{{ $pto_venta->Nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group mb-0">
                            <label for="Numero" class="font-weight-normal">NUMERO</label>
                            <input type="text" id="Numero" name="Numero" value="{{ $numero }}" class="form-control form-control-sm filtro-input" disabled>
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
                            <input type="date" id="FechaEmision" name="FechaEmision" value="{{ $fecha_emision }}" class="form-control form-control-sm filtro-input">
                        </div>
                    </div>

                    <div class="col-2">
                        <div class="form-group mb-0">
                            <label for="NumeroRemitoCliente" class="font-weight-normal">N° REMITO CLIENTE</label>
                            <input type="number" id="NumeroRemitoCliente" name="NumeroRemitoCliente" wire:model.live="numero_remito_cliente" class="form-control form-control-sm filtro-input">
                        </div>
                    </div>

                    <div 
                        x-data="{ disabled: false }"
                        wire:ignore
                        class="row d-flex justify-content-end ml-5"
                    >
                        <div>
                            <button 
                                x-on:click="disabled = true"
                                x-bind:disabled="disabled"
                                wire:click="guardar"
                                class="btn btn-app bg-primary"
                            >
                                <span x-show="!disabled">
                                    <i class="fas fa-floppy-disk"></i> Guardar
                                </span>

                                <span x-show="disabled">
                                    Guardando...
                                </span>
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
                            <input id="sidebarSearch" wire:model.live="cliente_id"
                                class="form-control form-control-sm bg-white text-dark" 
                                type="search" aria-label="Search" name="IdCliente">
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
                            <input type="text" id="Numero" name="Numero" wire:model.live="cliente_nombre" class="form-control form-control-sm filtro-input" disabled>
                        </div>
                    </div>

                    <div class="col-2"></div>

                    <div class="col-4 mt-4">
                        <div class="custom-control custom-checkbox">
                            <input type="hidden" name="Archivado" value="0">
                            <input class="custom-control-input" type="checkbox" id="Archivado" name="Archivado" value="1" @checked($orden_trabajo?->Archivado)>
                            <label for="Archivado" class="custom-control-label">ARCHIVADO</label>
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

            <tbody x-on:close-all.window="open = null">

                @foreach ($newItems as $index => $newItem)
                    <tr
                        wire:key="new-item-{{ $newItem['id'] }}"
                        @click="open = open === {{ $newItem['id'] }} ? null : {{ $newItem['id'] }}"

                                            style="cursor: pointer;"
                        >
                            <td>{{ $newItem['Descripcion'] }}</td>
                            <td>{{ $materialesMap[$newItem['material_id']]->Nombre ?? '---' }}</td>
                            <td>{{ $newItem['Cantidad'] }}</td>
                            <td>{{ $newItem['Peso'] }}</td>
                            <td>{{ $tratamientosMap[$newItem['tratamiento_id']]->Nombre ?? '---' }}</td>
                            <td>{{ $durezasMap[$newItem['dureza_id']]->Nombre ?? '---' }}</td>
                            <td>{{ $newItem['DurezaSolicitadaMinima'] }}</td>
                            <td>{{ $newItem['DurezaSolicitadaMaxima'] }}</td>
                            <td>{{ $newItem['Estado'] }}</td>
                            <td>{{ $newItem['CC'] }}</td>

                            @if ($newItem['Estado'] == 'APROBADO')

                                <td class="text-start align-middle">
                                    <div class="d-flex align-items-center ms-2">
                                        <div style="margin-right:12px;" >
                                            <button
                                                type="button"
                                                @click.stop="abrirModal('modal-certificado-{{$newItem['id']}}')"
                                                class="d-flex align-items-center justify-content-center"
                                                style="
                                                    width:52px;
                                                    height:26px;
                                                    background-color: {{ $newItem['CantidadCertificadosImpresos'] > 0 ? '#28a745' : '#f28c00' }};
                                                    color:white;
                                                    border:none;
                                                    border-radius:3px;
                                                "
                                            >
                                                @if ($newItem['CantidadCertificadosImpresos'] > 0)
                                                    <span style="margin-right:6px;">
                                                        {{ $newItem['CantidadCertificadosImpresos'] }}
                                                    </span>
                                                @endif
                                            <i class="fa fa-print"></i>
                                            </button>
                                        </div>

                                        <div>
                                            <button
                                                type="button"
                                                @click.stop="abrirModal('modal-correo-{{$newItem['id']}}')"
                                                class="d-flex align-items-center justify-content-center"
                                                style="
                                                    width:52px;
                                                    height:26px;
                                                    background-color: {{ $newItem['CantidadCertificadosEnviadosPorCorreo'] > 0 ? '#28a745' : '#f28c00' }};
                                                    color:white;
                                                    border:none;
                                                    border-radius:3px;
                                                "
                                            >
                                                @if ($newItem['CantidadCertificadosEnviadosPorCorreo'] > 0)
                                                    <span style="margin-right:6px;">
                                                        {{ $newItem['CantidadCertificadosEnviadosPorCorreo'] }}
                                                    </span>
                                                @endif
                                                <i class="fa fa-envelope"></i>
                                            </button>
                                        </div>
                                        
                                    </div>
                                </td>
                                <td>{{ $newItem['NotaEnvio'] }}</td>
                            @else
                                <td></td>
                                <td>{{ $newItem['NotaEnvio'] }}</td>
                            @endif


                        </tr>

                        <tr
                        x-show="open === {{ $newItem['id'] }}"    x-cloak
                            x-transition
                        >                     
                            <td colspan="15" class="p-0">
                                <div class="expand-wrapper">

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
                                                    <div class="card-body p-2"
                                                        x-data
                                                        x-on:keydown.enter.prevent="
                                                            let inputs = Array.from(
                                                                $el.querySelectorAll('input:not([type=hidden]):not([disabled]), select:not([disabled]), textarea:not([disabled])')
                                                            ).filter(el => el.offsetParent !== null);

                                                            let index = inputs.indexOf(document.activeElement);

                                                            if (inputs[index + 1]) inputs[index + 1].focus();
                                                        ">
                                                        <div class="row justify-content-center m-0">
                                                            <div class="col-4 mb-2 px-1">
                                                                <label class="font-weight-normal mb-1" style="font-size: 0.75rem;">ITEM NRO</label>
                                                                <input type="hidden" name="items[{{ $newItem['id'] }}][ItemNumero]" value="{{ ($item_orden_trabajo->ItemNumero ?? 0) + 1 }}">
                                                                <input type="text" value="{{ ($item_orden_trabajo->ItemNumero ?? 0) + 1 }}" disabled class="form-control form-control-sm p-1" style="height: 22px;">
                                                            </div>
                                                            <div class="col-4 mb-2 px-1">
                                                                <label class="font-weight-normal mb-1" style="font-size: 0.75rem;">DESCRIPCIÓN</label>
                                                                <input type="text" wire:model.defer="newItems.{{ $index }}.Descripcion" class="form-control form-control-sm p-1" style="height: 22px;">
                                                            </div>
                                                            <div class="col-4 mb-2 px-1">
                                                                <label class="font-weight-normal mb-1" style="font-size: 0.75rem;">NRO PLANO</label>
                                                                <input type="text" wire:model.defer="newItems.{{ $index }}.NroPlano" class="form-control form-control-sm p-1" style="height: 22px;">
                                                            </div>
                                                        </div>

                                                        <div class="row justify-content-center m-0">
                                                            <div class="col-4 mb-2 px-1">
                                                                <label class="font-weight-normal mb-1" style="font-size: 0.75rem;">CANTIDAD</label>
                                                                <input type="number" wire:model.defer="newItems.{{ $index }}.Cantidad" class="form-control form-control-sm p-1" style="height: 22px;">
                                                            </div>
                                                            <div class="col-4 mb-2 px-1">
                                                                <label class="font-weight-normal mb-1" style="font-size: 0.75rem;">PESO</label>
                                                                <input type="text" wire:model.defer="newItems.{{ $index }}.Peso" class="form-control form-control-sm p-1" style="height: 22px;">
                                                            </div>
                                                            <div class="col-4 mb-2 px-1">
                                                                <label class="font-weight-normal mb-1" style="font-size: 0.7rem;">TRATAMIENTO</label>
                                                                <div class="input-group input-group-sm">
                                                                    <select
                                                                        wire:model.live="newItems.{{ $index }}.tratamiento_id"
                                                                        class="form-control form-control-sm p-1"
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
                                                                                <div class="mb-2">
                                                                                    <input 
                                                                                        type="text"
                                                                                        wire:model.live="searchTratamiento"
                                                                                        class="form-control"
                                                                                        placeholder="Buscar tratamiento..."
                                                                                    >
                                                                                </div>
                                                                                <x-simple-table2 class="table table-bordered table-hover table-striped w-100" style="font-size: 1rem;">
                                                                                    <x-slot name="thead">
                                                                                        <tr>
                                                                                            <th style="padding: 14px 18px; font-size: 1.1rem;">NOMBRE</th>
                                                                                        </tr>
                                                                                    </x-slot>

                                                                                    <x-slot name="tbody">

                                                                                        {{-- @forelse ($tratamientos as $tratamiento) --}}
                                                                                        @php
                                                                                            $maxFilas = 8;
                                                                                            $cantidad = count($this->tratamientosFiltrados);
                                                                                        @endphp
                                                                                        @foreach ($this->tratamientosFiltrados as $tratamiento)
                                                                                            <tr 
                                                                                                wire:click.prevent="seleccionarTratamiento({{ $index }}, {{ $tratamiento->id }})"
                                                                                                data-dismiss="modal"
                                                                                                style="cursor:pointer; height: 55px;"
                                                                                                class="{{ $newItem['tratamiento_id'] == $tratamiento->id ? 'table-primary' : '' }}"
                                                                                            >
                                                                                                <td style="padding: 12px 18px;">{{ $tratamiento->Nombre }}</td>
                                                                                            </tr>
                                                                                        @endforeach
                                                                                        @for ($i = $cantidad; $i < $maxFilas; $i++)
                                                                                            <tr style="height: 55px;">
                                                                                                <td style="padding: 12px 18px;">&nbsp;</td>
                                                                                            </tr>
                                                                                        @endfor

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
                                                                        wire:model.defer="newItems.{{ $index }}.dureza_id"
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
                                                                                <div class="mb-2">
                                                                                    <input 
                                                                                        type="text"
                                                                                        wire:model.live="searchDureza"
                                                                                        class="form-control"
                                                                                        placeholder="Buscar dureza..."
                                                                                    >
                                                                                </div>
                                                                                <x-simple-table2 class="table table-bordered table-hover table-striped w-100" style="font-size: 1rem;">
                                                                                    <x-slot name="thead">
                                                                                        <tr>
                                                                                            <th style="padding: 14px 18px; font-size: 1.1rem;">NOMBRE</th>
                                                                                        </tr>
                                                                                    </x-slot>

                                                                                    <x-slot name="tbody">
                                                                                        {{-- @forelse ($durezas as $dureza)
                                                                                            <tr wire:click.prevent="seleccionarDureza({{ $newItem['id'] }}, {{ $dureza->id }})"
                                                                                                data-dismiss="modal"
                                                                                                style="cursor:pointer; height: 55px;"
                                                                                                class="{{ $newItem['dureza_id'] == $dureza->id ? 'table-primary' : '' }}">
                                                                                                <td style="padding: 12px 18px;">{{ $dureza->Nombre }}</td>
                                                                                            </tr>
                                                                                        @empty
                                                                                            <tr><td class="text-center" style="padding: 12px;">No se encontraron resultados.</td></tr>
                                                                                        @endforelse --}}

                                                                                        @php
                                                                                            $maxFilas = 8;
                                                                                            $cantidad = count($this->durezasFiltradas);
                                                                                        @endphp
                                                                                        @foreach ($this->durezasFiltradas as $dureza)
                                                                                            <tr 
                                                                                                wire:click.prevent="seleccionarDureza({{ $index }}, {{ $dureza->id }})"
                                                                                                data-dismiss="modal"
                                                                                                style="cursor:pointer; height: 55px;"
                                                                                                class="{{ $newItem['dureza_id'] == $dureza->id ? 'table-primary' : '' }}"
                                                                                            >
                                                                                                <td style="padding: 12px 18px;">{{ $dureza->Nombre }}</td>
                                                                                            </tr>
                                                                                        @endforeach
                                                                                        @for ($i = $cantidad; $i < $maxFilas; $i++)
                                                                                            <tr style="height: 55px;">
                                                                                                <td style="padding: 12px 18px;">&nbsp;</td>
                                                                                            </tr>
                                                                                        @endfor



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
                                                                <input type="text" wire:model.defer="newItems.{{ $index }}.DurezaSolicitadaMinima" class="form-control form-control-sm p-1" style="height: 22px;">
                                                            </div>

                                                            <div class="col-4 mb-2 px-1">
                                                                <label class="font-weight-normal mb-1" style="font-size: 0.75rem;">DSMAX</label>
                                                                <input type="text" wire:model.defer="newItems.{{ $index }}.DurezaSolicitadaMaxima" class="form-control form-control-sm p-1" style="height: 22px;">
                                                            </div>

                                                            <div class="col-4 mb-2 px-1">
                                                                <label class="font-weight-normal mb-1" style="font-size: 0.7rem;">MATERIAL</label>
                                                                <div class="input-group input-group-sm">
                                                                    <select
                                                                        wire:model.defer="newItems.{{ $index }}.material_id"
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
                                                                                <div class="mb-2">
                                                                                    <input 
                                                                                        type="text"
                                                                                        wire:model.live="searchMaterial"
                                                                                        class="form-control"
                                                                                        placeholder="Buscar material..."
                                                                                    >
                                                                                </div>
                                                                                <x-simple-table2 class="table table-bordered table-hover table-striped w-100" style="font-size: 1rem;">
                                                                                    <x-slot name="thead">
                                                                                        <tr>
                                                                                            <th style="padding: 14px 18px; font-size: 1.1rem;">NOMBRE</th>
                                                                                        </tr>
                                                                                    </x-slot>

                                                                                    <x-slot name="tbody">
                                                                                        {{-- @forelse ($materiales as $material)
                                                                                            <tr wire:click.prevent="seleccionarMaterial({{ $newItem['id'] }}, {{ $material->id }})"
                                                                                                data-dismiss="modal"
                                                                                                style="cursor:pointer; height: 55px;"
                                                                                                class="{{ $newItem['material_id'] == $material->id ? 'table-primary' : '' }}">
                                                                                                <td style="padding: 12px 18px;">{{ $material->Nombre }}</td>
                                                                                            </tr>
                                                                                        @empty
                                                                                            <tr><td class="text-center" style="padding: 12px;">No se encontraron resultados.</td></tr>
                                                                                        @endforelse --}}

                                                                                        @php
                                                                                            $maxFilas = 8;
                                                                                            $cantidad = count($this->materialesFiltrados);
                                                                                        @endphp
                                                                                        @foreach ($this->materialesFiltrados as $material)
                                                                                            <tr 
                                                                                                wire:click.prevent="seleccionarMaterial({{ $index }}, {{ $material->id }})"
                                                                                                data-dismiss="modal"
                                                                                                style="cursor:pointer; height: 55px;"
                                                                                                class="{{ $newItem['material_id'] == $material->id ? 'table-primary' : '' }}"
                                                                                            >
                                                                                                <td style="padding: 12px 18px;">{{ $material->Nombre }}</td>
                                                                                            </tr>
                                                                                        @endforeach
                                                                                        @for ($i = $cantidad; $i < $maxFilas; $i++)
                                                                                            <tr style="height: 55px;">
                                                                                                <td style="padding: 12px 18px;">&nbsp;</td>
                                                                                            </tr>
                                                                                        @endfor

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

                                                            @if (!$newItem['is_new'])
                                                                
                                                                <div class="col-4 mb-2 px-1">
                                                                    <label class="font-weight-normal mb-1" style="font-size: 0.7rem;">CC</label>
                                                                    <div class="input-group input-group-sm">

                                                                        <select
                                                                            wire:model.defer="newItems.{{ $index }}.CC"
                                                                            class="form-control form-control-sm p-1"
                                                                            style="height: 22px; font-size: 0.7rem; line-height: 1; padding-right: 20px;">

                                                                                @php
                                                                                    $tratamiento = $tratamientosMap[$newItem['tratamiento_id']] ?? null;
                                                                                @endphp

                                                                                <option
                                                                                    value="0"
                                                                                    style="font-size: 0.7rem; white-space: nowrap;"
                                                                                    {{ ($newItem['CC'] ?? 0) == 0 ? 'selected' : '' }}
                                                                                >
                                                                                    0
                                                                                </option>

                                                                                @foreach ($tratamiento?->precios?->sortBy('CC') ?? collect() as $precio)

                                                                                    <option
                                                                                        value="{{ $precio->CC }}"
                                                                                        style="font-size: 0.7rem; white-space: nowrap;"
                                                                                        {{ ($newItem['CC'] ?? null) == $precio->CC ? 'selected' : '' }}
                                                                                    >
                                                                                        {{ $precio->CC }}
                                                                                    </option>
                                                                                @endforeach
                                                                        </select>
                                                                        <div class="input-group-append">
                                                                            <button type="button"
                                                                                    class="btn btn-sidebar btn-xs bg-orange p-1"
                                                                                    data-toggle="modal"
                                                                                    data-target="#modal-items-{{ $newItem['id'] }}-cc">
                                                                                <i class="fas fa-search fa-xs text-white"></i>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                
                                                                <!-- .modal -->
                                                                <div class="modal fade" id="modal-items-{{ $newItem['id'] }}-cc" wire:ignore.self>
                                                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                            <h5 class="modal-title text-bold">
                                                                                BUSCAR CC
                                                                            </h5>
                                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                                </button>
                                                                            </div>
                                                                            <div class="modal-body">

                                                                            <div class="row">

                                                                                <x-simple-table2>

                                                                                    <x-slot name="thead">
                                                                                        <tr>
                                                                                            <th>CC</th>
                                                                                            <th>DESCRIPCION</th>
                                                                                            <th>PRECIO</th>
                                                                                            <th>COEFICIENTE</th>
                                                                                        </tr>
                                                                                    </x-slot>
                                                                                    <x-slot name="tbody">
                                                                                        @php
                                                                                            $tratamiento = $tratamientosMap[$newItem['tratamiento_id']] ?? null;
                                                                                        @endphp

                                                                                        @forelse ($tratamiento?->precios?->sortBy('CC') ?? collect() as $precio)

                                                                                            <tr
                                                                                                wire:click="seleccionarCC({{ $index }}, {{ $precio->CC }})"
                                                                                                data-dismiss="modal"
                                                                                                style="cursor: pointer; height: 55px;"
                                                                                                class="{{ ($newItem['CC'] ?? 0) == $precio->CC ? 'table-primary' : '' }}"
                                                                                            >
                                                                                                <td>{{ $precio->CC }}</td>

                                                                                                <td
                                                                                                    style="min-width: 400px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"
                                                                                                    title="{{ $precio->Descripcion }}"
                                                                                                >
                                                                                                    {{ $precio->Descripcion }}
                                                                                                </td>

                                                                                                <td>
                                                                                                    {{ number_format($precio->Precio, 2, ',', '.') }}
                                                                                                </td>

                                                                                                <td>
                                                                                                    {{ number_format($precio->Coeficiente, 3, ',', '.') }}
                                                                                                </td>
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
                                                                                    <span class="text-white">Cerrar</span>
                                                                                    <i class="fas fa-xmark fa-fw text-white ml-2"></i>
                                                                                </button>

                                                                            </div>
                                                                            </div>
                                                                            </div>

                                                                </div>
                                                                <!-- /.modal -->
                                                                
                                                            @endif

                                                        </div>

                                                        <div class="d-flex justify-content-end mt-2">
                                                            <button class="btn btn-sidebar btn-xs bg-orange px-2 py-1"
                                                            wire:click="validar" wire:loading.class="disabled" wire:target="validar">
                                                                <span class="text-white">Aceptar</span>
                                                                <i class="fas fa-check fa-xs text-white ml-1"></i>
                                                            </button>
                                                            <button
                                                                class="btn btn-sidebar btn-xs bg-orange px-2 py-1 ml-2"
                                                                @click="open = null"
                                                                wire:click="cancelarItem({{ $newItem['id'] }})"
                                                                type="button"
                                                            >
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
                                                    wire:model.defer="observaciones"></textarea>
                                        </div>
                                    </x-slot>
                                </x-panel-horizontal2>
                            </div>
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

    <div class="modal fade" id="error-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-warning text-white">
                    <h4 class="modal-title">Error</h4>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>{{ $errors->first() }}</p>
                </div>
                <div class="modal-footer justify-content-end">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
                </div>
            </div>
        </div>
    </div>

   @foreach ($items_orden_trabajo as $item)

        <div
            class="modal fade"
            id="modal-certificado-{{ $item->id }}"
            wire:ignore.self
        >
            <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">IMPRIMIR CERTIFICADO</h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">

                        <div class="row">
                            <div class="col-3">
                                <label>&nbsp;</label>
                                <select
                                    class="form-control form-control-sm"
                                    wire:model.live="certificadoSeleccionado.{{ $item->id }}"
                                >
                                    <option value="">Nuevo</option>
                                    @foreach ($item->certificados as $certificado)
                                        <option value="{{ $certificado->id }}">
                                            {{ $certificado->Nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-3">
                                <label>NUMERO DE PLANO</label>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    wire:model.live="numeroPlano.{{ $item->id }}"
                                >
                            </div>

                            <div class="col-3">
                                <label>CANTIDAD</label>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    wire:model.live="cantidad.{{ $item->id }}"
                                >
                            </div>

                            <div class="col-3">
                                <label>RESPONSABLE TECNICO</label>
                                <select
                                    class="form-control form-control-sm"
                                    wire:model.live="responsableId.{{ $item->id }}"
                                >
                                    <option value="">Seleccione</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">
                                            {{ $user->Nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mt-4">
                            <label>OBSERVACIONES</label>
                            <textarea
                                class="form-control form-control-sm"
                                rows="4"
                                wire:model.live="observacionesCert.{{ $item->id }}"
                            ></textarea>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary btn-sm" data-dismiss="modal">
                            Cancelar
                        </button>

                        {{-- <a
                            href="{{ route('ingreso-datos.pdf', $certificado->id) }}"
                            target="_blank"
                            class="btn btn-sm btn-primary"
                        >
                            Imprimir certificado
                        </a> --}}
                        <button
                            wire:click="imprimirCertificado({{ $item->id }})"
                            class="btn btn-sm btn-primary"
                        >
                            Imprimir certificado
                        </button>

                    </div>

                </div>
            </div>
        </div>

        <div
            class="modal fade"
            id="modal-correo-{{ $item->id }}"
            wire:ignore.self
        >
            <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">ENVIAR CERTIFICADO POR CORREO</h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">

                        <div class="row">
                            <div class="col-3">
                                <label>&nbsp;</label>
                                <select
                                    class="form-control form-control-sm"
                                    wire:model.live="certificadoSeleccionado.{{ $item->id }}"
                                >
                                    <option value="">Nuevo</option>
                                    @foreach ($item->certificados as $certificado)
                                        <option value="{{ $certificado->id }}">
                                            {{ $certificado->Nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-3">
                                <label>NUMERO DE PLANO</label>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    wire:model.live="numeroPlano.{{ $item->id }}"
                                >
                            </div>

                            <div class="col-3">
                                <label>CANTIDAD</label>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    wire:model.live="cantidad.{{ $item->id }}"
                                >
                            </div>

                            <div class="col-3">
                                <label>RESPONSABLE TECNICO</label>
                                <select
                                    class="form-control form-control-sm"
                                    wire:model.live="responsableId.{{ $item->id }}"
                                >
                                    <option value="">Seleccione</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">
                                            {{ $user->Nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mt-4">
                            <label>OBSERVACIONES</label>
                            <textarea
                                class="form-control form-control-sm"
                                rows="4"
                                wire:model.defer="observacionesCert.{{ $item->id }}"
                            ></textarea>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary btn-sm" data-dismiss="modal">
                            Cancelar
                        </button>

                        <a
                            data-toggle="modal" 
                            data-target="#modal-email-{{$item->id}}"
                            class="btn btn-sm btn-primary"
                        >
                            Enviar
                        </a>
                    </div>

                </div>
            </div>
        </div>

    <!-- .modal -->
    <div class="modal fade" id="modal-email-{{$item->id}}" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title text-bold">
                    ENVIAR POR EMAIL
                </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                <div class="row">

                    <x-simple-table2>

                        <x-slot name="thead">
                            <tr>
                                <th></th>
                                <th>EMAIL</th>
                            </tr>
                        </x-slot>
                        <x-slot name="tbody">
                            @forelse ($item->ordenTrabajo->cliente->emails as $email)
                                <tr>
                                    <td>
                                        <input type="checkbox"
                                            value="{{ $email->id }}"
                                            wire:model="emails">
                                    </td>
                                    <td>{{ $email->Email }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="2">No se encontraron resultados.</td></tr>
                            @endforelse

                        </x-slot>
                    </x-simple-table2>
                    </div>
                    </div>

                </div>

                </div>

                <div class="modal-footer justify-content-end">

                    {{-- <a class="btn btn-sidebar btn-sm bg-orange"
                    href="#"
                    onclick="
                        const certId = @this.certificadoSeleccionado[{{ $item->id }}] ?? null;

                        if (!certId) {
                            alert('Seleccioná o generá un certificado primero');
                            return false;
                        }

                        @this.incrementarCorreo({{ $item->id }}).then(() => {
                            window.location.href = url + '?' + qs.toString();
                        });

                        const ids = Array.from(
                            document.querySelectorAll(
                                '#modal-email-{{ $item->id }} input[name=&quot;emails[]&quot;]:checked'
                            )
                        ).map(e => e.value);

                        const qs = new URLSearchParams({
                            Emails: ids.join(',')
                        });

                        const url = '{{ url('ingreso-datos') }}/' + certId + '/email';

                        window.location.href = url + '?' + qs.toString();
                    ">
                        <span class="text-white">Aceptar</span>
                        <i class="fas fa-check fa-fw text-white ml-2"></i>
                    </a> --}}

                    <button
                        wire:click="enviarCertificadoPorCorreo({{ $item->id }})"
                        class="btn btn-sidebar btn-sm bg-orange"
                    >
                        <span class="text-white">Aceptar</span>
                        <i class="fas fa-check fa-fw text-white ml-2"></i>
                    </button>

                    <button class="btn btn-sidebar btn-sm bg-orange" data-dismiss="modal">
                        <span class="text-white">Cerrar</span>
                        <i class="fas fa-xmark fa-fw text-white ml-2"></i>
                    </button>

                </div>
                </div>
                </div>

    </div>
    <!-- /.modal -->

    @endforeach

    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('abrirPdf', (event) => {
                window.open(event.url, '_blank');
            });
        });
    </script>

    <script>
        function abrirModal(id) {
            const modal = document.getElementById(id);
            if (!modal) return;

            if (typeof $ !== 'undefined') {
                $('#' + id).modal('show');
            } else {
                const m = new bootstrap.Modal(modal);
                m.show();
            }
        }
    </script>

    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('modal-confirmacion', () => {
                const modal = new bootstrap.Modal(
                    document.getElementById('modal-confirmacion')
                );

                modal.show();
            });
        });

        document.addEventListener('livewire:init', () => {
            Livewire.on('refresh-manual', () => {

                setTimeout(() => {
                    document.querySelectorAll('.expandable-body').forEach(el => {
                        el.style.display = 'none';
                    });

                    Livewire.dispatch('$refresh');
                }, 50);

            });
        });

        document.addEventListener('livewire:init', () => {
            Livewire.on('sync-expand', () => {

                setTimeout(() => {

                    const rows = document.querySelectorAll('[data-widget="expandable-table"]');

                    rows.forEach(row => {
                        const isExpanded = row.getAttribute('aria-expanded') === 'true';
                        const body = row.nextElementSibling;

                        if (!isExpanded && body) {
                            body.style.display = 'none';
                        }

                        if (isExpanded && body) {
                            body.style.display = 'table-row';
                        }
                    });

                }, 50);
            });
        });

        document.addEventListener('livewire:init', () => {
            Livewire.on('error-modal', () => {
                const modal = new bootstrap.Modal(
                    document.getElementById('error-modal')
                );

                modal.show();
            });
        });
    </script>

    </x-layout2-sidebar>
    
</div>
</div>