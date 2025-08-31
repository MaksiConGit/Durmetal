<div>
    <x-layout2>
        <x-slot name="title">Listado de trabajos pendientes de facturar</x-slot>

        <x-data-table-acordion2>
            <x-slot name="filtros">
                <div class="row">

                    <div class="col-2">
                        <div class="form-group mb-0">
                            <label for="filtro1" class="font-weight-normal">CLIENTE DESDE</label>
                            <input type="text" id="filtro1" name="filtro1" wire:model.live="cliente_desde" class="form-control form-control-sm filtro-input" placeholder="Buscar...">
                        </div>
                    </div>

                    <div class="col-2">
                        <div class="form-group mb-0">
                            <label for="filtro2" class="font-weight-normal">CLIENTE HASTA</label>
                            <input type="text" id="filtro2" name="filtro2" wire:model.live="cliente_hasta" class="form-control form-control-sm filtro-input" placeholder="Buscar...">
                        </div>
                    </div>

                </div>
            </x-slot>

            <x-slot name="thead">
                <tr class="bg-secondary text-white">
                    <th></th>
                    <th>CLIENTE</th>
                    <th>FECHA</th>
                    <th>DESCRIPCION</th>
                    <th>OTI</th>
                    <th>CANT.</th>
                    <th>PESO</th>
                    <th>TRAT.</th>
                    <th>MATERIAL</th>
                    <th>DUREZA</th>
                    <th>DSMIN</th>
                    <th>DSMAX</th>
                    <th>CC</th>
                    <th>TOTAL</th>
                    <th>ESTADO</th>
                </tr>   
            </x-slot>

            <x-slot name="tbody">

                @foreach ($items_orden_trabajo as $index => $item_orden_trabajo)

                    <!-- Fila principal -->
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

                        <td>[{{ $item_orden_trabajo->ordenTrabajo->cliente->id }}]  {{ $item_orden_trabajo->ordenTrabajo->cliente->Nombre ?? 'Sin razón social' }}</td>
                        <td>{{ \Carbon\Carbon::parse($item_orden_trabajo->ordenTrabajo->FechaEmision)->format('j/n/Y') }}</td>
                        <td>{{ $item_orden_trabajo->Descripcion }}</td>
                        <td>{{ $item_orden_trabajo->ordenTrabajo->Numero }}/{{ $item_orden_trabajo->ItemNumero }}</td>
                        <td>{{ number_format($item_orden_trabajo->Cantidad, 2, '.', '') }}</td>
                        <td>{{ number_format($item_orden_trabajo->Peso, 2, '.', '') }}</td>
                        <td>{{ $item_orden_trabajo->tratamiento->Nombre }}</td>
                        <td>{{ $item_orden_trabajo->material->Nombre }}</td>
                        <td>{{ $item_orden_trabajo->dureza->Nombre }}</td>
                        <td>{{ $item_orden_trabajo->DurezaSolicitadaMinima }}</td>
                        <td>{{ $item_orden_trabajo->DurezaSolicitadaMaxima }}</td>
                        <td>{{ $item_orden_trabajo->CodigoComplejidad }}</td>
                        <td>{{ number_format($item_orden_trabajo->Total, 2, '.', '') }}</td>
                        <td>{{ $item_orden_trabajo->Estado }}</td>

                    </tr>

                    <!-- Subfilas -->
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
                                            <td>{{ \Carbon\Carbon::parse($programacion->FechaCarga)->format('Y-m-d H:i') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($programacion->FechaDescarga)->format('Y-m-d H:i') }}</td>
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
                    $filasFaltantes = max(0, 10 - count($items_orden_trabajo));
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
                        <td>&nbsp;</td>
                    </tr>
                @endfor

            </x-slot>
            

        </x-data-table-acordion2>

        <div class="d-flex justify-content-end mt-3">
            <button class="btn btn-app bg-primary" wire:click="buscar">
                <i class="fas fa-gear"></i> Procesar
            </button>
        </div>

    </x-layout2>
</div>
