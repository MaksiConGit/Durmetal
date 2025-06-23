<div>

    <div class="card">
        <div class="card-header">
            <div class="card-title">Filtros</div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="d-flex flex-wrap gap-2">
                    <div class="col-md-3">

                        <x-form-input-date-livewire>
                            <x-slot name="label">Desde</x-slot>
                            <x-slot name="livewire">wire:model.live="fecha_inicio"</x-slot>
                            <x-slot name="name"></x-slot>
                            <x-slot name="value"></x-slot>
                            <x-slot name="message"></x-slot>
                            <x-slot name="error"></x-slot>
                        </x-form-input-date-livewire>

                    </div>
                    <div class="col-md-3">

                        <x-form-input-date-livewire>
                            <x-slot name="label">Hasta</x-slot>
                            <x-slot name="livewire">wire:model.live="fecha_fin"</x-slot>
                            <x-slot name="name"></x-slot>
                            <x-slot name="value">{{now()}}</x-slot>
                            <x-slot name="message"></x-slot>
                            <x-slot name="error"></x-slot>
                        </x-form-input-date-livewire>

                    </div>
                    
                </div>
            </div>
        </div>

    </div>

    <x-data-table-no-plus-buttons>
      
        <x-slot name="table_title">Items Órden Trabajo</x-slot>
        <x-slot name="export_route">{{ route('clients.export') }}</x-slot>
        <x-slot name="head_tr">
            <tr>
                <th>Fecha</th>
                <th>OTI</th>
                <th>Cli.</th>
                <th>Trat.</th>
                <th>Material</th>
                <th>Descripción</th>
                <th>Cant.</th>
                <th>Peso</th>
                <th>CC</th>
                <th>Coeficiente</th>
                <th>Subtotal</th>
            </tr>
        </x-slot>
        <x-slot name="body_tr">
            @php $total_acumulado = 0; @endphp
            @forelse ($items_orden_trabajo as $item)
                @php
                    $coef = $item->codigoComplejidad->Coeficiente ?? 0;
                    $subtotal = $coef * $item->Peso;
                    $total_acumulado += $subtotal;
                @endphp
                <tr class="border-t">
                    <td>{{ $item->ordenTrabajo->FechaEmision }}</td>
                    <td>{{ $item->ItemNumero }} / {{ $item->ordenTrabajo->Numero }}</td>
                    <td>[{{ $item->ordenTrabajo->cliente->id }}] {{ $item->ordenTrabajo->cliente->Nombre }}</td>
                    <td>{{ $item->tratamiento->Nombre }}</td>
                    <td>{{ $item->material->Nombre }}</td>
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
        </x-slot>
        <x-slot name="foot_tr">
            <tr>
                <th>Fecha</th>
                <th>OTI</th>
                <th>Cli.</th>
                <th>Trat.</th>
                <th>Material</th>
                <th>Descripción</th>
                <th>Cant.</th>
                <th>Peso</th>
                <th>CC</th>
                <th>Coeficiente</th>
                <th>Subtotal</th>
            </tr>
        </x-slot>

        <x-slot name="buttons">
            <div class="row mb-3">
                <div class="col-md-9"></div>

                <div class="col-md-3 text-end">
                    <x-form-input-disabled>
                        <x-slot name="label">Total</x-slot>
                        <x-slot name="name"></x-slot>
                        <x-slot name="placeholder"></x-slot>
                        <x-slot name="value">{{ number_format($total_acumulado, 2, '.', '') }}</x-slot>
                        <x-slot name="message"></x-slot>
                        <x-slot name="error"></x-slot>
                    </x-form-input-disabled>
                </div>
            </div>

            <div class="row">
                <div class="col text-end">
                    <x-button>
                        <x-slot name="text">Cancelar</x-slot>
                        <x-slot name="color">danger</x-slot>
                        <x-slot name="href">{{ route('index') }}</x-slot>
                    </x-button>
                </div>
            </div>
        </x-slot>

    </x-data-table-no-plus-buttons>

</div>