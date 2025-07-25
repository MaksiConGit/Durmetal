<tr>
    <input type="hidden" name="ItemOrdenTrabajoIds[]" value="{{ $item->id }}">
    <td>{{ $item->Descripcion }}</td>

    <td>
        <select name="NumeroProgramacion[{{ $index }}]" wire:model.live="numeroProgramacionSeleccionado">
            <option value="0">Nueva</option>
                @foreach ($item->programacion->groupBy('NumeroProgramacion') as $numero => $grupo)
                    @php
                        $suma = $grupo->sum('Cantidad');
                        $programacion = $grupo->first();
                    @endphp

                    @if ($suma < $item->Cantidad)
                        <option value="{{ $numero }}">
                            {{ $programacion->tipoProgramacion->Nombre }} {{ $numero }}
                        </option>
                    @endif
                @endforeach
        </select>
    </td>

    <td>
        <input type="text" name="Cantidad" value="{{ number_format($cantidadFinal, 3, '.', '') }}">
        <input type="hidden" name="CantidadFinal" value="{{$cantidadFinal}}">
    </td>

    <td>
        <input type="hidden" name="Reproceso[{{ $index }}]" value="0">
        <input type="checkbox" name="Reproceso[{{ $index }}]" id="Reproceso[{{ $index }}]" value="1">
    </td>

    <td>{{ $item->ordenTrabajo->cliente->Nombre ?? 'Sin razón social' }}</td>
    <td>{{ $item->FechaCreacion }}</td>
    <td>{{ $item->ordenTrabajo->Numero }}/{{ $item->ItemNumero }}</td>
    <td>{{ $item->Cantidad }}</td>
    <td>{{ $item->Peso }}</td>
    <td>{{ $item->tratamiento->Nombre }}</td>
    <td>{{ $item->material->Nombre }}</td>
    <td>{{ $item->dureza->Nombre }}</td>
    <td>{{ $item->DurezaSolicitadaMinima }} - {{ $item->DurezaSolicitadaMaxima }}</td>
</tr>
