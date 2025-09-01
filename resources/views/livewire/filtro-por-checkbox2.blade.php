<div>

    <x-layout2-sidebar>

        <x-slot name="title">Programación de la Producción</x-slot>

        <x-slot name="filtros">

            <div class="form-inline mt-3">

                <div class="form-group w-100 mb-3">

                <x-simple-table2-small>

                    <x-slot name="filtros">

                        <div class="row">
                        <div class="col-2">
                            <div class="form-group mb-0">
                                <label for="filtro1" class="font-weight-normal">TRATAMIENTOS</label>
                                <input type="text" id="filtro1" name="filtro1" class="form-control form-control-sm" placeholder="Buscar..." wire:model.live="search">
                            </div>
                        </div>
                        </div>

                    </x-slot>

                    <x-slot name="thead">
                    </x-slot>
                    <x-slot name="tbody">
                        @forelse ($tratamientos as $tratamiento)
                            <tr>
                                <td><input type="checkbox" name="{{$tratamiento->id}}" id="" wire:model.live="selectedIds" value="{{ $tratamiento->id }}"></td>
                                <td>{{ $tratamiento->Nombre }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2">No se encontraron resultados.</td>
                            </tr>
                        @endforelse
                    </x-slot>
                </x-simple-table2-small>

                </div>

                <div class="form-group w-100 mb-3">
                    
                    <label for="sidebarSearch" class="form-label text-muted small">
                        COD. CLIENTE
                    </label>
                    
                    <div class="input-group">
                        <input id="sidebarSearch" 
                            class="form-control form-control-sm bg-white text-dark" 
                            type="search" placeholder="0" aria-label="Search" wire:model.live="cliente_id">
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

                <div class="form-group w-100 mb-3">
                    
                    <div class="input-group" data-widget="sidebar-search">
                        <input id="sidebarSearch" 
                            class="form-control form-control-sm bg-white text-dark" 
                            type="search" aria-label="Search" disabled value="{{ $cliente_nombre }}">
                    </div>
                    
                </div>

                <div class="form-group w-100 mb-3">

                    <label for="sidebarSearch" class="form-label text-muted small">
                        OTI
                    </label>

                    <div class="input-group" data-widget="sidebar-search">

                        <input id="sidebarSearch" 
                            class="form-control form-control-sm bg-white text-dark" 
                            type="search" aria-label="Search" wire:model.live="oti_item_numero">

                        <div class="input-group-append ml-2">

                        <input id="sidebarSearch" 
                            class="form-control form-control-sm bg-white text-dark" 
                            type="search" aria-label="Search" wire:model.live="oti_orden_numero">

                        </div>

                    </div>
                    
                </div>

                <div class="form-group w-100 mb-3">
                    <button class="btn btn-sidebar btn-sm bg-orange w-100">
                        <span class="text-white">Buscar</span>
                        <i class="fas fa-search fa-fw text-white"></i>
                    </button>
                </div>

            </div>

        </x-slot>

            <x-data-table-acordion2>

                <x-slot name="thead">
                    <tr class="bg-secondary text-white">
                        <th></th>
                        <th></th>
                        <th>DESCRIPCION</th>
                        <th>RAZON SOCIAL</th>
                        <th>FECHA</th>
                        <th>OTI</th>
                        <th>CANT.</th>
                        <th>PESO</th>
                        <th>TRAT.</th>
                        <th>MATERIAL</th>
                        <th>DUREZA</th>
                        <th>DSMIN - DSMAX</th>
                    </tr>   
                </x-slot>

                <x-slot name="tbody">

                    @forelse ($this->items as $index => $item_orden_trabajo)

                        <tr data-widget="expandable-table" 
                            aria-expanded="{{ in_array($item_orden_trabajo->id, $expanded) ? 'true' : 'false' }}"
                            wire:click="toggleExpand({{ $item_orden_trabajo->id }})">

                            @php
                                $programaciones_filtradas = $item_orden_trabajo->programacion
                                    ->unique('NumeroProgramacion');
                            @endphp

                            <td>
                                <span class="badge bg-primary text-white px-2 py-1">
                                    {{ $programaciones_filtradas->count() }}
                                </span>
                            </td>

                            <td>
                                <label for="">
                                    <input type="checkbox" name="" id="" wire:model.live="selectedItemIds" value="{{ $item_orden_trabajo->id }}" onclick="event.stopPropagation();">
                                </label>
                            </td>
                            <td>{{ $item_orden_trabajo->Descripcion }}</td>
                            <td>{{ $item_orden_trabajo->ordenTrabajo->cliente->Nombre ?? 'Sin razón social' }}</td>
                            <td>{{ $item_orden_trabajo->FechaCreacion }}</td>
                            <td>{{ $item_orden_trabajo->ordenTrabajo->Numero }}/{{ $item_orden_trabajo->ItemNumero }}</td>
                            <td>{{ $item_orden_trabajo->Cantidad }}</td>
                            <td>{{ $item_orden_trabajo->Peso }}</td>
                            <td>{{ $item_orden_trabajo->tratamiento->Nombre }}</td>
                            <td>{{ $item_orden_trabajo->material->Nombre }}</td>
                            <td>{{ $item_orden_trabajo->dureza->Nombre }}</td>
                            <td>{{ $item_orden_trabajo->DurezaSolicitadaMinima }} - {{ $item_orden_trabajo->DurezaSolicitadaMaxima }}</td>
                        </tr>

                        <tr class="expandable-body" style="display: {{ in_array($item_orden_trabajo->id, $expanded) ? 'table-row' : 'none' }};">

                            <td colspan="15">
                                <div class="p-0">
                                    <table class="table table-sm table-bordered mb-0">
                                        <thead>
                                        <tr class="bg-dark text-white">
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th>PROGRAMACION</th>
                                            <th>RP</th>
                                            <th>CANTIDAD</th>
                                            <th>APTO</th>
                                            <th>FECHA CARGA</th>
                                            <th>FECHA DESCARGA</th>
                                            <th>EJEC. POR</th>
                                            <th>TEMPERATURA</th>
                                            <th>MEDIO ENF.</th>
                                            <th>DMIN</th>
                                            <th>DMAX</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                            @php
                                                $programacionesAgrupadas = $item_orden_trabajo->programacion->groupBy('NumeroProgramacion');
                                                $programacionesCount = $item_orden_trabajo->programacion->count();
                                            @endphp

                                            @forelse ($programacionesAgrupadas as $numeroProgramacion => $grupo)
                                                @foreach ($grupo as $index => $programacion)
                                                    <tr>
                                                        <td></td>

                                                        <td class="text-center align-middle">
                                                            <form
                                                                action="{{ route('programacion.destroy', $programacion->id) }}"
                                                                method="POST"
                                                                onsubmit="return confirm('¿Estás seguro de que quieres eliminar esta programación?')"
                                                                class="m-0 p-0"
                                                            >
                                                                @csrf
                                                                @method('DELETE')
                                                                <button
                                                                    type="submit"
                                                                    class="btn btn-sidebar btn-sm bg-danger"
                                                                    data-bs-toggle="tooltip"
                                                                    title="Eliminar programación"
                                                                >
                                                                    <i class="fas fa-ban fa-fw text-white"></i>
                                                                </button>
                                                            </form>
                                                        </td>

                                                        <td class="text-center align-middle">
                                                            <a href="{{ route('programacion.edit', $programacion->id) }}"
                                                                class="btn btn-sidebar btn-sm bg-secondary"
                                                                data-bs-toggle="tooltip"
                                                                title="Editar programación">
                                                                <i class="fas fa-pen fa-fw"></i>
                                                            </a>
                                                        </td>

                                                        <td>
                                                            <span class="bg-danger px-1">H{{ $programacion->NumeroHorno }}</span> 
                                                            <span class="bg-primary px-1">{{ $programacion->tipoProgramacion->Nombre }} {{ $numeroProgramacion }}-{{ $index + 1 }}</span>
                                                        </td>

                                                        <td>{{ $programacion->Reproceso == 0 ? '' : 'RP' }}</td>
                                                        <td>{{ number_format($programacion->Cantidad, 2, '.', '') }}</td>
                                                        <td>
                                                            <span 
                                                                class="{{ $programacion->Apto == 'SI' ? 'bg-success text-white px-1' : ($programacion->Apto == 'NO' ? 'bg-danger text-white px-1' : '') }}"
                                                                style="{{ $programacion->Apto == 'NO' ? 'text-decoration: line-through;' : '' }}">
                                                                {{ $programacion->Apto == 'SI' ? 'APTO' : ($programacion->Apto == 'NO' ? 'APTO' : '') }}
                                                            </span>
                                                        </td>
                                                        <td>{{ \Carbon\Carbon::parse($programacion->FechaCarga)->format('d/m/Y H:i') }}</td>
                                                        <td>{{ \Carbon\Carbon::parse($programacion->FechaDescarga)->format('d/m/Y H:i') }}</td>
                                                        <td>{{ $programacion->ejecutadoPorOperador->name }}</td>
                                                        <td>{{ $programacion->Temperatura }}</td>
                                                        <td>{{ $programacion->medioEnfriamiento->Nombre }}</td>
                                                        <td>{{ $programacion->DurezaMinima }}</td>
                                                        <td>{{ $programacion->DurezaMaxima }}</td>
                                                    </tr>
                                                @endforeach
                                            @empty
                                                @for ($i = 0; $i < 6; $i++)
                                                    <tr>
                                                        <td colspan="15">&nbsp;</td>
                                                    </tr>
                                                @endfor
                                            @endforelse

                                            @if ($programacionesCount > 0 && $programacionesCount < 6)
                                                @for ($i = $programacionesCount; $i < 6; $i++)
                                                    <tr>
                                                        <td colspan="15">&nbsp;</td>
                                                    </tr>
                                                @endfor
                                            @endif

                                            @if ($programacionesCount >= 6)
                                                <tr>
                                                    <td colspan="15">&nbsp;</td>
                                                </tr>
                                            @endif

                                        </tbody>
                                    </table>
                                </div>
                            </td>

                        </tr>

                    @endforeach

                    @php
                        $filasFaltantes = max(0, 11 - count($this->items));
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

            <div class="d-flex justify-content-end">
                <a href="{{ route('programacion.create', ['items' => implode(',', $selectedItemIds)]) }}" class="btn btn-app bg-primary">
                    <i class="fas fa-arrow-right"></i> Programar
                </a>
            </div>

    </x-layout2-sidebar>

    <form id="delete-form" method="POST" style="display:none;">
        @csrf
        @method('DELETE')
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

    <script>
        function confirmDelete(id) {
            if (confirm('¿Estás seguro de que quieres eliminar esta programación?')) {
                const form = document.getElementById('delete-form');
                form.action = "{{ route('programacion.destroy', ':id') }}".replace(':id', id);
                form.submit();
            }
        }
    </script>

</div>