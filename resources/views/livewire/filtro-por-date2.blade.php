<div>
    @php
        use App\Models\Programacion;
    @endphp
    
    <x-layout2-sidebar>
        <x-slot name="title">Cargas</x-slot>

        <x-slot name="filtros">
            <div class="form-inline mt-5 mr-3 d-flex flex-column align-items-center">

                <div class="form-group mb-3">
                    <a href="{{ $selectedId ? route('programacion.edit', $selectedId) : '#' }}" 
                    class="btn btn-app bg-primary {{ !$selectedId ? 'disabled' : '' }}">
                        <i class="fas fa-pen"></i> Modificar
                    </a>
                </div>

                <div class="form-group mb-3">
                    <form
                        action="{{ $selectedId ? route('programacion.destroy', $selectedId) : '#' }}"
                        method="POST"
                        onsubmit="return confirm('¿Estás seguro de que quieres eliminar esta programación?')"
                        class="m-0 p-0"
                    >
                        @csrf
                        @method('DELETE')
                        <button
                            type="submit"
                            class="btn btn-app bg-primary {{ !$selectedId ? 'disabled' : '' }}"
                            data-bs-toggle="tooltip"
                            title="Eliminar programación"
                        >
                        <i class="fas fa-xmark"></i> Eliminar
                        </button>
                    </form>
                </div>

            </div>

        </x-slot>

        <x-data-table-acordion2>

            <x-slot name="thead">
                <tr class="bg-secondary text-white">
                    <th>FECHA CARGA</th>
                    <th>FECHA DESCARGA</th>
                    <th>N° HORNO</th>
                    <th>TEMPERATURA</th>
                    <th>ENF.</th>
                    <th>EJEC. POR</th>
                </tr>   
            </x-slot>

            <x-slot name="tbody">

                @forelse ($programaciones as $index => $programacion)
                    <tr data-widget="expandable-table" 
                        aria-expanded="{{ in_array($programacion->programacion_ids, $expanded) ? 'true' : 'false' }}"
                        wire:click="toggleExpand('{{ $programacion->programacion_ids }}')">
                        <td>{{ \Carbon\Carbon::parse($programacion->FechaCarga)->format('d/m/Y H:i') }}</td>
                        <td>{{ \Carbon\Carbon::parse($programacion->FechaDescarga)->format('d/m/Y H:i') }}</td>
                        <td>{{ $programacion->NumeroHorno }}</td>
                        <td>{{ $programacion->Temperatura }}</td>
                        <td>{{ $programacion->medioEnfriamiento->Nombre }}</td>
                        <td>{{ $programacion->ejecutadoPorOperador->name }}</td>
                    </tr>

                    <tr class="expandable-body" style="display: {{ in_array($programacion->programacion_ids, $expanded) ? 'table-row' : 'none' }};">

                        <td colspan="15">
                            <div class="p-0">
                                <table class="table table-sm table-bordered mb-0">
                                    <thead>
                                    <tr class="bg-dark text-white">
                                        <th>DESCRIPCION</th>
                                        <th>RAZON SOCIAL</th>
                                        <th>OTI</th>
                                        <th>PROGRAMACION</th>
                                        <th>RP</th>
                                        <th>CANTIDAD</th>
                                        <th>APTO</th>
                                        <th>DMIN</th>
                                        <th>DMAX</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                        @php
                                            $idsArray = explode(',', $programacion->programacion_ids);

                                            $programaciones_carga = Programacion::whereIn('id', $idsArray)
                                                ->with(['medioEnfriamiento', 'ejecutadoPorOperador'])
                                                ->get();

                                            $programacionesCount = $programaciones_carga->count();
                                        @endphp

                                        @forelse ($programaciones_carga as $programacion)
                                            <tr>
                                                <td>{{ $programacion->itemOrdenTrabajo->Descripcion}}</td>
                                                <td>
                                                    [{{ $programacion->itemOrdenTrabajo->ordenTrabajo->cliente->id }}]
                                                    {{$programacion->itemOrdenTrabajo->ordenTrabajo->cliente->Nombre ?? 'Sin razón social' }}
                                                </td>
                                                <td>{{ $programacion->itemOrdenTrabajo->ordenTrabajo->Numero }}/{{ $programacion->itemOrdenTrabajo->ItemNumero }}</td>
                                                <td>{{ $programacion->tipoProgramacion->Nombre }}</td>
                                                <td>{{ $programacion->Reproceso == 0 ? '' : 'RP' }}</td>
                                                <td>{{ $programacion->Cantidad }}</td>
                                                <td>{{ $programacion->Apto == 'SI' ? 'APTO' : ''}}</td>
                                                <td>{{ $programacion->DurezaMinima }}</td>
                                                <td>{{ $programacion->DurezaMaxima }}</td>
                                            </tr>
                                        
                                        @empty
                                            @for ($i = 0; $i < 6; $i++)
                                                <tr>
                                                    <td colspan="15">&nbsp;</td>
                                                </tr>
                                            @endfor
                                        @endforelse

                                        @if ($programacionesCount > 0 && $programacionesCount < 6)
                                            @for ($i = $programacionesCount; $i < 6; $i++)
                                                <tr>
                                                    <td colspan="15">&nbsp;</td>
                                                </tr>
                                            @endfor
                                        @endif

                                        @if ($programacionesCount >= 6)
                                            <tr>
                                                <td colspan="15">&nbsp;</td>
                                            </tr>
                                        @endif

                                    </tbody>
                                </table>
                            </div>
                        </td>

                    </tr>
                @empty
                    <tr><td colspan="12">No se encontraron resultados.</td></tr>
                @endforelse

            </x-slot>

        </x-data-table-acordion2>

    </x-layout2-sidebar>

</div>