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
            <label>CC Desde</label>
            <input type="number" wire:model.live="cc_min" class="border p-1 w-full">
        </div>

        <div>
            <label>Hasta</label>
            <input type="number" wire:model.live="cc_max" class="border p-1 w-full">
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

    <div class="overflow-x-auto">
        <table class="table-auto w-full border">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Trat.</th>
                    <th>Material</th>
                    <th>Descripcion</th>
                    <th>Cant.</th>
                    <th>Peso</th>
                    <th>CC</th>
                    <th>Total Acumulado</th>
                </tr>
            </thead>
            <tbody>
                @php $total_acumulado = 0; @endphp
                @forelse ($items_orden_trabajo as $item_orden_trabajo)
                    @php $total_acumulado += $item_orden_trabajo->Peso; @endphp
                    <tr class="border-t">
                        <td>{{ $item_orden_trabajo->FechaCreacion }}</td>
                        <td>{{ $item_orden_trabajo->tratamiento->Nombre }}</td>
                        <td>{{ $item_orden_trabajo->material->Nombre }}</td>
                        <td>{{ $item_orden_trabajo->Descripcion }}</td>
                        <td>{{ number_format($item_orden_trabajo->Cantidad, 2, '.', '') }}</td>
                        <td>{{ number_format($item_orden_trabajo->Peso, 2, '.', '') }}</td>
                        <td>{{ $item_orden_trabajo->CodigoComplejidad }}</td>
                        <td>{{ number_format($total_acumulado, 2, '.', '') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="15" class="text-center py-2">No se encontraron resultados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <label for="">
        Total
        <input type="text" name="" id="" value="{{ number_format($total_acumulado, 2, '.', '') }}" disabled>
    </label>
</div>
