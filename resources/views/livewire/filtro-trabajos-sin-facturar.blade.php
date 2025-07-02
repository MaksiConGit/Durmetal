<div>
    <div class="card">
        <div class="card-header">
            <div class="card-title">Filtros</div>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-2">
                    <x-form-input-default-livewire>
                        <x-slot name="label">Cliente Desde</x-slot>
                        <x-slot name="livewire">wire:model.live="cliente_desde"</x-slot>
                        <x-slot name="name"></x-slot>
                        <x-slot name="placeholder"></x-slot>
                        <x-slot name="value"></x-slot>
                        <x-slot name="message"></x-slot>
                        <x-slot name="error"></x-slot>
                    </x-form-input-default-livewire>
                </div>
                
                <div class="col-md-2">
                    <x-form-input-default-livewire>
                        <x-slot name="label">Cliente Hasta</x-slot>
                        <x-slot name="livewire">wire:model.live="cliente_hasta"</x-slot>
                        <x-slot name="name"></x-slot>
                        <x-slot name="placeholder"></x-slot>
                        <x-slot name="value"></x-slot>
                        <x-slot name="message"></x-slot>
                        <x-slot name="error"></x-slot>
                    </x-form-input-default-livewire>
                </div>
            </div>
        </div>

    </div>

    <x-card>
        <x-slot name="card_title">Órden de Trabajo</x-slot>
        <x-slot name="body">

            <x-data-table-acordion-no-plus>
                <x-slot name="table_title">Items Órden de Trabajo</x-slot>
                <x-slot name="export_route">{{ route('programacion.export') }}</x-slot>
                <x-slot name="add_text">Añadir Item</x-slot>

                <x-slot name="head_tr">
                    <tr>
                        <th></th>
                        <th>Cliente</th>
                        <th>Fecha</th>
                        <th>Descripción</th>
                        <th>OTI</th>
                        <th>Cant.</th>
                        <th>Peso</th>
                        <th>Trat.</th>
                        <th>Material</th>
                        <th>Dureza</th>
                        <th>DSMIN</th>
                        <th>DSMAX</th>
                        <th>CC</th>
                        <th>Total</th>
                        <th>Estado</th>
                    </tr>
                </x-slot>

                <x-slot name="body_tr">

                    @forelse ($items_orden_trabajo as $index => $item_orden_trabajo)
                        <tr class="border-t bg-gray-50 toggle-expand" data-id="{{ $item_orden_trabajo->id }}" style="cursor:pointer;" aria-expanded="false">
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
                            <td>{{ $item_orden_trabajo->ordenTrabajo->FechaEmision }}</td>
                            <td>{{ $item_orden_trabajo->Descripcion }}</td>
                            <td>{{ $item_orden_trabajo->ordenTrabajo->Numero }}/{{ $item_orden_trabajo->ItemNumero }}</td>
                            <td>{{ $item_orden_trabajo->Cantidad }}</td>
                            <td>{{ $item_orden_trabajo->Peso }}</td>
                            <td>{{ $item_orden_trabajo->tratamiento->Nombre }}</td>
                            <td>{{ $item_orden_trabajo->material->Nombre }}</td>
                            <td>{{ $item_orden_trabajo->dureza->Nombre }}</td>
                            <td>{{ $item_orden_trabajo->DurezaSolicitadaMinima }}</td>
                            <td>{{ $item_orden_trabajo->DurezaSolicitadaMaxima }}</td>
                            <td>{{ $item_orden_trabajo->CodigoComplejidad }}</td>
                            <td>{{ $item_orden_trabajo->Total }}</td>
                            <td>{{ $item_orden_trabajo->Estado }}</td>
                        </tr>

                        <tr class="expandable-body" data-for="{{ $item_orden_trabajo->id }}" style="display: none;">

                            <td colspan="12">

                                <x-card-no-buttons>

                                    <x-slot name="body">

                                        <x-data-table-no-plus-no-export>
                                            <x-slot name="table_title">Programación</x-slot>
                                            <x-slot name="export_route">{{ route('programacion.export') }}</x-slot>
                                            <x-slot name="add_text">Añadir Item</x-slot>

                                            <x-slot name="head_tr">
                                                <tr>
                                                    <th>Opciones</th>
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
                                                @php
                                                    $programacionesAgrupadas = $item_orden_trabajo->programacion->groupBy('NumeroProgramacion');
                                                @endphp

                                                @forelse ($programacionesAgrupadas as $numeroProgramacion => $grupo)
                                                    @foreach ($grupo as $index => $programacion)
                                                        <tr>
                                                            <td class="text-start align-middle">
                                                                <div class="d-flex justify-content-start align-items-center gap-3 ms-2">
                                                                    <a
                                                                        href="{{ route('programacion.edit', $programacion->id) }}"
                                                                        class="btn btn-link btn-primary p-0"
                                                                        data-bs-toggle="tooltip"
                                                                        title="Editar programación"
                                                                    >
                                                                        <i class="fa fa-edit fa-lg"></i>
                                                                    </a>
                                                                    <button 
                                                                        type="button"
                                                                        class="btn btn-link btn-danger p-0"
                                                                        data-bs-toggle="tooltip"
                                                                        title="Eliminar programación"
                                                                        onclick="confirmDelete({{ $programacion->id }})"
                                                                    >
                                                                        <i class="fa fa-times fa-lg"></i>
                                                                    </button>
                                                                </div>
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
                                                    <tr><td colspan="12">No se encontraron resultados.</td></tr>
                                                @endforelse
                                            </x-slot>

                                            <x-slot name="foot_tr">
                                                <tr>
                                                    <th>Opciones</th>
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
                                        </x-data-table-no-plus-no-export>
                                    </x-slot>
                                </x-card-no-buttons>
                            </td>
                        </tr>

                    @empty
                        <tr><td colspan="12">No se encontraron resultados.</td></tr>
                    @endforelse
                </x-slot>

                <x-slot name="foot_tr">
                    <tr>
                        <th></th>
                        <th>Cliente</th>
                        <th>Fecha</th>
                        <th>Descripción</th>
                        <th>OTI</th>
                        <th>Cant.</th>
                        <th>Peso</th>
                        <th>Trat.</th>
                        <th>Material</th>
                        <th>Dureza</th>
                        <th>DSMIN</th>
                        <th>DSMAX</th>
                        <th>CC</th>
                        <th>Total</th>
                        <th>Estado</th>
                    </tr>
                </x-slot>
            </x-data-table-acordion-no-plus>
            
        </x-slot>
        <x-slot name="buttons">
            <div class="d-flex justify-content-end gap-2">
                <x-button>
                    <x-slot name="text">Cancelar</x-slot>
                    <x-slot name="color">danger</x-slot>
                    <x-slot name="href">{{ route('index') }}</x-slot>
                </x-button>
            </div>
        </x-slot>
    </x-card>

    <form id="delete-form" method="POST" style="display:none;">
        @csrf
        @method('DELETE')
    </form>

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
        });
  </script>

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