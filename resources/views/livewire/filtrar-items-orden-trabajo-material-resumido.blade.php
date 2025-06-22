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
                    <div class="col-md-4">

                        {{-- @php
                            $message = $errors->first('IdCliente') 
                                ?: (old('IdCliente') ? 'Todo correcto' : null);

                            $error = $errors->has('IdCliente')
                                ? 'is-invalid'
                                : (old('IdCliente') ? 'is-valid' : null);
                            $selectedUser = null;
                        @endphp

                        @include('components.form-input-select2', [
                        'name' => 'IdCliente',
                        'label' => 'Cliente',
                        'route' => route('clientes.buscar'),
                        'placeholder' => 'Selecciona un cliente',
                        'selected' => $clienteSeleccionado ?? null,
                        'message' => $message,
                        'error' => $error,
                        ]) --}}


                        <x-form-input-select-livewire>
                            <x-slot name="label">Cod. Cliente</x-slot>
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
                    
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-2">
                    <x-form-input-default-livewire>
                        <x-slot name="label">DSMIN</x-slot>
                        <x-slot name="livewire">wire:model.live="dureza_min"</x-slot>
                        <x-slot name="name"></x-slot>
                        <x-slot name="placeholder">0</x-slot>
                        <x-slot name="value"></x-slot>
                        <x-slot name="message"></x-slot>
                        <x-slot name="error"></x-slot>
                    </x-form-input-default-livewire>
                </div>
                
                <div class="col-md-2">
                    <x-form-input-default-livewire>
                        <x-slot name="label">DSMAX</x-slot>
                        <x-slot name="livewire">wire:model.live="dureza_max"</x-slot>
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
                    <label class="mr-2">Materiales</label>
                    <div class="d-flex justify-content-start flex-wrap gap-2 rounded p-2" style="max-height: 200px; overflow-y: auto;">
                        @forelse ($materiales as $material)

                            <x-form-input-checkbox-livewire>
                                <x-slot name="label">{{$material->Nombre}}</x-slot>
                                <x-slot name="name">{{$material->id}}</x-slot>
                                <x-slot name="value">{{ $material->id }}</x-slot>
                                <x-slot name="color">black</x-slot>
                                <x-slot name="checked"></x-slot>
                                <x-slot name="livewire">wire:model.live="materiales_seleccionados"</x-slot>
                            </x-form-input-checkbox-livewire>

                        @empty

                            <tr><td colspan="11">No se encontraron tratamientos.</td></tr>
                            
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

    </div>

    <x-data-table-no-plus>
      
        <x-slot name="table_title">Items Órden Trabajo</x-slot>
        <x-slot name="export_route">{{ route('clients.export') }}</x-slot>
        <x-slot name="head_tr">
            <tr>
                <th>Fecha</th>
                <th>Cli.</th>
                <th>OTI</th>
                <th>Cant.</th>
                <th>Peso</th>
                <th>Trat.</th>
                <th>Material</th>
                <th>Descripción</th>
                <th>Dureza</th>
                <th>DSMIN-DSMAX</th>
            </tr>
        </x-slot>
        <x-slot name="body_tr">
            @forelse ($items_orden_trabajo as $item_orden_trabajo)
                <tr class="border-t">
                    <td>{{ $item_orden_trabajo->FechaCreacion }}</td>
                    <td>{{ $item_orden_trabajo->ordenTrabajo->cliente->id }}</td>
                    <td>{{ $item_orden_trabajo->ordenTrabajo->NumeroCompleto }}</td>
                    <td>{{ number_format($item_orden_trabajo->Cantidad, 2, '.', '') }}</td>
                    <td>{{ number_format($item_orden_trabajo->Peso, 2, '.', '') }}</td>
                    <td>{{ $item_orden_trabajo->tratamiento->Nombre }}</td>
                    <td>{{ $item_orden_trabajo->material->Nombre }}</td>
                    <td>{{ $item_orden_trabajo->Descripcion }}</td>
                    <td>{{ $item_orden_trabajo->dureza->Nombre }}</td>
                    <td>{{ $item_orden_trabajo->DurezaSolicitadaMinima}}-{{$item_orden_trabajo->DurezaSolicitadaMaxima }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="14" class="text-center py-2">No se encontraron resultados.</td>
                </tr>
            @endforelse
        </x-slot>
        <x-slot name="foot_tr">
            <tr>
                <th>Fecha</th>
                <th>Cli.</th>
                <th>OTI</th>
                <th>Cant.</th>
                <th>Peso</th>
                <th>Trat.</th>
                <th>Material</th>
                <th>Descripción</th>
                <th>Dureza</th>
                <th>DSMIN-DSMAX</th>

            </tr>
        </x-slot>

    </x-data-table-no-plus>

</div>