<div>
    <x-layout2>
        <x-slot name="title">Asignar factores a empleados</x-slot>

        <x-data-table-acordion2>
            <x-slot name="thead">
                <tr class="bg-secondary text-white">
                    <th>USUARIO</th>
                    <th>NOMBRE</th>
                    <th>INDICE BASE</th>
                    <th>PROMEDIO</th>
                </tr>
            </x-slot>

            <x-slot name="tbody">
                @forelse ($empleados as $usuario)
                
                    @livewire('factores-premio-form', ['factoresPremioUsuario' => $usuario->factoresPremioUsuario, 'factoresPremio' => $factores_premio, 'usuario' => $usuario])

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
    </x-layout2>

</div>
