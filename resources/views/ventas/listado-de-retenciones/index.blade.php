<x-layout>
    <x-slot name="title">Ventas</x-slot>
    <x-slot name="breadcrumbs">
        <li class="nav-home">
            <a href="#"><i class="fas fa-dollar-sign"></i></a>
        </li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="#">Listado de Retenciones</a></li>
    </x-slot>

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
                            <x-slot name="name"></x-slot>
                            <x-slot name="value">{{now()}}</x-slot>
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
                                <option value="">Todas las retenciones</option>
                            </x-slot>
                            <x-slot name="message"></x-slot>
                            <x-slot name="error"></x-slot>
                        </x-form-input-select-livewire>

                    </div>
                    
                </div>
            </div>
        </div>
    </div>

    <x-data-table-no-plus>
      
        <x-slot name="table_title">Clientes</x-slot>
        <x-slot name="export_route">{{ route('clients.export') }}</x-slot>
        <x-slot name="head_tr">
            <tr>
                <th>Fecha Emisión</th>
                <th>Cod. Cliente</th>
                <th>Razón Social</th>
                <th>DREI</th>
                <th>IIBB</th>
                <th>IVA</th>
                <th>Ganancias</th>
                <th>SUSS</th>
            </tr>
        </x-slot>
        <x-slot name="body_tr">
    
            @forelse ($recibos_venta as $recibo_venta)
                <tr>
                    <td>{{ $recibo_venta->FechaEmision }}</td>
                    <td>{{ $recibo_venta->IdCliente }}</td>
                    <td>{{ $recibo_venta->RazonSocial }}</td>
                    <td>{{ number_format($recibo_venta->RetencionDREI, 2, '.', '') }}</td>
                    <td>{{ number_format($recibo_venta->RetencionIIBB, 2, '.', '') }}</td>
                    <td>{{ number_format($recibo_venta->RetencionIVA, 2, '.', '') }}</td>
                    <td>{{ number_format($recibo_venta->RetencionGanancias, 2, '.', '') }}</td>
                    <td>{{ number_format($recibo_venta->RetencionSUSS, 2, '.', '') }}</td>
                </tr>
            @empty
                <tr><td colspan="11">No se encontraron resultados.</td></tr>
            @endforelse
        </x-slot>
        <x-slot name="foot_tr">
            <tr>
                <th>Fecha Emisión</th>
                <th>Cod. Cliente</th>
                <th>Razón Social</th>
                <th>DREI</th>
                <th>IIBB</th>
                <th>IVA</th>
                <th>Ganancias</th>
                <th>SUSS</th>
            </tr>
        </x-slot>
    </x-data-table-no-plus>

</x-layout>