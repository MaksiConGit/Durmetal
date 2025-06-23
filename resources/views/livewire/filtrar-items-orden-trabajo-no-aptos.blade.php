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
                                <x-slot name="color">black</x-slot>
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
                    <td>{{ $item->ItemNumero }} / {{ $item->ordenTrabajo->Numero }}</td>
                    <td>{{ number_format($item->Cantidad, 2, '.', '') }}</td>
                    <td>{{ number_format($item->Peso, 2, '.', '') }}</td>
                    <td>{{ $item->tratamiento->Nombre }}</td>
                    <td>{{ $item->material->Nombre }}</td>
                    <td>{{ $item->dureza->Nombre }}</td>
                    <td>{{ $item->DurezaSolicitadaMinima }} - {{ $item->DurezaSolicitadaMaxima }}</td>
                </tr>

                <tr class="expandable-body" data-for="{{ $item->id }}" style="display: none;">

                    <td colspan="12">

                        <x-card-no-buttons>

                            <x-slot name="body">

                                <x-data-table-no-plus-no-export>

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

                                        @foreach ($item->programacion->where('Apto', '<>', 'SI') as $prog)
                                            <tr class="border-t text-center">
                                                <td>H{{ $prog->NumeroHorno }} | {{ $prog->tipoProgramacion->Nombre ?? '-' }}</td>
                                                <td>{{ $prog->Reproceso == 0 ? 'SÍ' : ''  }}</td>
                                                <td>{{ number_format($prog->Cantidad, 2, '.', '') }}</td>
                                                <td>{{ $prog->Apto }}</td>
                                                <td>{{ $prog->FechaCarga }}</td>
                                                <td>{{ $prog->FechaDescarga }}</td>
                                                <td>{{ $prog->ejecutadoPorOperador->name }}</td>
                                                <td>{{ $prog->Temperatura }}</td>
                                                <td>{{ $prog->medioEnfriamiento->Nombre ?? '-' }}</td>
                                                <td>{{ $prog->DurezaMinima }}</td>
                                                <td>{{ $prog->DurezaMaxima }}</td>
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
                                </x-data-table-no-plus-no-export>
                            </x-slot>

                        </x-card-no-buttons>

                        {{-- <td colspan="8" class="p-0">
                            <table class="w-full text-xs bg-white border-t">
                                <thead class="bg-gray-200">
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
                                    @foreach ($item->programacion->where('Apto', '<>', 'SI') as $prog)
                                        <tr class="border-t text-center">
                                            <td>{{ $prog->tipoProgramacion->Nombre ?? '-' }}</td>
                                            <td>{{ $prog->Reproceso == 0 ? 'SÍ' : ''  }}</td>
                                            <td>{{ number_format($prog->Cantidad, 2, '.', '') }}</td>
                                            <td>{{ $prog->Apto }}</td>
                                            <td>{{ $prog->FechaCarga }}</td>
                                            <td>{{ $prog->FechaDescarga }}</td>
                                            <td>{{ $prog->ejecutadoPorOperador->name }}</td>
                                            <td>{{ $prog->Temperatura }}</td>
                                            <td>{{ $prog->medioEnfriamiento->Nombre ?? '-' }}</td>
                                            <td>{{ $prog->DurezaMinima }}</td>
                                            <td>{{ $prog->DurezaMaxima }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </td> --}}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center py-2">No se encontraron resultados.</td>
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
        });
  </script>

</div>