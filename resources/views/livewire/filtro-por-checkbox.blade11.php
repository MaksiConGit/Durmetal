<div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Tratamientos</div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="d-flex flex-wrap gap-2">
                        @forelse ($tratamientos as $tratamiento)
                            <x-form-input-checkbox-livewire>
                                <x-slot name="label">{{$tratamiento->Nombre}}</x-slot>
                                <x-slot name="name"></x-slot>
                                <x-slot name="value">{{ $tratamiento->id }}</x-slot>
                                <x-slot name="color">black</x-slot>
                                <x-slot name="checked"></x-slot>
                                <x-slot name="livewire">wire:model.live="selectedIds"</x-slot>
                            </x-form-input-checkbox-livewire>
                        @empty
                            <tr><td colspan="11">No se encontraron tratamientos.</td></tr>
                        @endforelse
                    </div>
                    {{-- <div class="d-flex flex-wrap gap-2">

                    </div> --}}
                </div>
            </div>
        </div>
    </div>

    <x-form>
        <x-slot name="card_title">Órden de Trabajo</x-slot>
        <x-slot name="action">{{ route('programacion.create', $selectedItemIds) }}</x-slot>
        <x-slot name="method"></x-slot>
        <x-slot name="inputs">

            <x-data-table-no-plus-acordion>
                <x-slot name="table_title">Items Órden de Trabajo</x-slot>
                <x-slot name="export_route">{{ route('programacion.export') }}</x-slot>
                <x-slot name="add_text">Añadir Item</x-slot>

                <x-slot name="head_tr">
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th>Descripción</th>
                        <th>Razón Social</th>
                        <th>Fecha</th>
                        <th>OTI</th>
                        <th>Cant.</th>
                        <th>Peso</th>
                        <th>Trat.</th>
                        <th>Material</th>
                        <th>Dureza</th>
                        <th>DSMIN - DSMAX</th>
                    </tr>
                </x-slot>

                <x-slot name="body_tr">
                    @forelse ($this->items as $index => $item_orden_trabajo)
                        <tr>
                            <td>
                                <button class="btn btn-sm btn-link accordion-button collapsed p-0" type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#collapseFila{{ $index }}"
                                    aria-expanded="false"
                                    aria-controls="collapseFila{{ $index }}">
                                    asd
                                </button>
                            </td>
                            <td>0</td>
                            <td>
                                <label for="">
                                    <input type="checkbox" name="" id="" wire:model.live="selectedItemIds" value="{{ $item_orden_trabajo->id }}">
                                    {{ in_array($item_orden_trabajo->id, $selectedItemIds) }}
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
                        
                       <tr class="accordion-row">
                            <td colspan="4" class="p-0 border-0">
                                <div id="collapseFila{{ $index }}" class="accordion-collapse collapse" data-bs-parent="#accordionTabla">
                                    <div class="accordion-body">
                                        <table class="table table-sm table-striped mb-0">
                                            <thead>
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
                                            </thead>
                                            <tbody>
                                                @foreach ($item_orden_trabajo->programacion as $programacion)
                                                    <tr>
                                                        <td>H{{ $programacion->NumeroHorno }} | {{ $programacion->tipoProgramacion->Nombre }}</td>
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
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </td>
                        </tr>

                    @empty
                        <tr><td colspan="12">No se encontraron resultados.</td></tr>
                    @endforelse
                </x-slot>

                <x-slot name="foot_tr">
                    <tr>
                        <th></th>
                        <th></th>
                        <th>Descripción</th>
                        <th>Razón Social</th>
                        <th>Fecha</th>
                        <th>OTI</th>
                        <th>Cant.</th>
                        <th>Peso</th>
                        <th>Trat.</th>
                        <th>Material</th>
                        <th>Dureza</th>
                        <th>DSMIN - DSMAX</th>
                    </tr>
                </x-slot>
            </x-data-table-no-plus-acordion>
        </x-slot>
        <x-slot name="buttons">
            <a href="{{ route('programacion.create', ['items' => implode(',', $selectedItemIds)]) }}" class="btn btn-success">
                Programar
            </a>

            <x-button>
                <x-slot name="text">Cancelar</x-slot>
                <x-slot name="color">danger</x-slot>
                <x-slot name="href">{{ route('index') }}</x-slot>
            </x-button>
        </x-slot>
    </x-form>

    {{-- <script>
    document.addEventListener('DOMContentLoaded', function () {
        const accordions = document.querySelectorAll('.accordion-collapse');

        accordions.forEach(ac => {
            ac.addEventListener('show.bs.collapse', function () {
                ac.closest('tr').style.display = 'table-row';
            });

            ac.addEventListener('hide.bs.collapse', function () {
                ac.closest('tr').style.display = 'none';
            });

            // Ocultar todos los accordion-row al iniciar
            ac.closest('tr').style.display = 'none';
        });
    });
</script> --}}

</div>