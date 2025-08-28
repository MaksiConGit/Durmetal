<x-layout2>
    <x-slot name="title">LISTADO DE PRECIOS {{ now()->format('j/n/Y') }}</x-slot>

    <x-simple-table2>
        <x-slot name="thead">
            <tr>
                <th>TRAT.</th>
                <th>CC</th>
                <th>DESCRIPCION</th>
                <th>DIVISA</th>
                <th>ARS</th>
                <th>USD</th>
            </tr>
        </x-slot>
        <x-slot name="tbody">

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
                <tr><td colspan="6">No se encontraron resultados.</td></tr>
            @endforelse

        </x-slot>

    </x-simple-table2>

    <div class="mt-4">
        <span class="text-muted">1 dólar estadounidense equivale a {{number_format(($configuracion_global->USD_ARS), 2, '.', '') }} pesos argentinos</span>
    </div>

</x-layout2>