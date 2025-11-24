<div>
    <x-layout2-sidebar-x>

        <x-slot name="title">Valorizar trabajos</x-slot>
        <x-slot name="title_button">
            <div class="card-header bg-dark position-relative">
                <h3 class="card-title mb-0">Valorizar trabajos</h3>

                <a href="{{ route('ventas.buscar-documentos') }}"
                    class="win7-close-btn position-absolute"
                    style="right: 10px; top: 50%; transform: translateY(-50%);">
                    ✕
                </a>

                <style>
                    .win7-close-btn {
                    width: 28px;
                    height: 28px;
                    border-radius: 50%;
                    border: 1px solid #b30000;
                    background: linear-gradient(to bottom, #ff5c5c, #b30000);
                    color: white;
                    font-weight: bold;
                    font-size: 15px;
                    line-height: 1;
                    padding: 0;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    box-shadow: inset 0 0 3px rgba(255,255,255,0.7),
                                0 0 3px rgba(0,0,0,0.4);
                    cursor: pointer;
                    }

                    .win7-close-btn:hover {
                        background: linear-gradient(to bottom, #ff7b7b, #cc0000);
                    }

                    .win7-close-btn:active {
                        background: linear-gradient(to bottom, #cc0000, #7a0000);
                        box-shadow: inset 0 0 4px rgba(0,0,0,0.6);
                    }
                </style>
            </div>
        </x-slot>

        <x-slot name="filtros">

            <div class="form-inline mt-5">

                <div class="form-group w-100 mb-3">

                    <label for="sidebarSearch" class="form-label text-muted small">
                        CODIGO CLIENTE
                    </label>

                    <div class="input-group">
                        <input id="sidebarSearch" 
                            class="form-control form-control-sm bg-white text-dark" 
                            type="search" placeholder="0" wire:model.live="cliente_id">
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

            </div>

        </x-slot>

        <x-data-table-acordion3>
            <x-slot name="thead">
                <tr>
                    <th></th>
                    <th>CC</th>
                    <th>CANT.</th>
                    <th>PESO</th>
                    <th>FECHA</th>
                    <th>RAZON SOCIAL</th>
                    <th>TRAT.</th>
                    <th>MATERIAL</th>
                    <th>DESCRIPCION</th>
                    <th>DUREZA</th>
                    <th>DSMIN - DSMAX</th>
                    <th>OTI</th>
                    <th>ESTADO</th>
                </tr>
            </x-slot>
            <x-slot name="tbody">

                @foreach ($this->items as $index => $item_orden_trabajo)

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
                            <input type="text" 
                                style="width: 2rem"
                                class="text-center"
                                maxlength="2"
                                id="cc-{{ $index }}"
                                wire:model.lazy="codigoComplejidad.{{ $item_orden_trabajo->id }}"
                                wire:keydown.enter="focusNext({{ $index }})"
                                onclick="event.stopPropagation();">
                        </td>

                        <td>{{ $item_orden_trabajo->Cantidad }}</td>
                        <td>{{ $item_orden_trabajo->Peso }}</td>
                        <td>{{ \Carbon\Carbon::parse($item_orden_trabajo->ordenTrabajo->FechaEmision)->format('j/n/Y') }}</td>
                        <td>[{{ $item_orden_trabajo->ordenTrabajo->cliente->id ?? 'Sin ID' }}] {{ $item_orden_trabajo->ordenTrabajo->cliente->Nombre ?? 'Sin razón social' }}</td>
                        <td>{{ $item_orden_trabajo->tratamiento->Nombre }}</td>
                        <td>{{ $item_orden_trabajo->material->Nombre }}</td>
                        <td>{{ $item_orden_trabajo->Descripcion }}</td>
                        <td>{{ $item_orden_trabajo->dureza->Nombre }}</td>
                        <td>
                            <span class="bg-info px-1">
                                {{ $item_orden_trabajo->DurezaSolicitadaMinima }} - {{ $item_orden_trabajo->DurezaSolicitadaMaxima }}
                            </span>
                        </td>
                        <td>
                            <span class="bg-secondary px-1">
                                {{ $item_orden_trabajo->ordenTrabajo->NumeroCompleto }} {{ $item_orden_trabajo->ItemNumero }}
                            </span>
                        </td>
            
                        <td>{{ $item_orden_trabajo->Estado }}</td>
                    </tr>

                    <tr class="expandable-body" style="display: {{ in_array($item_orden_trabajo->id, $expanded) ? 'table-row' : 'none' }};">

                        <td colspan="15">
                            <div class="p-0">
                            <table class="table table-sm table-bordered mb-0">
                                <thead>
                                <tr>
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
                                        $contadorPorTipo = [];
                                    @endphp

                                    @forelse ($programacionesAgrupadas as $numeroProgramacion => $grupo)

                                        @php
                                            $primeraProgramacion = $grupo->first();
                                            $tipoNombre = $primeraProgramacion->tipoProgramacion->Nombre;

                                            if (!isset($contadorPorTipo[$tipoNombre])) {
                                                $contadorPorTipo[$tipoNombre] = 1;
                                            } else {
                                                $contadorPorTipo[$tipoNombre]++;
                                            }

                                            $numeroTipo = $contadorPorTipo[$tipoNombre];

                                            $countGrupo = $grupo->count();
                                        @endphp
                                                
                                        @foreach ($grupo as $index => $programacion)
                                            <tr>
                                                <td>
                                                    <span class="bg-danger px-1">H{{ $programacion->NumeroHorno }}</span> 
                                                    @if ($countGrupo > 1)
                                                        <span class="bg-primary px-1">{{ $programacion->tipoProgramacion->Nombre }} {{ $numeroTipo }}-{{ $index + 1 }}</span>
                                                    @else
                                                        <span class="bg-primary px-1">{{ $programacion->tipoProgramacion->Nombre }} {{ $numeroTipo }}</span>
                                                    @endif
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
                        <td>&nbsp;</td>
                    </tr>
                @endfor

            </x-slot>
        </x-data-table-acordion3>

    </x-layout2-sidebar-x>

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
        $(function() {
            var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
            });

            $('.swalDefaultSuccess').click(function() {
            Toast.fire({
                icon: 'success',
                title: 'Trabajo actualizado'
            })
            });
        });
    </script>

    <script>
        document.addEventListener('trabajo-actualizado', function () {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: 'Trabajo actualizado',
                showConfirmButton: false,
                timer: 3000
            });
        });
    </script>

    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('focus-cc', ({ index }) => {
                const input = document.getElementById('cc-' + index);
                if (input) {
                    input.focus();
                    input.select();
                }
            });
        });
    </script>

</div>