<div>

    <x-layout2-sidebar>

        <x-slot name="title">Ingreso de datos de producción por OT</x-slot>

        <x-slot name="filtros">

            <div class="form-inline mt-3">

                <div class="form-group w-100 mb-3">
          
                    <label for="sidebarSearch" class="form-label text-muted small">
                        DESDE FECHA
                    </label>
                    
                    <div class="input-group" data-widget="sidebar-search">
                        <input id="sidebarSearch" 
                            class="form-control form-control-sm bg-white text-dark" 
                            type="date" placeholder="0" aria-label="Search" wire:model.live="fecha_inicio">
                        <div class="input-group-append">
                        </div>
                    </div>
                    
                    </div>

                    <div class="form-group w-100 mb-3">
                    
                    <label for="sidebarSearch" class="form-label text-muted small">
                        HASTA FECHA
                    </label>
                    
                    <div class="input-group" data-widget="sidebar-search">
                        <input id="sidebarSearch" 
                            class="form-control form-control-sm bg-white text-dark" 
                            type="date" aria-label="Search" wire:model.live="fecha_fin">
                        <div class="input-group-append">
                        </div>
                    </div>
                
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

            <x-data-table-acordion3>

                <x-slot name="thead">
                    <tr>
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
                        <th>ESTADO</th>
                        <th>CERT</th>
                    </tr>   
                </x-slot>

                <x-slot name="tbody">
                    @php $total_acumulado = 0; @endphp
                    @foreach ($items_orden_trabajo as $item)

                        @php $total_acumulado += $item->Peso; @endphp

                        <tr data-widget="expandable-table" 
                            aria-expanded="{{ in_array($item->id, $expanded) ? 'true' : 'false' }}"
                            wire:click="toggleExpand({{ $item->id }})">

                            <td class="text-center align-middle">
                                <button class="btn btn-sm btn-light toggle-row" type="button">
                                    <i class="fas {{ in_array($item->id, $expanded) ? 'fa-minus' : 'fa-plus' }}"></i>
                                </button>
                            </td>
                            <td>{{ $item->Descripcion }}</td>
                            <td>[{{$item->ordenTrabajo->cliente->id ?? 'null'}}] {{ $item->ordenTrabajo->cliente->Nombre ?? 'null' }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->FechaCreacion)->format('j/n/Y') }}</td>
                            <td>{{ $item->ordenTrabajo->Numero }}/{{ $item->ItemNumero }}</td>
                            <td>{{ number_format($item->Cantidad, 2, '.', '') }}</td>
                            <td>{{ number_format($item->Peso, 2, '.', '') }}</td>
                            <td>{{ $item->tratamiento->Nombre }}</td>
                            <td>{{ $item->material->Nombre }}</td>
                            <td>{{ $item->dureza->Nombre }}</td>
                            <td>
                                <span class="bg-olive px-1">
                                    {{ $item->DurezaSolicitadaMinima }} - {{ $item->DurezaSolicitadaMaxima }}
                                </span> 
                            </td>
                            <td>{{ $item->Estado }}</td>
                            @if ($item->Estado == 'APROBADO')
                                <td class="text-start align-middle">
                                    <div class="d-flex align-items-center ms-2">
                                        <div style="margin-right:12px;">
                                            <a
                                                class="d-flex align-items-center justify-content-center"
                                                style="
                                                    width:52px;
                                                    height:26px;
                                                    background-color:#f28c00;
                                                    color:white;
                                                    text-decoration:none;
                                                    border-radius:3px;
                                                "
                                                data-toggle="modal" 
                                                data-target="#modal-certificado-{{$item->id}}"
                                                title="Imprimir programación"
                                            >
                                                <i class="fa fa-print"></i>
                                            </a>
                                        </div>

                                        <div>
                                            <a
                                                class="d-flex align-items-center justify-content-center"
                                                style="
                                                    width:52px;
                                                    height:26px;
                                                    background-color:#f28c00;
                                                    color:white;
                                                    text-decoration:none;
                                                    border-radius:3px;
                                                "
                                                {{-- data-toggle="modal"  --}}
                                                {{-- data-target="#modal-correo-{{$item->id}}" --}}
                                                title="Enviar por correo"
                                            >
                                                <i class="fa fa-envelope"></i>
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            @else
                                <td></td>
                            @endif
                        </tr>

                        <tr class="expandable-body" style="display: {{ in_array($item->id, $expanded) ? 'table-row' : 'none' }};">

                            <td colspan="15">
                                <div class="p-0">
                                    <table class="table table-sm table-bordered mb-0">
                                        <thead>
                                        <tr>
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
                                                $programacionesAgrupadas = $item->programacion->groupBy('NumeroProgramacion');
                                                $programacionesCount = $item->programacion->count();
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
                                                    <tr data-widget="expandable-table"
                                                        aria-expanded="{{ in_array($programacion->id, $expandedInner ?? []) ? 'true' : 'false' }}"
                                                        wire:click="toggleExpandInner({{ $programacion->id }})">

                                                        <td></td>
                                                        <td class="text-center align-middle">
                                                            <button class="btn btn-sm btn-light toggle-row" type="button">
                                                                <i class="fas {{ in_array($programacion->id, $expandedInner ?? []) ? 'fa-minus' : 'fa-plus' }}"></i>
                                                            </button>
                                                        </td>

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

                                                    <tr class="expandable-body"
                                                        style="display: {{ in_array($programacion->id, $expandedInner ?? []) ? 'table-row' : 'none' }};">

                                                        <td colspan="15">
                                                            <form method="POST" action="{{route('ingreso-datos.update')}}">
                                                                @csrf
                                                                @method('PUT')

                                                                <input type="hidden" name="ProgramacionIds[]" value="{{$programacion->id}}">

                                                                    <div class="row mt-3 ml-3">
                                                                        
                                                                        <div class="col-3">
                                                                            <div class="form-group mb-0">
                                                                                <label for="DurezaMinima[{{ $programacion->id }}]" class="font-weight-normal">DMIN ({{ $programacion->DurezaMinima }}/0)</label>
                                                                                <input type="number" id="DurezaMinima[{{ $programacion->id }}]" name="DurezaMinima[{{ $programacion->id }}]"
                                                                                class="form-control form-control-sm"
                                                                                value="{{ $programacion->DurezaMinima }}" wire:model.live="dureza_minima.{{ $programacion->id }}">
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-3">
                                                                            <div class="form-group mb-0">
                                                                                <label for="DurezaMaxima[{{ $programacion->id }}]" class="font-weight-normal">DMAX ({{ $programacion->DurezaMaxima }}/0)</label>
                                                                                <input type="number" id="DurezaMaxima[{{ $programacion->id }}]" name="DurezaMaxima[{{ $programacion->id }}]"
                                                                                class="form-control form-control-sm"
                                                                                value="{{ $programacion->DurezaMaxima }}" wire:model.live="dureza_maxima.{{ $programacion->id }}">
                                                                            </div>
                                                                        </div>

                                                                    </div>

                                                                    <div class="row mt-3 ml-3">

                                                                        <div class="col-2">

                                                                            @if ($programacion->tipoProgramacion->id != 1)
                                                                                <div class="custom-control custom-radio">
                                                                                    <input class="custom-control-input" 
                                                                                        type="radio"
                                                                                        name="ProcesoApto[{{ $programacion->id }}]"
                                                                                        id="{{ $programacion->id }}1"
                                                                                        value="SI"
                                                                                        {{$programacion->Apto == 'SI' ? 'checked' : ''}}
                                                                                        disabled>

                                                                                    <label for="{{ $programacion->id }}1" 
                                                                                        class="custom-control-label font-weight-normal text-secondary">
                                                                                        PROCESO APTO
                                                                                    </label>
                                                                                </div>
                                                                            @else
                                                                                <div class="custom-control custom-radio">
                                                                                    <input class="custom-control-input" type="radio"
                                                                                    name="ProcesoApto[{{ $programacion->id }}]"
                                                                                    id="{{ $programacion->id }}1"
                                                                                    value="SI" 
                                                                                    {{$programacion->Apto == 'SI' ? 'checked' : ''}}>
                                                                                    <label for="{{ $programacion->id }}1" class="custom-control-label font-weight-normal text-green">PROCESO APTO</label>
                                                                                </div>
                                                                            @endif

                                                                        </div>

                                                                        <div class="col-2">

                                                                            @if ($programacion->tipoProgramacion->id != 1)
                                                                                <div class="custom-control custom-radio">
                                                                                    <input class="custom-control-input"
                                                                                        type="radio"
                                                                                        name="ProcesoApto[{{ $programacion->id }}]"
                                                                                        id="{{ $programacion->id }}2"
                                                                                        value="NO"
                                                                                        {{$programacion->Apto == 'NO' ? 'checked' : ''}}
                                                                                        disabled>

                                                                                    <label for="{{ $programacion->id }}2"
                                                                                        class="custom-control-label font-weight-normal text-secondary">
                                                                                        PROCESO NO APTO
                                                                                    </label>
                                                                                </div>
                                                                            @else
                                                                                <div class="custom-control custom-radio">
                                                                                    <input class="custom-control-input" type="radio"
                                                                                    name="ProcesoApto[{{ $programacion->id }}]"
                                                                                    id="{{ $programacion->id }}2"
                                                                                    value="NO"
                                                                                    {{$programacion->Apto == 'NO' ? 'checked' : ''}}>
                                                                                    <label for="{{ $programacion->id }}2" class="custom-control-label font-weight-normal text-red">PROCESO NO APTO</label>
                                                                                </div>
                                                                            @endif

                                                                        </div>

                                                                    </div>

                                                                    <div class="row mt-3 ml-3">

                                                                        <div class="col-6">
                                                                            <div class="d-flex justify-content-end mt-3">

                                                                                <input type="hidden" name="accion">

                                                                                @if ($programacion->tipoProgramacion->id != 1 && $programacion->itemOrdenTrabajo->Estado != 'APROBADO')
                                                                                    <button type="button"
                                                                                            class="btn btn-sidebar btn-sm bg-green"
                                                                                            onclick="this.form.querySelector('[name=accion]').value='aprobar'; this.form.submit();">
                                                                                        <span class="text-white">APROBAR TRABAJO</span>
                                                                                    </button>
                                                                                @endif

                                                                                <button type="button"
                                                                                        class="btn btn-sidebar btn-sm bg-orange ml-4"
                                                                                        onclick="this.form.querySelector('[name=accion]').value='aceptar'; this.form.submit();">
                                                                                    <span class="text-white">Aceptar</span>
                                                                                    <i class="fas fa-check fa-fw text-white ml-2"></i>
                                                                                </button>

                                                                                <a href="{{ route('ingreso-datos.index') }}" class="btn btn-sidebar btn-sm bg-orange ml-2">
                                                                                    <span class="text-white">Cancelar</span>
                                                                                    <i class="fas fa-xmark fa-fw text-white ml-2"></i>
                                                                                </a>
                                                                            </div>
                                                                        </div>

                                                                    </div>

                                                            </form>
                                                        </td>
                                                        
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
                        $filasFaltantes = max(0, 11 - count($items_orden_trabajo));
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
                            <td>&nbsp;</td>
                        </tr>
                    @endfor

                </x-slot>

            </x-data-table-acordion3>

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

                        <x-simple-table3>

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
                        </x-simple-table3>

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
                                            {{ $user->name }}
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
                                wire:model.live="observaciones.{{ $item->id }}"
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
                                    {{-- <option value="">Nuevo</option> --}}
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
                                            {{ $user->name }}
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
                                wire:model.live="observaciones.{{ $item->id }}"
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
                                        name="emails[]"
                                        value="{{ $email->id }}"
                                        checked>
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

                    <a class="btn btn-sidebar btn-sm bg-orange"
                    href="#"
                    onclick="
                            setTimeout(() => location.reload(), 500);

                            const ids = Array.from(
                                document.querySelectorAll(
                                    '#modal-email-{{ $item->id }} input[name=&quot;emails[]&quot;]:checked'
                                )
                            ).map(e => e.value);

                            const qs = new URLSearchParams({
                                Emails: ids.join(',')
                            });

