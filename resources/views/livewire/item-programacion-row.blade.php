<tr>
    <input type="hidden" name="ItemOrdenTrabajoIds[]" value="{{ $item->id }}">
    <td>{{ $item->Descripcion }}</td>

    <td>
        <select name="NumeroProgramacion[{{ $index }}]" wire:model.live="numeroProgramacionSeleccionado">
            <option value="0">Nueva</option>
            @foreach ($programaciones as $programacion)
                <option value="{{ $programacion->NumeroProgramacion }}">
                    {{ $programacion->tipoProgramacion->Nombre }} {{ $programacion->NumeroProgramacion }}
                </option>
            @endforeach
        </select>
    </td>

    <td>
        <input type="text" name="Cantidad[]" value="{{ number_format($cantidadFinal, 3, '.', '') }}">
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
