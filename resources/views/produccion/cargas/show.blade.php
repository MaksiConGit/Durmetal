<x-layout>
    <x-slot name="title">Producción</x-slot>
    <x-slot name="breadcrumbs">
        <li class="nav-home">
            <a href="#"><i class="fas fa-cogs"></i></a>
        </li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="{{ route('cargas.index') }}">Carga</a></li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="#">Ver carga</a></li>
    </x-slot>

    <x-form>
        <x-slot name="card_title">Ver Carga</x-slot>
        <x-slot name="action"></x-slot>
        <x-slot name="method"></x-slot>
        <x-slot name="inputs">

            <x-data-table-no-plus>
                <x-slot name="table_title">Carga</x-slot>
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
                    <tr>
                        @php
                            $primerProgramacion = $programaciones->first();
                        @endphp

                        @if ($primerProgramacion)
                            <td>{{ $primerProgramacion->FechaCarga }}</td>
                            <td>{{ $primerProgramacion->FechaDescarga }}</td>
                            <td>{{ $primerProgramacion->NumeroHorno }}</td>
                            <td>{{ $primerProgramacion->Temperatura }}</td>
                            <td>{{ $primerProgramacion->medioEnfriamiento->Nombre }}</td>
                            <td>{{ $primerProgramacion->ejecutadoPorOperador->name }}</td>
                        @endif
                    </tr>
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

            <x-data-table-no-plus>
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
                    @foreach ($programaciones as $programacion)
                        <tr>
                            <td>{{ $programacion->itemOrdenTrabajo->Descripcion }}</td>
                            <td>
                                [{{ $programacion->itemOrdenTrabajo->ordenTrabajo->cliente->id }}]
                                {{$programacion->itemOrdenTrabajo->ordenTrabajo->cliente->Nombre ?? 'Sin razón social' }}
                            </td>
                            <td>{{ $programacion->itemOrdenTrabajo->ordenTrabajo->Numero }}/{{ $programacion->itemOrdenTrabajo->ItemNumero }}</td>
                            <td>{{ $programacion->medioEnfriamiento->Nombre }}</td>
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
            </x-data-table-no-plus>
        </x-slot>
        <x-slot name="buttons">
            {{-- <a href="" class="btn btn-success">
                Programar
            </a> --}}

            <x-button>
                <x-slot name="text">Volver</x-slot>
                <x-slot name="color">danger</x-slot>
                <x-slot name="href">{{ route('cargas.index') }}</x-slot>
            </x-button>
        </x-slot>
    </x-form>

</x-layout>