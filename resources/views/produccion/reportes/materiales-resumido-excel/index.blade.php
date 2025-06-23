<x-layout>
    <x-slot name="title">Producción</x-slot>
    <x-slot name="breadcrumbs">
        <li class="nav-home">
            <a href="#"><i class="fas fa-cogs"></i></a>
        </li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="#">Reportes</a></li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="#">Materiales</a></li>
    </x-slot>

    @livewire('filtrar-items-orden-trabajo-material-resumido-excel')

    {{-- <div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Filtros</div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="d-flex flex-wrap gap-2">
                            <div class="col-md-3">

                                <x-form-input-date>
                                    <x-slot name="label">Desde</x-slot>
                                    <x-slot name="name"></x-slot>
                                    <x-slot name="value"></x-slot>
                                    <x-slot name="message"></x-slot>
                                    <x-slot name="error"></x-slot>
                                </x-form-input-date>

                            </div>
                            <div class="col-md-3">

                                <x-form-input-date>
                                    <x-slot name="label">Hasta</x-slot>
                                    <x-slot name="name"></x-slot>
                                    <x-slot name="value">{{now()}}</x-slot>
                                    <x-slot name="message"></x-slot>
                                    <x-slot name="error"></x-slot>
                                </x-form-input-date>

                            </div>
                            <div class="col-md-5">

                                @php
                                    $message = $errors->first('IdCliente') 
                                        ?: (old('IdCliente') ? 'Todo correcto' : null);

                                    $error = $errors->has('IdCliente')
                                        ? 'is-invalid'
                                        : (old('IdCliente') ? 'is-valid' : null);
                                @endphp

                                @include('components.form-input-select2', [
                                'name' => 'IdCliente',
                                'label' => 'Cliente',
                                'route' => route('clientes.buscar'),
                                'placeholder' => 'Selecciona un cliente',
                                'selected' => $clienteSeleccionado ?? null,
                                'message' => $message,
                                'error' => $error,
                                ])
                            </div>
                            
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2">
                            <x-form-input-default>
                                <x-slot name="label">DSMIN</x-slot>
                                <x-slot name="name"></x-slot>
                                <x-slot name="placeholder">0</x-slot>
                                <x-slot name="value"></x-slot>
                                <x-slot name="message"></x-slot>
                                <x-slot name="error"></x-slot>
                            </x-form-input-default>
                        </div>
                        
                        <div class="col-md-2">
                            <x-form-input-default>
                                <x-slot name="label">DSMAX</x-slot>
                                <x-slot name="name"></x-slot>
                                <x-slot name="placeholder">0</x-slot>
                                <x-slot name="value"></x-slot>
                                <x-slot name="message"></x-slot>
                                <x-slot name="error"></x-slot>
                            </x-form-input-default>
                        </div>
                    </div>
                </div>


                <div class="card-body">
                    <div class="row">
                        <label class="mr-2">Materiales</label>
                        <div class="d-flex flex-wrap gap-2">
                            @forelse ($materiales as $material)

                                <x-form-input-checkbox-livewire>
                                    <x-slot name="label">{{$material->Nombre}}</x-slot>
                                    <x-slot name="name"></x-slot>
                                    <x-slot name="value">{{ $material->id }}</x-slot>
                                    <x-slot name="color">black</x-slot>
                                    <x-slot name="checked"></x-slot>
                                    <x-slot name="livewire"></x-slot>
                                </x-form-input-checkbox-livewire>

                            @empty

                                <tr><td colspan="11">No se encontraron tratamientos.</td></tr>
                                
                            @endforelse
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <x-card>

            <x-slot name="body">

                <x-data-table-no-plus>
                    <x-slot name="table_title">Items Órden de Trabajo</x-slot>
                    <x-slot name="export_route">{{ route('programacion.export') }}</x-slot>
                    <x-slot name="add_text">Añadir Item</x-slot>

                    <x-slot name="head_tr">
                        <tr>
                            <th>Fecha</th>
                            <th>CLI.</th>
                            <th>Cant.</th>
                            <th>Peso</th>
                            <th>Trat.</th>
                            <th>Material</th>
                            <th>Descripción</th>
                            <th>Dureza</th>

                            @php
                                $tiene_programacion = false;
                            @endphp

                            @foreach ($items_orden_trabajo as $item_orden_trabajo)

                                @if ($item_orden_trabajo->programacion->max('NumeroProgramacion'))

                                    @php
                                        $tiene_programacion = true;
                                    @endphp

                                    @for ($i = 1; $i <= $item_orden_trabajo->programacion->max('NumeroProgramacion'); $i++)

                                        <th>Prog. {{$i}}</th>
                                        <th>T°</th>
                                        <th>Medio Enf.</th>
                                        <th>DMIN/DMAX</th>
                                        <th>DMIN</th>
                                        <th>DMAX</th>

                                    @endfor  

                                @endif

                            @endforeach

                            @if (!$tiene_programacion)
                                <th>Prog. 1</th>
                                <th>T°</th>
                                <th>Medio Enf.</th>
                                <th>DMIN/DMAX</th>
                                <th>DMIN</th>
                                <th>DMAX</th>                
                            @endif

                        </tr>
                    </x-slot>

                    <x-slot name="body_tr">
                        @forelse ($items_orden_trabajo as $index => $item_orden_trabajo)
                            <tr>
                                <td>{{ $item_orden_trabajo->FechaCreacion }}</td>
                                <td>{{ $item_orden_trabajo->ordenTrabajo->cliente->id }}</td>
                                <td>{{ number_format($item_orden_trabajo->Cantidad, 2, '.', '') }}</td>
                                <td>{{ number_format($item_orden_trabajo->Peso, 2, '.', '') }}</td>
                                <td>{{ $item_orden_trabajo->tratamiento->Nombre }}</td>
                                <td>{{ $item_orden_trabajo->material->Nombre }}</td>
                                <td>{{ $item_orden_trabajo->Descripcion }}</td>
                                <td>{{ $item_orden_trabajo->dureza->Nombre }}</td>
                                
                                @for ($i = 1; $i <= $item_orden_trabajo->programacion->max('NumeroProgramacion'); $i++)

                                    @php
                                        $programacion = $item_orden_trabajo->programacion->where('NumeroProgramacion', $i)->first();   
                                    @endphp

                                    <td>{{ $programacion->tipoProgramacion->Nombre }}</td>
                                    <td>{{ $programacion->Temperatura }}</td>
                                    <td>{{ $programacion->medioEnfriamiento->Nombre }}</td>
                                    <td>{{ $programacion->DurezaMinima }}/{{ $programacion->DurezaMaxima }}</td>
                                    <td>{{ $programacion->DurezaMinima }}</td>
                                    <td>{{ $programacion->DurezaMaxima }}</td>

                                @endfor  

                            </tr>
                        @empty
                            <tr><td colspan="12">No se encontraron resultados.</td></tr>
                        @endforelse
                    </x-slot>

                    <x-slot name="foot_tr">
                        <tr>
                            <th>Fecha</th>
                            <th>CLI.</th>
                            <th>Cant.</th>
                            <th>Peso</th>
                            <th>Trat.</th>
                            <th>Material</th>
                            <th>Descripción</th>
                            <th>Dureza</th>

                            @php
                                $tiene_programacion = false;
                            @endphp

                            @foreach ($items_orden_trabajo as $item_orden_trabajo)

                                @if ($item_orden_trabajo->programacion->max('NumeroProgramacion'))

                                    @php
                                        $tiene_programacion = true;
                                    @endphp

                                    @for ($i = 1; $i <= $item_orden_trabajo->programacion->max('NumeroProgramacion'); $i++)

                                        <th>Prog. {{$i}}</th>
                                        <th>T°</th>
                                        <th>Medio Enf.</th>
                                        <th>DMIN/DMAX</th>
                                        <th>DMIN</th>
                                        <th>DMAX</th>

                                    @endfor  

                                @endif

                            @endforeach

                            @if (!$tiene_programacion)
                                <th>Prog. 1</th>
                                <th>T°</th>
                                <th>Medio Enf.</th>
                                <th>DMIN/DMAX</th>
                                <th>DMIN</th>
                                <th>DMAX</th>                
                            @endif

                        </tr>
                    </x-slot>
                </x-data-table-no-plus>
            </x-slot>
            <x-slot name="buttons">
                <x-button>
                    <x-slot name="text">Volver</x-slot>
                    <x-slot name="color">danger</x-slot>
                    <x-slot name="href">{{ route('index') }}</x-slot>
                </x-button>
            </x-slot>
        </x-card>
    </div> --}}
</x-layout>