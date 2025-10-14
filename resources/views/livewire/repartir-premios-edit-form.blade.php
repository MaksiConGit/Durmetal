<div>
<div>
    <x-data-table-no-plus>
        <x-slot name="table_title">Empleados</x-slot>
        <x-slot name="export_route">{{ route('clients.export') }}</x-slot>
        <x-slot name="head_tr">
            <tr>
                <th>Empleado</th>
                <th>Base</th>
                <th>Índice Base</th>
                <th>Coeficiente</th>
                <th>Premio</th>
            </tr>
        </x-slot>
        <x-slot name="body_tr">
            @foreach ($items_premio as $item)
                @php
                    $usuario = $item->usuario;
                @endphp
                <tr>
                    <input type="hidden" name="IdUsuario[]" value="{{ $usuario->id }}">

                    <td>{{ $usuario->name }}</td>

                    <td>
                        <input 
                            type="number" 
                            step="0.01" 
                            name="PremioBase[]"
                            wire:model.live="bases.{{ $usuario->id }}" 
                            class="form-control" 
                            placeholder="0.00">
                    </td>

                    <td>
                        <input 
                            type="number" 
                            step="0.01"
                            name="IndiceBase[]"
                            wire:model.live="indiceBasePremios.{{ $usuario->id }}"
                            class="form-control" 
                            placeholder="0.00">
                    </td>

                    <td>
                        <input 
                            type="number" 
                            step="0.01" 
                            name="Coeficiente[]"
                            wire:model.live="coeficientes.{{ $usuario->id }}" 
                            class="form-control" 
                            placeholder="1.00">
                    </td>

                    <td>
                        {{ number_format($premios[$usuario->id] ?? 0, 2, ',', '') }}
                        <input type="hidden" name="Premio[]" value="{{ number_format($premios[$usuario->id] ?? 0, 2, '.', '') }}">
                    </td>
                </tr>
            @endforeach
        </x-slot>
        <x-slot name="foot_tr">
            <tr>
                <th>Empleado</th>
                <th>Base</th>
                <th>Índice Base</th>
                <th>Coeficiente</th>
                <th>Premio</th>
            </tr>
        </x-slot>
    </x-data-table-no-plus>

    <div class="row mb-3">
        <div class="col-md-9"></div>
        <div class="col-md-3 text-end">
            <x-form-input-disabled>
                <x-slot name="label">Premios Otorgados</x-slot>
                <x-slot name="name"></x-slot>
                <x-slot name="placeholder"></x-slot>
                <x-slot name="value">{{ number_format($totalPremios, 2, '.', '') }}</x-slot>
                <x-slot name="message"></x-slot>
                <x-slot name="error"></x-slot>
            </x-form-input-disabled>

            <input type="hidden" name="PremioTotal" value="{{ $totalPremios }}">
        </div>
    </div>
</div>
