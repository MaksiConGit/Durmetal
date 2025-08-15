<div>
    {{-- Filtros --}}
    <div class="card">
        <div class="card-header">
            <div class="card-title">Filtros</div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="d-flex flex-wrap gap-2">
                    <div class="col-md-2">
                        <x-form-input-date-livewire>
                            <x-slot name="label">Desde</x-slot>
                            <x-slot name="livewire">wire:model.live="fecha_inicio"</x-slot>
                            <x-slot name="name"></x-slot>
                            <x-slot name="value"></x-slot>
                            <x-slot name="message"></x-slot>
                            <x-slot name="error"></x-slot>
                        </x-form-input-date-livewire>
                    </div>

                    <div class="col-md-2">
                        <x-form-input-date-livewire>
                            <x-slot name="label">Hasta</x-slot>
                            <x-slot name="livewire">wire:model.live="fecha_fin"</x-slot>
                            <x-slot name="value">{{ now()->format('d-m-Y') }}</x-slot>
                            <x-slot name="name"></x-slot>
                            <x-slot name="message"></x-slot>
                            <x-slot name="error"></x-slot>
                        </x-form-input-date-livewire>
                    </div>

                    <div class="col-md-3">
                        <x-form-input-select-livewire>
                            <x-slot name="label">Retención</x-slot>
                            <x-slot name="livewire">wire:model.live="retencion_id"</x-slot>
                            <x-slot name="name">retencion_id</x-slot>
                            <x-slot name="option">
                                <option value="1">Todas las retenciones</option>
                                <option value="2">DREI</option>
                                <option value="3">GANANCIAS</option>
                                <option value="4">IIBB</option>
                                <option value="5">IVA</option>
                                <option value="6">SUSS</option>
                            </x-slot>
                            <x-slot name="message"></x-slot>
                            <x-slot name="error"></x-slot>
                        </x-form-input-select-livewire>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- Tabla --}}
    <x-data-table-no-plus>
        <x-slot name="table_title">Clientes</x-slot>
        <x-slot name="export_route">{{ route('clients.export') }}</x-slot>

        {{-- Encabezado --}}
        <x-slot name="head_tr">
            <tr>
                <th>Fecha Emisión</th>
                <th>Cod. Cliente</th>
                <th>Razón Social</th>
                @if($retencion_id == 1 || $retencion_id == 2) <th>DREI</th> @endif
                @if($retencion_id == 1 || $retencion_id == 3) <th>GANANCIAS</th> @endif
                @if($retencion_id == 1 || $retencion_id == 4) <th>IIBB</th> @endif
                @if($retencion_id == 1 || $retencion_id == 5) <th>IVA</th> @endif
                @if($retencion_id == 1 || $retencion_id == 6) <th>SUSS</th> @endif
            </tr>
        </x-slot>

        {{-- Cuerpo --}}
        <x-slot name="body_tr">
            @forelse ($recibos_venta as $recibo)
                <tr>
                    <td>{{ $recibo->FechaEmision }}</td>
                    <td>{{ $recibo->IdCliente }}</td>
                    <td>{{ $recibo->RazonSocial }}</td>

                    @if($retencion_id == 1 || $retencion_id == 2)
                        <td>{{ number_format($recibo->RetencionDREI, 2, '.', '') }}</td>
                    @endif

                    @if($retencion_id == 1 || $retencion_id == 3)
                        <td>{{ number_format($recibo->RetencionGanancias, 2, '.', '') }}</td>
                    @endif

                    @if($retencion_id == 1 || $retencion_id == 4)
                        <td>{{ number_format($recibo->RetencionIIBB, 2, '.', '') }}</td>
                    @endif

                    @if($retencion_id == 1 || $retencion_id == 5)
                        <td>{{ number_format($recibo->RetencionIVA, 2, '.', '') }}</td>
                    @endif

                    @if($retencion_id == 1 || $retencion_id == 6)
                        <td>{{ number_format($recibo->RetencionSUSS, 2, '.', '') }}</td>
                    @endif
                </tr>
            @empty
                <tr><td colspan="8">No se encontraron resultados.</td></tr>
            @endforelse
        </x-slot>

        {{-- Pie --}}
        <x-slot name="foot_tr">
            <tr>
                <th>Fecha Emisión</th>
                <th>Cod. Cliente</th>
                <th>Razón Social</th>
                @if($retencion_id == 1 || $retencion_id == 2) <th>DREI</th> @endif
                @if($retencion_id == 1 || $retencion_id == 3) <th>GANANCIAS</th> @endif
                @if($retencion_id == 1 || $retencion_id == 4) <th>IIBB</th> @endif
                @if($retencion_id == 1 || $retencion_id == 5) <th>IVA</th> @endif
                @if($retencion_id == 1 || $retencion_id == 6) <th>SUSS</th> @endif
            </tr>
        </x-slot>
    </x-data-table-no-plus>
</div>
