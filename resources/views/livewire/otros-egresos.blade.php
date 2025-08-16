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

    <x-data-table >
      
        <x-slot name="table_title">Otros Egresos</x-slot>
        <x-slot name="export_route">{{ route('clients.export') }}</x-slot>
        <x-slot name="create_route">{{ route('otros-egresos.otros-egresos.create') }}</x-slot>
        <x-slot name="add_text">Añadir Otro Egreso</x-slot>
        <x-slot name="head_tr">
            <tr>
                <th>Opciones</th>
                <th>Fecha Devengado</th>
                <th>Fecha Pago</th>
                <th>Descripción</th>
                <th>Cuenta</th>
                <th>Importe</th>
            </tr>
        </x-slot>
        <x-slot name="body_tr">
    
            @forelse ($movimientos_cuenta_gastos as $movimiento_cuenta_gastos)
                <tr>
                    <td class="text-start align-middle">
                        <div class="d-flex justify-content-start align-items-center gap-3 ms-2">
                            <a
                                href="{{ route('otros-egresos.otros-egresos.edit', $movimiento_cuenta_gastos) }}"
                                class="btn btn-link btn-primary p-0"
                                data-bs-toggle="tooltip"
                                title="Editar egreso"
                            >
                                <i class="fa fa-edit fa-lg"></i>
                            </a>
                            <form
                                action="{{ route('otros-egresos.otros-egresos.destroy', $movimiento_cuenta_gastos) }}"
                                method="POST"
                                onsubmit="return confirm('¿Estás seguro de que quieres eliminar este egreso?')"
                                class="m-0 p-0"
                            >
                                @csrf
                                @method('DELETE')
                                <button
                                    type="submit"
                                    class="btn btn-link btn-danger p-0"
                                    data-bs-toggle="tooltip"
                                    title="Eliminar egreso"
                                >
                                    <i class="fa fa-times fa-lg"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                    <td>{{ $movimiento_cuenta_gastos->Fecha }}</td>
                    <td>{{ $movimiento_cuenta_gastos->FechaPago }}</td>
                    <td>{{ $movimiento_cuenta_gastos->Descripcion }}</td>
                    <td>{{ $movimiento_cuenta_gastos->cuenta->Nombre }}</td>
                    <td>{{ number_format($movimiento_cuenta_gastos->Importe, 2, '.', '') }}</td>                      
                </tr>
            @empty
                <tr><td colspan="6">No se encontraron resultados.</td></tr>
            @endforelse
        </x-slot>
        <x-slot name="foot_tr">
            <tr>
                <th>Opciones</th>
                <th>Fecha Devengado</th>
                <th>Fecha Pago</th>
                <th>Descripción</th>
                <th>Cuenta</th>
                <th>Importe</th>
            </tr>
        </x-slot>
    </x-data-table>
</div>