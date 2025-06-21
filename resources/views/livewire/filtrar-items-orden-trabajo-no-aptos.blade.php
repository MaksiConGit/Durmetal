<div>
    {{-- Filtros --}}
    <div class="mb-4 grid grid-cols-2 md:grid-cols-4 gap-4">
        <div>
            <label>Desde:</label>
            <input type="date" wire:model.live="fecha_inicio" class="border p-1 w-full">
        </div>

        <div>
            <label>Hasta:</label>
            <input type="date" wire:model.live="fecha_fin" class="border p-1 w-full">
        </div>

        <div>
            <label>OTI - ItemNumero:</label>
            <input type="text" wire:model.live="oti_item_numero" class="border p-1 w-full">
        </div>

        <div>
            <label>OTI - OrdenTrabajo.Numero:</label>
            <input type="text" wire:model.live="oti_orden_numero" class="border p-1 w-full">
        </div>
    </div>

    <div class="mb-4">
        <label class="block mb-1 font-semibold">Filtrar por Tratamiento:</label>
        <div class="flex flex-wrap gap-4">
            @foreach ($tratamientos as $tratamiento)
                <label class="flex items-center space-x-2">
                    <input type="checkbox" wire:model.live="tratamientos_seleccionados" value="{{ $tratamiento->id }}">
                    <span>{{ $tratamiento->Nombre }}</span>
                </label>
            @endforeach
        </div>
    </div>

    <div class="mb-4">
        <label for="cliente_id" class="block mb-1 font-semibold">Filtrar por Cliente:</label>
        <select wire:model.live="cliente_id" id="cliente_id" class="border p-2 w-full">
            <option value="">-- Todos los clientes --</option>
            @foreach ($clientes as $cliente)
                <option value="{{ $cliente->id }}">{{ $cliente->id }} | {{ $cliente->Nombre }}</option>
            @endforeach
        </select>
    </div>

    {{-- Tabla --}}
    <div class="overflow-x-auto">
        <table class="table-auto w-full border text-sm">
            <thead>
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
            </thead>
            <tbody>
                @php $total_acumulado = 0; @endphp
                @forelse ($items_orden_trabajo as $item)
                    @php $total_acumulado += $item->Peso; @endphp
                    <tr class="border-t bg-gray-50">
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

                    {{-- Filas de programaciones --}}
                    <tr>
                        <td colspan="8" class="p-0">
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
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-2">No se encontraron resultados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
