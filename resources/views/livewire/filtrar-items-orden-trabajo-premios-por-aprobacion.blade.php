<div>
    <div class="mb-4 grid grid-cols-2 md:grid-cols-4 gap-4">
        <div>
            <label>Desde aprobación:</label>
            <input type="date" wire:model.live="fecha_inicio" class="border p-1 w-full">
        </div>

        <div>
            <label>Hasta:</label>
            <input type="date" wire:model.live="fecha_fin" class="border p-1 w-full">
        </div>
    </div>
    
    <div class="overflow-x-auto">
        @php $total_acumulado = 0; @endphp
        <form action="{{ route('reportes.premios-por-aprobacion.update') }}" method="POST">
            @csrf
            @method('PUT')
            <table class="table-auto w-full border">
                <thead>
                    <tr>
                        <th></th>
                        <th>Fecha OTI</th>
                        <th>OTI</th>
                        <th>Cli.</th>
                        <th>Trat.</th>
                        <th>Material</th>
                        <th>Fecha Aprobación</th>
                        <th>Estado</th>
                        <th>Descripción</th>
                        <th>Cant.</th>
                        <th>Peso</th>
                        <th>CC</th>
                        <th>Coeficiente</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total_acumulado = 0; @endphp
                    @forelse ($items_orden_trabajo as $item)
                        @php
                            $coef = $item->codigoComplejidad->Coeficiente ?? 0;
                            $subtotal = $coef * $item->Peso;
                            $total_acumulado += $subtotal;
                        @endphp
                        <tr class="border-t">
                            <td><input type="checkbox" name="ItemOrdenTrabajo_ids[]" value="{{ $item->id }}"></td>
                            <td>{{ $item->ordenTrabajo->FechaEmision }}</td>
                            <td>{{ $item->ItemNumero }} / {{ $item->ordenTrabajo->Numero }}</td>
                            <td>[{{ $item->ordenTrabajo->cliente->id }}] {{ $item->ordenTrabajo->cliente->Nombre }}</td>
                            <td>{{ $item->tratamiento->Nombre }}</td>
                            <td>{{ $item->material->Nombre }}</td>
                            <td>{{ $item->FechaActualizacionEstado }}</td>
                            <td>{{ $item->Estado }}</td>
                            <td>{{ $item->Descripcion }}</td>
                            <td>{{ number_format($item->Cantidad, 2, '.', '') }}</td>
                            <td>{{ number_format($item->Peso, 2, '.', '') }}</td>
                            <td>{{ $item->CodigoComplejidad }}</td>
                            <td>{{ number_format($coef, 2, '.', '') }}</td>
                            <td>{{ number_format($subtotal, 2, '.', '') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="13" class="text-center py-2">No se encontraron resultados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <a href="{{ route('repartir-premios.create', ['total' => $total_acumulado]) }}">Distribuir</a>
            <div>
                <label>Fecha aprobación</label>
                <input type="date" class="border p-1 w-full" name="FechaActualizacionEstado" value="{{ now()->format('Y-m-d') }}">
            </div>
            <input type="submit" value="Guardar">
            @if(session('success'))
                <div class="">
                    {{ session('success') }}
                </div>
            @endif
        </form>
    </div>

    <label for="">
        Total
        <input type="text" name="" id="" value="{{ number_format($total_acumulado, 2, '.', '') }}" disabled>
    </label>
</div>
