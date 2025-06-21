<div>
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
            <label>Dureza mínima solicitada:</label>
            <input type="text" wire:model.live="dureza_min" class="border p-1 w-full">
        </div>

        <div>
            <label>Dureza máxima solicitada:</label>
            <input type="text" wire:model.live="dureza_max" class="border p-1 w-full">
        </div>
    </div>

    <div class="mb-4">
        <label class="block mb-1 font-semibold">Filtrar por Material:</label>
        <div class="flex flex-wrap gap-4">
            @foreach ($materiales as $material)
                <label class="flex items-center space-x-2">
                    <input type="checkbox" wire:model.live="materiales_seleccionados" value="{{ $material->id }}">
                    <span>{{ $material->Nombre }}</span>
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


    <div class="overflow-x-auto">
        <table class="table-auto w-full border">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Cliente</th>
                    <th>Cantidad</th>
                    <th>Peso</th>
                    <th>Tratamiento</th>
                    <th>Material</th>
                    <th>Descripción</th>
                    <th>Dureza</th>
                    <th colspan="6">Programación</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($items_orden_trabajo as $item_orden_trabajo)
                    <tr class="border-t">
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
                            <td>{{ $programacion->tipoProgramacion->Nombre ?? '' }}</td>
                            <td>{{ $programacion->Temperatura ?? '' }}</td>
                            <td>{{ $programacion->medioEnfriamiento->Nombre ?? '' }}</td>
                            <td>{{ $programacion ? $programacion->DurezaMinima . '/' . $programacion->DurezaMaxima : '' }}</td>
                            <td>{{ $programacion->DurezaMinima ?? '' }}</td>
                            <td>{{ $programacion->DurezaMaxima ?? '' }}</td>
                        @endfor
                    </tr>
                @empty
                    <tr>
                        <td colspan="14" class="text-center py-2">No se encontraron resultados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
