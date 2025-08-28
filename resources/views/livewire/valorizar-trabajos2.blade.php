<x-data-table-acordion2>
    <x-slot name="thead">
        <tr>
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

        @forelse ($this->items as $index => $item_orden_trabajo)

            <tr data-widget="expandable-table" 
                aria-expanded="{{ in_array($item_orden_trabajo->id, $expanded) ? 'true' : 'false' }}"
                wire:click="toggleExpand({{ $item_orden_trabajo->id }})">                @php
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
                        wire:model.lazy="codigoComplejidad.{{ $item_orden_trabajo->id }}"
                        onclick="event.stopPropagation();">
                </td>

                <td>{{ $item_orden_trabajo->Cantidad }}</td>
                <td>{{ $item_orden_trabajo->Peso }}</td>
                <td>{{ $item_orden_trabajo->ordenTrabajo->FechaEmision }}</td>
                <td>[{{ $item_orden_trabajo->ordenTrabajo->cliente->id }}] {{ $item_orden_trabajo->ordenTrabajo->cliente->Nombre ?? 'Sin razón social' }}</td>
                <td>{{ $item_orden_trabajo->tratamiento->Nombre }}</td>
                <td>{{ $item_orden_trabajo->material->Nombre }}</td>
                <td>{{ $item_orden_trabajo->Descripcion }}</td>
                <td>{{ $item_orden_trabajo->dureza->Nombre }}</td>
                <td>{{ $item_orden_trabajo->DurezaSolicitadaMinima }} - {{ $item_orden_trabajo->DurezaSolicitadaMaxima }}</td>
                <td>{{ $item_orden_trabajo->ordenTrabajo->NumeroCompleto }} {{ $item_orden_trabajo->ItemNumero }}</td>
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
                                            <a href="{{ route('programacion.destroy', $programacion->id) }}"
                                                class="btn btn-sidebar btn-sm bg-danger"
                                                data-bs-toggle="tooltip"
                                                title="Eliminar programación">
                                                <i class="fas fa-ban fa-fw text-white"></i>
                                            </a>
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
                                            H{{ $programacion->NumeroHorno }} |
                                            {{ $programacion->tipoProgramacion->Nombre }}
                                            {{ $numeroProgramacion }}-{{ $index + 1 }}
                                        </td>
                                        <td>{{ $programacion->Reproceso == 0 ? '' : 'RP' }}</td>
                                        <td>{{ $programacion->Cantidad }}</td>
                                        <td>{{ $programacion->Apto == 'SI' ? 'APTO' : 'NO APTO'}}</td>
                                        <td>{{ $programacion->FechaCarga }}</td>
                                        <td>{{ $programacion->FechaDescarga }}</td>
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

        @empty
            <tr><td colspan="12">No se encontraron resultados.</td></tr>
        @endforelse

    </x-slot>
</x-data-table-acordion2>