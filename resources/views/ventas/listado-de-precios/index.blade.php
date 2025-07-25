<x-layout>
    <x-slot name="title">Ventas</x-slot>
    <x-slot name="breadcrumbs">
        <li class="nav-home">
            <a href="#"><i class="fas fa-dollar-sign"></i></a>
        </li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="#">Listado de Precios {{ now()->format('d/m/Y') }}</a></li>
    </x-slot>

    <x-card>
        <x-slot name="card_title">Editar Carga</x-slot>
        <x-slot name="body">

            <x-data-table-no-plus>
            
                <x-slot name="table_title">Listado de Precios {{ now()->format('d/m/Y') }}</x-slot>
                <x-slot name="export_route">{{ route('clients.export') }}</x-slot>
                <x-slot name="head_tr">
                    <tr>
                        <th>Trat.</th>
                        <th>CC</th>
                        <th>Descripción</th>
                        <th>Divisa</th>
                        <th>ARS</th>
                        <th>USD</th>
                    </tr>
                </x-slot>
                <x-slot name="body_tr">
            
                    @forelse ($tratamientos as $tratamiento)
                        @foreach ($tratamiento->precios as $codigo_complejidad)
                            <tr>
                                <td>{{ $tratamiento->Nombre }}</td>
                                <td>{{ $codigo_complejidad->CC }}</td>
                                <td>{{ $tratamiento->Descripcion }}</td>
                                <td>{{ $codigo_complejidad->Divisa }}</td>
                                <td>{{ number_format($codigo_complejidad->Precio, 2, '.', '') }}</td>

                                @if ($codigo_complejidad->Divisa == 'ARS')
                                    <td>{{ number_format(($codigo_complejidad->Precio * $configuracion_global->USD_ARS), 2, '.', '') }}</td>
                                @elseif ($codigo_complejidad->Divisa == 'USD')
                                    <td>{{ number_format(($codigo_complejidad->Precio / $configuracion_global->USD_ARS), 2, '.', '') }}</td>
                                @endif
                            </tr>
                        @endforeach

                    @empty
                        <tr><td colspan="11">No se encontraron resultados.</td></tr>
                    @endforelse
                </x-slot>
                <x-slot name="foot_tr">
                    <tr>
                        <th>Trat.</th>
                        <th>CC</th>
                        <th>Descripción</th>
                        <th>Divisa</th>
                        <th>ARS</th>
                        <th>USD</th>
                    </tr>
                </x-slot>
            </x-data-table-no-plus>
        </x-slot>

        <x-slot name="buttons">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted">1 dólar estadounidense equivale a {{number_format(($configuracion_global->USD_ARS), 2, '.', '') }} pesos argentinos</span>
                </div>
                <div class="d-flex gap-2">
                    <x-button>
                        <x-slot name="text">Volver</x-slot>
                        <x-slot name="color">danger</x-slot>
                        <x-slot name="href">{{ route('index') }}</x-slot>
                    </x-button>
                </div>
            </div>
        </x-slot>

    </x-card>

</x-layout>