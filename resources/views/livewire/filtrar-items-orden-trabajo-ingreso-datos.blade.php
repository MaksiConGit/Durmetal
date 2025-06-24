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
                                    {{-- href="{{ route('programacion.print', $programacion->id) }}" --}}
                                    class="btn btn-link btn-secondary p-0"
                                    data-bs-toggle="tooltip"
                                    title="Imprimir programación"
                                >
                                    <i class="fa fa-print fa-lg"></i>
                                </a>
                                <a
                                    {{-- href="{{ route('programacion.sendEmail', $programacion->id) }}" --}}
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



</div>