this.href = '{{ route('ingreso-datos.email', $certificadoSeleccionado[$item->id] ?? 0) }}?' + qs.toString();
                    ">
                        <span class="text-white">Aceptar</span>
                        <i class="fas fa-check fa-fw text-white ml-2"></i>
                    </a>


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
        function confirmDelete(id) {
            if (confirm('¿Estás seguro de que quieres eliminar esta programación?')) {
                const form = document.getElementById('delete-form');
                form.action = "{{ route('programacion.destroy', ':id') }}".replace(':id', id);
                form.submit();
            }
        }
    </script>

</div>


{{-- <div>

    <div class="card">
        <div class="card-header">
            <div class="card-title">Filtros</div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="d-flex flex-wrap gap-2">
                    <div class="col-md-3">

                        <x-form-input-date-livewire>
                            <x-slot name="label">Desde</x-slot>
                            <x-slot name="livewire">wire:model.live="fecha_inicio"</x-slot>
                            <x-slot name="name"></x-slot>
                            <x-slot name="value"></x-slot>
                            <x-slot name="message"></x-slot>
                            <x-slot name="error"></x-slot>
                        </x-form-input-date-livewire>

                    </div>
                    <div class="col-md-3">

                        <x-form-input-date-livewire>
                            <x-slot name="label">Hasta</x-slot>
                            <x-slot name="livewire">wire:model.live="fecha_fin"</x-slot>
                            <x-slot name="name"></x-slot>
                            <x-slot name="value">{{now()}}</x-slot>
                            <x-slot name="message"></x-slot>
                            <x-slot name="error"></x-slot>
                        </x-form-input-date-livewire>

                    </div>
                    
                </div>
            </div>
        </div>
                <div class="card-body">
            <div class="row">
                <div class="d-flex flex-wrap gap-2">

                    <div class="col-md-2">

                        <x-form-input-default-livewire>
                            <x-slot name="label">Cod. Cliente</x-slot>
                            <x-slot name="livewire">wire:model.live="cliente_id"</x-slot>
                            <x-slot name="name">cliente_id</x-slot>
                            <x-slot name="placeholder"></x-slot>
                            <x-slot name="value"></x-slot>
                            <x-slot name="message"></x-slot>
                            <x-slot name="error"></x-slot>
                        </x-form-input-default-livewire>

                    </div>

                    <div class="col-md-4">

                        <x-form-input-select-livewire>
                            <x-slot name="label">Nombre</x-slot>
                            <x-slot name="livewire">wire:model.live="cliente_id"</x-slot>
                            <x-slot name="name">cliente_id</x-slot>
                            <x-slot name="option">
                                <option value="">-- Todos los clientes --</option>
                                @foreach ($clientes as $cliente)
                                    <option value="{{ $cliente->id }}">{{ $cliente->id }} | {{ $cliente->Nombre }}</option>
                                @endforeach
                            </x-slot>
                            <x-slot name="message"></x-slot>
                            <x-slot name="error"></x-slot>
                        </x-form-input-select-livewire>
                        
                    </div>
                    
                    <div class="align-self-end">
                        <div class="form-group">
                            <a href="" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalToggle">Buscar</a>
                        </div>
                    </div>

                    <x-modal-table>
                        <x-slot name="title">Buscar Cliente</x-slot>
                        <x-slot name="body">

                            <div class="table-responsive" style="max-height: 60vh; overflow-y: auto;">

                                <x-data-table-no-plus-no-export>
        
                                    <x-slot name="table_title">Clientes</x-slot>
                                    <x-slot name="export_route">{{ route('clients.export') }}</x-slot>
                                    <x-slot name="create_route">{{ route('clients.create') }}</x-slot>
                                    <x-slot name="add_text">Añadir cliente</x-slot>
                                    <x-slot name="head_tr">
                                        <tr>
                                            <th>Código</th>
                                            <th>Nombre</th>
                                            <th>Tipo de Documento</th>
                                            <th>Número</th>
                                            <th>Domicilio</th>
                                            <th>Localidad</th>
                                            <th>Provincia</th>
                                            <th>Activo</th>
                                        </tr>
                                    </x-slot>
                                    <x-slot name="body_tr">
                                
                                        @foreach ($clientes as $client)
                                            <tr style="cursor: pointer;" wire:click="$set('cliente_id', {{ $client->id }})" data-bs-dismiss="modal">
                                                <td>{{ $client->id }}</td>
                                                <td>{{ $client->Nombre }}</td>
                                                <td>{{ $client->TipoDocumento }}</td>
                                                <td>{{ $client->Telefono }}</td>
                                                <td>{{ $client->Domicilio }}</td>
                                                <td>{{ $client->localidad->Nombre ?? 'Ciudad no asignada' }}</td>
                                                <td>{{ $client->localidad->provincia->Nombre ?? 'Provincia no asignada' }}</td>
                                                <td>
                                                    <input type="checkbox" name="" id="" disabled {{ $client->Activo == 1 ? 'checked' : '' }}>
                                                </td>
                                            </tr>
                                        @endforeach

                                    </x-slot>
                                    <x-slot name="foot_tr">
                                        <tr>
                                            <th>Código</th>
                                            <th>Nombre</th>
                                            <th>Tipo de Documento</th>
                                            <th>Número</th>
                                            <th>Domicilio</th>
                                            <th>Localidad</th>
                                            <th>Provincia</th>
                                            <th>Activo</th>
                                        </tr>
                                    </x-slot>
                                </x-data-table-no-plus-no-export>

                            </div>

                        </x-slot>
                        <x-slot name="primary_text">Aceptar</x-slot>
                        <x-slot name="secondary_text">Volver</x-slot>
                    </x-modal-table>
                
                </div>
            </div>
        </div>


        <div class="card-body">
            <div class="row">
                <div class="col-md-1">
                    <x-form-input-default-livewire>
                        <x-slot name="label">OTI</x-slot>
                        <x-slot name="livewire">wire:model.live="oti_item_numero"</x-slot>
                        <x-slot name="name"></x-slot>
                        <x-slot name="placeholder">0</x-slot>
                        <x-slot name="value"></x-slot>
                        <x-slot name="message"></x-slot>
                        <x-slot name="error"></x-slot>
                    </x-form-input-default-livewire>
                </div>
                
                <div class="col-md-2">
                    <x-form-input-default-livewire>
                        <x-slot name="label">-</x-slot>
                        <x-slot name="livewire">wire:model.live="oti_orden_numero"</x-slot>
                        <x-slot name="name"></x-slot>
                        <x-slot name="placeholder">0</x-slot>
                        <x-slot name="value"></x-slot>
                        <x-slot name="message"></x-slot>
                        <x-slot name="error"></x-slot>
                    </x-form-input-default-livewire>
                </div>
            </div>
        </div>

    </div>

    <x-data-table-acordion-no-plus>
      
        <x-slot name="table_title">Items Órden Trabajo</x-slot>
        <x-slot name="export_route">{{ route('clients.export') }}</x-slot>
        <x-slot name="head_tr">
            <tr>
                <th>Descripcion</th>
                <th>Razón Social</th>
                <th>Fecha</th>
                <th>OTI</th>
                <th>Cant.</th>
                <th>Peso</th>
                <th>Trat.</th>
                <th>Material</th>
                <th>Dureza</th>
                <th>DSMIN - DSMAX</th>
                <th>Estado</th>
                <th>Cert</th>
            </tr>
        </x-slot>
        <x-slot name="body_tr">
            @php $total_acumulado = 0; @endphp
            @forelse ($items_orden_trabajo as $item)

                @php $total_acumulado += $item->Peso; @endphp
                <tr class="border-t bg-gray-50 toggle-expand" data-id="{{ $item->id }}" style="cursor:pointer;" aria-expanded="false">
                    <td>{{ $item->Descripcion }}</td>
                    <td>[{{$item->ordenTrabajo->cliente->id}}] {{ $item->ordenTrabajo->cliente->Nombre }}</td>
                    <td>{{ $item->FechaCreacion }}</td>
                    <td>{{ $item->ordenTrabajo->Numero }}/{{ $item->ItemNumero }}</td>
                    <td>{{ number_format($item->Cantidad, 2, '.', '') }}</td>
                    <td>{{ number_format($item->Peso, 2, '.', '') }}</td>
                    <td>{{ $item->tratamiento->Nombre }}</td>
                    <td>{{ $item->material->Nombre }}</td>
                    <td>{{ $item->dureza->Nombre }}</td>
                    <td>{{ $item->DurezaSolicitadaMinima }} - {{ $item->DurezaSolicitadaMaxima }}</td>
                    <td>{{ $item->Estado }}</td>
                    @if ($item->Estado == 'APROBADO')
                        <td class="text-start align-middle">
                            <div class="d-flex justify-content-start align-items-center gap-3 ms-2">
                                <a
                                    class="btn btn-link btn-secondary p-0"
                                    data-bs-toggle="tooltip"
                                    title="Imprimir programación"
                                >
                                    <i class="fa fa-print fa-lg"></i>
                                </a>
                                <a
                                    class="btn btn-link btn-info p-0"
                                    data-bs-toggle="tooltip"
                                    title="Enviar por correo"
                                >
                                    <i class="fa fa-envelope fa-lg"></i>
                                </a>
                            </div>
                        </td>
                    @endif
                </tr>

                <tr class="expandable-body" data-for="{{ $item->id }}" style="display: none;">

                    <td colspan="12">

                        <x-card-no-buttons>

                            <x-slot name="body">

                                <x-data-table-acordion-no-plus-no-export>
                                    <x-slot name="table_title">Programaciones</x-slot>
                                    <x-slot name="export_route">{{ route('clients.export') }}</x-slot>
                                    <x-slot name="head_tr">
                                        <tr>
                                            <th>Programacion</th>
                                            <th>RP</th>
                                            <th>Cantidad</th>
                                            <th>Apto</th>
                                            <th>Fecha Carga</th>
                                            <th>Fecha Descarga</th>
                                            <th>Ejec. Por</th>
                                            <th>Temperatura</th>
                                            <th>Medio Enf.</th>
                                            <th>DMIN</th>
                                            <th>DMAX</th>
                                        </tr>
                                    </x-slot>

                                    <x-slot name="body_tr">

                                        @foreach ($item->programacion as $prog)
                                            <tr class="border-t nested-toggle-expand" data-id="prog-{{ $prog->id }}" style="cursor:pointer;" aria-expanded="false">
                                                <td>H{{ $prog->NumeroHorno ?? '-' }} | {{ $prog->tipoProgramacion->Nombre ?? '-' }}</td>
                                                <td>{{ $prog->Reproceso == 1 ? 'SÍ' : ''  }}</td>
                                                <td>{{ number_format($prog->Cantidad, 2, '.', '') }}</td>
                                                <td>
                                                    @if ($prog->Apto == 'SI')
                                                        Apto
                                                    @elseif ($prog->Apto == 'NO')
                                                        No Apto
                                                    @endif
                                                </td>
                                                <td>{{ $prog->FechaCarga }}</td>
                                                <td>{{ $prog->FechaDescarga }}</td>
                                                <td>{{ $prog->ejecutadoPorOperador->name }}</td>
                                                <td>{{ $prog->Temperatura }}</td>
                                                <td>{{ $prog->medioEnfriamiento->Nombre ?? '-' }}</td>
                                                <td>{{ $prog->DurezaMinima }}</td>
                                                <td>{{ $prog->DurezaMaxima }}</td>
                                            </tr>

                                            <tr class="nested-expandable-body" data-for="prog-{{ $prog->id }}" style="display: none;">
                                                <td colspan="11">
                                                    <form method="POST" action="{{route('ingreso-datos.update')}}">
                                                        @csrf
                                                        @method('PUT')

                                                        <input type="hidden" name="ProgramacionIds[]" value="{{$prog->id}}">

                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <x-form-input-default-livewire>
                                                                    <x-slot name="label">DMIN ({{ $prog->DurezaMinima }}/0)</x-slot>
                                                                    <x-slot name="livewire">wire:model.live="dureza_minima.{{ $prog->id }}"</x-slot>
                                                                    <x-slot name="name">DurezaMinima[{{ $prog->id }}]</x-slot>
                                                                    <x-slot name="placeholder"></x-slot>
                                                                    <x-slot name="value">{{ $prog->DurezaMinima }}</x-slot>
                                                                    <x-slot name="message"></x-slot>
                                                                    <x-slot name="error"></x-slot>
                                                                </x-form-input-default-livewire>
                                                            </div>

                                                            <div class="col-md-3">
                                                                <x-form-input-default-livewire>
                                                                    <x-slot name="label">DMAX ({{ $prog->DurezaMaxima }}/0)</x-slot>
                                                                    <x-slot name="livewire">wire:model.live="dureza_maxima.{{ $prog->id }}"</x-slot>
                                                                    <x-slot name="name">DurezaMaxima[{{ $prog->id }}]</x-slot>
                                                                    <x-slot name="placeholder"></x-slot>
                                                                    <x-slot name="value">{{ $prog->DurezaMaxima }}</x-slot>
                                                                    <x-slot name="message"></x-slot>
                                                                    <x-slot name="error"></x-slot>
                                                                </x-form-input-default-livewire>
                                                            </div>

                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="ProcesoApto[{{ $prog->id }}]"
                                                                        id="{{ $prog->id }}1"
                                                                        value="SI" 
                                                                        {{$prog->Apto == 'SI' ? 'checked' : ''}} 
                                                                    />
                                                                    <label class="form-check-label" for="{{ $prog->id }}1">Proceso Apto</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="ProcesoApto[{{ $prog->id }}]"
                                                                        id="{{ $prog->id }}2"
                                                                        value="NO"
                                                                        {{$prog->Apto == 'NO' ? 'checked' : ''}} 
                                                                    />
                                                                    <label class="form-check-label" for="{{ $prog->id }}2">Proceso No Apto</label>
                                                                </div>
                                                                <div class="col-md-3 d-flex align-items-end">
                                                                    <div class="form-group checkbox-group">
                                                                        <button type="submit" class="btn btn-success">Aceptar</button>
                                                                        <x-button>
                                                                            <x-slot name="color">danger</x-slot>
                                                                            <x-slot name="href">{{route('ingreso-datos.index')}}</x-slot>
                                                                            <x-slot name="text">Cancelar</x-slot>
                                                                        </x-button>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach

                                    </x-slot>

                                    <x-slot name="foot_tr">
                                        <tr>
                                            <th>Programacion</th>
                                            <th>RP</th>
                                            <th>Cantidad</th>
                                            <th>Apto</th>
                                            <th>Fecha Carga</th>
                                            <th>Fecha Descarga</th>
                                            <th>Ejec. Por</th>
                                            <th>Temperatura</th>
                                            <th>Medio Enf.</th>
                                            <th>DMIN</th>
                                            <th>DMAX</th>
                                        </tr>
                                    </x-slot>
                                </x-data-table-acordion-no-plus-no-export>
                            </x-slot>

                        </x-card-no-buttons>

                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="12" class="text-center py-2">No se encontraron resultados.</td>
                </tr>
            @endforelse



        </x-slot>
        <x-slot name="foot_tr">
            <tr>
                <th>Descripcion</th>
                <th>Razón Social</th>
                <th>Fecha</th>
                <th>OTI</th>
                <th>Cant.</th>
                <th>Peso</th>
                <th>Trat.</th>
                <th>Material</th>
                <th>Dureza</th>
                <th>DSMIN - DSMAX</th>
                <th>Estado</th>
                <th>Cert</th>
            </tr>
        </x-slot>

    </x-data-table-acordion-no-plus>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.toggle-expand').forEach(row => {
                row.addEventListener('click', () => {
                    const currentId = row.dataset.id;
                    const expanded = row.getAttribute('aria-expanded') === 'true';

                    document.querySelectorAll('.toggle-expand').forEach(r => r.setAttribute('aria-expanded', 'false'));
                    document.querySelectorAll('.expandable-body').forEach(r => r.style.display = 'none');

                    if (!expanded) {
                        row.setAttribute('aria-expanded', 'true');
                        const target = document.querySelector(`.expandable-body[data-for="${currentId}"]`);
                        if (target) target.style.display = 'table-row';
                    }
                });
            });

            document.querySelectorAll('.nested-toggle-expand').forEach(row => {
                row.addEventListener('click', () => {
                    const currentId = row.dataset.id;
                    const expanded = row.getAttribute('aria-expanded') === 'true';
                    const target = document.querySelector(`.nested-expandable-body[data-for="${currentId}"]`);

                    if (expanded) {
                        row.setAttribute('aria-expanded', 'false');
                        if (target) target.style.display = 'none';
                    } else {
                        row.setAttribute('aria-expanded', 'true');
                        if (target) target.style.display = 'table-row';
                    }
                });
            });
        });
    </script>



</div> --}}
