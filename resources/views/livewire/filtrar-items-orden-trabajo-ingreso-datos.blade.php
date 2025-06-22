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
                               
        <form action="{{ route('ingreso-datos.update') }}" method="POST">

            @csrf
            @method('PUT')
            
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
                        <th>Estado</th>
                        <th>Cert</th>
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
                                <td>{{ $item->Estado }}</td>
                                @if ($item->Estado == 'APROBADO')
                                    <td>
                                        <a href="">Imprimir</a>
                                        <a href="">Enviar por correo</a>
                                    </td>
                                @endif
                            </tr>

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

                                            @foreach ($item->programacion as $prog)

                                                <tr class="border-t text-center">
                                                    <input type="hidden" name="ProgramacionIds[]" value="{{$prog->id}}">
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

                                                <tr>
                                                    <label for="DurezaMinima">
                                                        DMIN ({{ $prog->DurezaMinima }}/0)
                                                        <input type="text" name="DurezaMinima[{{ $prog->id }}]" id="" value="{{ $prog->DurezaMinima }}">
                                                    </label>
                                                    <label for="DurezaMaxima">
                                                        DMAX ({{ $prog->DurezaMaxima }}/0)
                                                        <input type="text" name="DurezaMaxima[{{ $prog->id }}]" id="" value="{{ $prog->DurezaMaxima }}">
                                                    </label>
                                                </tr>
                                                <tr>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="ProcesoApto[{{ $prog->id }}]" id="{{ $prog->id }}1" value="SI" />
                                                        <label class="form-check-label" for="{{ $prog->id }}1">Proceso Apto</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="ProcesoApto[{{ $prog->id }}]" id="{{ $prog->id }}2" value="NO" />
                                                        <label class="form-check-label" for="{{ $prog->id }}2">Proceso No Apto</label>
                                                    </div>
                                                </tr>
                                                <tr>
                                                    <input type="submit" value="Aceptar">
                                                    <a href="{{ route('ingreso-datos.index') }}">Cancelar</a>
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

                    </form>

                </tbody>
            </table>
        </form>
    </div>
</div>
