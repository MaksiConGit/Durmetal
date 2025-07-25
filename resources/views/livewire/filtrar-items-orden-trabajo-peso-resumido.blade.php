<div>

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
                <div class="col-md-2">
                    <x-form-input-default-livewire>
                        <x-slot name="label">CC Desde</x-slot>
                        <x-slot name="livewire">wire:model.live="cc_min"</x-slot>
                        <x-slot name="name"></x-slot>
                        <x-slot name="placeholder">0</x-slot>
                        <x-slot name="value"></x-slot>
                        <x-slot name="message"></x-slot>
                        <x-slot name="error"></x-slot>
                    </x-form-input-default-livewire>
                </div>
                
                <div class="col-md-2">
                    <x-form-input-default-livewire>
                        <x-slot name="label">Hasta</x-slot>
                        <x-slot name="livewire">wire:model.live="cc_max"</x-slot>
                        <x-slot name="name"></x-slot>
                        <x-slot name="placeholder">0</x-slot>
                        <x-slot name="value"></x-slot>
                        <x-slot name="message"></x-slot>
                        <x-slot name="error"></x-slot>
                    </x-form-input-default-livewire>
                </div>
            </div>
        </div>


        <div class="card-body">
            <div class="row">
                <div class="col-md-10">
                    <label class="mr-2">Tratamientos</label>
                    <div class="d-flex justify-content-start flex-wrap gap-2 rounded p-2" style="max-height: 200px; overflow-y: auto;">
                        @forelse ($tratamientos as $tratamiento)

                            <x-form-input-checkbox-livewire>
                                <x-slot name="label">{{$tratamiento->Nombre}}</x-slot>
                                <x-slot name="name">{{$tratamiento->id}}</x-slot>
                                <x-slot name="value">{{ $tratamiento->id }}</x-slot>
                                <x-slot name="color">primary</x-slot>
                                <x-slot name="checked"></x-slot>
                                <x-slot name="livewire">wire:model.live="tratamientos_seleccionados"</x-slot>
                            </x-form-input-checkbox-livewire>

                        @empty

                            <tr><td colspan="11">No se encontraron tratamientos.</td></tr>
                            
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

    </div>

    <x-data-table-no-plus-buttons>
      
        <x-slot name="table_title">Items Órden Trabajo</x-slot>
        <x-slot name="export_route">{{ route('clients.export') }}</x-slot>
        <x-slot name="head_tr">
            <tr>
                <th>Tratamiento</th>
                <th>CC</th>
                <th>Total</th>
            </tr>
        </x-slot>
        <x-slot name="body_tr">
            @php $total_acumulado = 0; @endphp
            @forelse ($items_orden_trabajo as $item_orden_trabajo)
                @php $total_acumulado += $item_orden_trabajo->Peso; @endphp
                <tr class="border-t">
                    <td>{{ $item_orden_trabajo->tratamiento->Nombre }}</td>
                    <td>{{ $item_orden_trabajo->CodigoComplejidad }}</td>
                    <td>{{ number_format($total_acumulado, 2, '.', '') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="15" class="text-center py-2">No se encontraron resultados.</td>
                </tr>
            @endforelse
        </x-slot>
        <x-slot name="foot_tr">
            <tr>
                <th>Tratamiento</th>
                <th>CC</th>
                <th>Total</th>
            </tr>
        </x-slot>

        <x-slot name="buttons">
            <div class="row mb-3">
                <div class="col-md-9"></div>

                <div class="col-md-3 text-end">
                    <x-form-input-disabled>
                        <x-slot name="label">Total</x-slot>
                        <x-slot name="name"></x-slot>
                        <x-slot name="placeholder"></x-slot>
                        <x-slot name="value">{{ number_format($total_acumulado, 2, '.', '') }}</x-slot>
                        <x-slot name="message"></x-slot>
                        <x-slot name="error"></x-slot>
                    </x-form-input-disabled>
                </div>
            </div>

            <div class="row">
                <div class="col text-end">
                    <x-button>
                        <x-slot name="text">Cancelar</x-slot>
                        <x-slot name="color">danger</x-slot>
                        <x-slot name="href">{{ route('index') }}</x-slot>
                    </x-button>
                </div>
            </div>
        </x-slot>

    </x-data-table-no-plus-buttons>

</div>