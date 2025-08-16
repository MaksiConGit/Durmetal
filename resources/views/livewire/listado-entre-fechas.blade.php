<div>
    <div class="card">
        <div class="card-header">
            <div class="card-title">Filtros</div>
        </div>

        <div class="card-body">
            <div class="row">

        <div class="col-md-3">
            <x-form-input-date-livewire>
                <x-slot name="label">Desde Fecha</x-slot>
                <x-slot name="livewire">wire:model.live="cliente_desde"</x-slot>
                <x-slot name="name">cliente_desde</x-slot>
                <x-slot name="message"></x-slot>
                <x-slot name="value"></x-slot>
                <x-slot name="error"></x-slot>
            </x-form-input-date-livewire>
        </div>

        <div class="col-md-3">
            <x-form-input-date-livewire>
                <x-slot name="label">Hasta Fecha</x-slot>
                <x-slot name="livewire">wire:model.live="cliente_hasta"</x-slot>
                <x-slot name="name">cliente_hasta</x-slot>
                <x-slot name="message"></x-slot>
                <x-slot name="value"></x-slot>
                <x-slot name="error"></x-slot>
            </x-form-input-date-livewire>
        </div>

    </div>

    <x-data-table-no-plus>
      
        <x-slot name="table_title">Otros Egresos entre Fechas</x-slot>
        <x-slot name="export_route">{{ route('clients.export') }}</x-slot>
        <x-slot name="create_route">{{ route('otros-egresos.otros-egresos.create') }}</x-slot>
        <x-slot name="add_text">Añadir Otro Egreso</x-slot>
        <x-slot name="head_tr">
            <tr>
                <th>Cuenta</th>
                <th>Subcuentas</th>
                <th>Detalle Subcuentas</th>
                <th>Importe</th>
            </tr>
        </x-slot>
        <x-slot name="body_tr">
    
            @forelse ($cuentas_otros_egresos as $padre)
                <tr>
                    <td>{{ $padre->Nombre }}</td>
                    <td></td>
                    <td></td>
                    <td>{{ number_format($padre->total_movimientos, 2, '.', '') }}</td>
                </tr>

                @foreach ($padre->hijos as $hijo)
                    <tr>
                        <td></td>
                        <td>{{ $hijo->Nombre }}</td>
                        <td>{{ number_format($hijo->total_movimientos, 2, '.', '') }}</td>
                        <td></td>
                    </tr>

                @endforeach
            @empty
                <tr><td colspan="4">No se encontraron resultados.</td></tr>
            @endforelse

            <tr>
                <td>Total del Periodo</td>
                <td></td>
                <td></td>
                <td>{{ number_format($total_general, 2, '.', '') }}</td>
            </tr>
        </x-slot>
        <x-slot name="foot_tr">
            <tr>
                <th>Cuenta</th>
                <th>Subcuentas</th>
                <th>Detalle Subcuentas</th>
                <th>Importe</th>
            </tr>
        </x-slot>
    </x-data-table-no-plus>
</div>
