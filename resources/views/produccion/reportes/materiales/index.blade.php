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

    @livewire('filtrar-items-orden-trabajo')

    {{-- <div>
        

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