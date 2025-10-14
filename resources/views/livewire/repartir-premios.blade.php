<div>
    <x-layout2-sidebar>
        <x-slot name="title">Repartir Premios</x-slot>

        <x-slot name="filtros">
            <div class="form-inline mt-5 mr-3 d-flex flex-column align-items-center">

                <div class="form-group mb-3">
                    <a class="btn btn-app bg-primary" href="{{ route('repartir-premios.create') }}">
                        <i class="fas fa-plus"></i> Nuevo
                    </a>
                </div>

                <div class="form-group mb-3">
                    <a 
                        href="{{ $selectedItem ? route('repartir-premios.edit', $selectedItem) : '#' }}"
                        class="btn btn-app bg-primary {{ !$selectedItem ? 'disabled' : '' }}"
                    >
                        <i class="fas fa-pen"></i> Modificar
                    </a>
                </div>

                <div class="form-group mb-3">
                    <button
                        type="button"
                        class="btn btn-app bg-primary {{ !$selectedItem ? 'disabled' : '' }}"
                        wire:click="deleteItem({{ $selectedItem }})"
                        wire:loading.attr="disabled"
                        onclick="return confirm('¿Estás seguro que deseas eliminar este premio?')"
                    >
                        <i class="fas fa-trash-can"></i> Eliminar
                    </button>
                </div>
                                
            </div>

        </x-slot>

        <x-data-table-acordion2>
            <x-slot name="thead">
                <tr class="bg-secondary text-white">
                    <th>NOMBRE</th>
                    <th>FECHA DESDE</th>
                    <th>FECHA HASTA</th>
                    <th>PREMIO</th>
                    <th>ESTADO</th>
                </tr>
            </x-slot>

            <x-slot name="tbody">
                @forelse ($premios as $premio)
                    <tr 
                        style="cursor: pointer;"
                        wire:click="selectAndExpand({{ $premio->id }})"
                        class="{{ $selectedItem == $premio->id ? 'table-primary' : '' }}"
                        aria-expanded="{{ in_array($premio->id, $expanded) ? 'true' : 'false' }}"
                    >
                        <td>{{ $premio->Nombre }}</td>
                        <td>{{ $premio->FechaDesde }}</td>
                        <td>{{ $premio->FechaHasta }}</td>
                        <td>{{ number_format($premio->Premio, 2, '.', '') }}</td>
                        <td>{{ $premio->Estado }}</td>
                    </tr>

                    <tr class="expandable-body" style="display: {{ in_array($premio->id, $expanded) ? 'table-row' : 'none' }};">
                        <td colspan="15">
                            <div class="p-0">
                            <table class="table table-sm table-bordered mb-0">
                                <thead>
                                <tr class="bg-dark text-white">
                                    <th>EMPLEADO</th>
                                    <th>BASE</th>
                                    <th>INDICE BASE</th>
                                    <th>COEFICIENTE</th>
                                    <th>PREMIO</th>
                                </tr>
                                </thead>
                                <tbody>

                                    @php
                                        $itemsPremio = $premio->itemsPremio;
                                        $itemsPremioCount = $premio->itemsPremio->count();
                                    @endphp

                                    @foreach ($itemsPremio as $item_premio)
                                        <tr>
                                            <td>{{ $item_premio->usuario->name }}</td>
                                            <td>{{ number_format($item_premio->PremioBase, 2, '.', '') }}</td>
                                            <td>{{ number_format($item_premio->IndiceBase, 2, '.', '') }}</td>
                                            <td>{{ number_format($item_premio->Coeficiente, 2, '.', '') }}</td>
                                            <td>{{ number_format($item_premio->Premio, 2, '.', '') }}</td>
                                        </tr>
                                    @endforeach

                                    @for ($i = $itemsPremioCount; $i < 6; $i++)
                                        <tr>
                                            <td colspan="15">&nbsp;</td>
                                        </tr>
                                    @endfor

                                </tbody>
                            </table>
                            </div>
                        </td>

                    </tr>

                @endforeach
                
                @php
                    $filasFaltantes = max(0, 11 - count($premios));
                @endphp

                @for ($i = 0; $i < $filasFaltantes; $i++)
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                @endfor

            </x-slot>
        </x-data-table-acordion2>
    </x-layout2-sidebar>

</div>
