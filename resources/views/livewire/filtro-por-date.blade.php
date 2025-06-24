<div>
    @php
        use App\Models\Programacion;
    @endphp

    <x-card-buttons>
        <x-slot name="title">Cargas</x-slot>
        <x-slot name="body">

            <x-data-table-no-plus>
                <x-slot name="table_title">
                    <div class="d-flex gap-3 align-items-end">
                        <x-form-input-date-livewire>
                            <x-slot name="label">Desde Fecha Carga</x-slot>
                            <x-slot name="name">FechaCarga</x-slot>
                            <x-slot name="value">{{ old('FechaCarga') }}</x-slot>
                            <x-slot name="message"></x-slot>
                            <x-slot name="error"></x-slot>
                            <x-slot name="livewire">wire:model.live="FechaCarga"</x-slot>
                        </x-form-input-date-livewire>

                        <x-form-input-date-livewire>
                            <x-slot name="label">Hasta Fecha Descarga</x-slot>
                            <x-slot name="name">FechaDescarga</x-slot>
                            <x-slot name="value">{{ old('FechaDescarga') }}</x-slot>
                            <x-slot name="message"></x-slot>
                            <x-slot name="error"></x-slot>
                            <x-slot name="livewire">wire:model.live="FechaDescarga"</x-slot>
                        </x-form-input-date-livewire>
                    </div>
                </x-slot>

                <x-slot name="export_route">{{ route('programacion.export') }}</x-slot>
                <x-slot name="add_text">Añadir Item</x-slot>

                <x-slot name="head_tr">
                    <tr>
                        <th>Fecha Carga</th>
                        <th>Fecha Descarga</th>
                        <th>N° Horno</th>
                        <th>Temperatura</th>
                        <th>ENF.</th>
                        <th>Ejec. Por</th>
                    </tr>
                </x-slot>

                <x-slot name="body_tr">
                    @forelse ($programaciones as $index => $programacion)
                        <tr class="border-t bg-gray-50 toggle-expand" data-id="{{ $programacion->id }}" style="cursor:pointer;" aria-expanded="false">
                            <td>{{ $programacion->FechaCarga }}</td>
                            <td>{{ $programacion->FechaDescarga }}</td>
                            <td>{{ $programacion->NumeroHorno }}</td>
                            <td>{{ $programacion->Temperatura }}</td>
                            <td>{{ $programacion->medioEnfriamiento->Nombre }}</td>
                            <td>{{ $programacion->ejecutadoPorOperador->name }}</td>
                        </tr>
                        <tr class="expandable-body" data-for="{{ $programacion->id }}" style="display: none;">

                            <td colspan="12">
                                
                                <x-card-no-buttons>

                                    <x-slot name="body">

                                        <x-data-table-no-plus-no-export>
                                            <x-slot name="table_title">Programaciones</x-slot>
                                            <x-slot name="export_route">{{ route('programacion.export') }}</x-slot>
                                            <x-slot name="add_text">Añadir Item</x-slot>

                                            <x-slot name="head_tr">
                                                <tr>
                                                    <th>Descripcion</th>
                                                    <th>Razón Social</th>
                                                    <th>OTI</th>
                                                    <th>Programacion</th>
                                                    <th>RP</th>
                                                    <th>Cantidad</th>
                                                    <th>Apto</th>
                                                    <th>DMIN</th>
                                                    <th>DMAX</th>
                                                </tr>
                                            </x-slot>

                                            <x-slot name="body_tr">

                                                @php
                                                    $idsArray = explode(',', $programacion->programacion_ids);

                                                    $programaciones_carga = Programacion::whereIn('id', $idsArray)
                                                        ->with(['medioEnfriamiento', 'ejecutadoPorOperador'])
                                                        ->get();
                                                @endphp

                                                @foreach ($programaciones_carga as $programacion)
                                                    <tr>
                                                        <td>{{ $programacion->itemOrdenTrabajo->Descripcion}}</td>
                                                        <td>
                                                            [{{ $programacion->itemOrdenTrabajo->ordenTrabajo->cliente->id }}]
                                                            {{$programacion->itemOrdenTrabajo->ordenTrabajo->cliente->Nombre ?? 'Sin razón social' }}
                                                        </td>
                                                        <td>{{ $programacion->itemOrdenTrabajo->ordenTrabajo->Numero }}/{{ $programacion->itemOrdenTrabajo->ItemNumero }}</td>
                                                        <td>{{ $programacion->tipoProgramacion->Nombre }}</td>
                                                        <td>{{ $programacion->Reproceso == 0 ? '' : 'RP' }}</td>
                                                        <td>{{ $programacion->Cantidad }}</td>
                                                        <td>{{ $programacion->Apto == 'SI' ? 'APTO' : ''}}</td>
                                                        <td>{{ $programacion->DurezaMinima }}</td>
                                                        <td>{{ $programacion->DurezaMaxima }}</td>
                                                    </tr>
                                                @endforeach
                                            </x-slot>

                                            <x-slot name="foot_tr">
                                                <tr>
                                                    <th>Descripcion</th>
                                                    <th>Razón Social</th>
                                                    <th>OTI</th>
                                                    <th>Programacion</th>
                                                    <th>RP</th>
                                                    <th>Cantidad</th>
                                                    <th>Apto</th>
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
                        <th>Fecha Carga</th>
                        <th>Fecha Descarga</th>
                        <th>N° Horno</th>
                        <th>Temperatura</th>
                        <th>ENF.</th>
                        <th>Ejec. Por</th>
                    </tr>
                </x-slot>
            </x-data-table-no-plus>
        </x-slot>
        <x-slot name="buttons">
            <div class="d-flex justify-content-end gap-2">
                <x-button>
                    <x-slot name="text">Volver</x-slot>
                    <x-slot name="color">danger</x-slot>
                    <x-slot name="href">{{ route('index') }}</x-slot>
                </x-button>
            </div>
        </x-slot>
    </x-card-buttons>

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

</div>