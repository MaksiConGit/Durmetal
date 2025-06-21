<x-layout>
    <x-slot name="title">Producción</x-slot>
    <x-slot name="breadcrumbs">
        <li class="nav-home">
            <a href="#"><i class="fas fa-cogs"></i></a>
        </li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="#">Programación</a></li>
    </x-slot>

    <x-form>
        <x-slot name="card_title">Órden de Trabajo</x-slot>
        <x-slot name="action"></x-slot>
        <x-slot name="method"></x-slot>
        <x-slot name="inputs">

            <x-data-table-no-plus>
                <x-slot name="table_title">Item Órden de Trabajo</x-slot>
                <x-slot name="export_route">{{ route('programacion.export') }}</x-slot>
                <x-slot name="add_text">Añadir Item</x-slot>

                <x-slot name="head_tr">
                    <tr>
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
                    <tr>
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
                </x-slot>

                <x-slot name="foot_tr">
                    <tr>
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
            </x-data-table-no-plus>

            <x-data-table-no-plus>
                <x-slot name="table_title">Programación</x-slot>
                <x-slot name="export_route">{{ route('programacion.export') }}</x-slot>
                <x-slot name="add_text">Añadir Item</x-slot>

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
                    @php
                        $programacionesAgrupadas = $item_orden_trabajo->programacion->groupBy('NumeroProgramacion');
                    @endphp

                    @foreach ($programacionesAgrupadas as $numeroProgramacion => $grupo)
                        @foreach ($grupo as $index => $programacion)
                            <tr>
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
            </x-data-table-no-plus>
        </x-slot>
        <x-slot name="buttons">
            {{-- <a href="" class="btn btn-success">
                Programar
            </a> --}}

            <x-button>
                <x-slot name="text">Volver</x-slot>
                <x-slot name="color">danger</x-slot>
                <x-slot name="href">{{ route('programacion.index') }}</x-slot>
            </x-button>
        </x-slot>
    </x-form>

</x-layout>