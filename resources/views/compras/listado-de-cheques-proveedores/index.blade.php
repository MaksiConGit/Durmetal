<x-layout>
    <x-slot name="title">Compras</x-slot>
    <x-slot name="breadcrumbs">
        <li class="nav-home">
            <a href="#"><i class="fas fa-money-bill-wave"></i></a>
            </li>
            <li class="separator"><i class="icon-arrow-right"></i></li>
            <li class="nav-item"><a href="#">Listado de Cheques a Proveedores</a></li>
    </x-slot>

    <div class="card">
        <div class="card-header">
            <div class="card-title">Filtros</div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <x-form-input-date-livewire>
                        <x-slot name="label">Desde Fecha Emisión</x-slot>
                        <x-slot name="livewire">wire:model.live="cliente_desde"</x-slot>
                        <x-slot name="name"></x-slot>
                        <x-slot name="value"></x-slot>
                        <x-slot name="message"></x-slot>
                        <x-slot name="error"></x-slot>
                    </x-form-input-date-livewire>
                </div>

                <div class="col-md-3">
                    <x-form-input-date-livewire>
                        <x-slot name="label">Hasta Fecha</x-slot>
                        <x-slot name="livewire">wire:model.live="cliente_hasta"</x-slot>
                        <x-slot name="name"></x-slot>
                        <x-slot name="value"></x-slot>
                        <x-slot name="message"></x-slot>
                        <x-slot name="error"></x-slot>
                    </x-form-input-date-livewire>
                </div>

                <div class="col-md-3">
                    <x-form-input-date-livewire>
                        <x-slot name="label">Acredita Desde</x-slot>
                        <x-slot name="livewire">wire:model.live="cliente_hasta"</x-slot>
                        <x-slot name="name"></x-slot>
                        <x-slot name="value"></x-slot>
                        <x-slot name="message"></x-slot>
                        <x-slot name="error"></x-slot>
                    </x-form-input-date-livewire>
                </div>
            </div>
        </div>
    </div>

    <x-card>
        <x-slot name="card_title">Listado de Cheques a Proveedores</x-slot>
        <x-slot name="body">

            <x-data-table-no-plus>
                <x-slot name="table_title">Cheques</x-slot>
                <x-slot name="export_route">{{ route('clients.export') }}</x-slot>
                <x-slot name="head_tr">
                    <tr>
                        <th>Fecha</th>
                        <th>Fecha Venc.</th>
                        <th>Banco</th>
                        <th>Número</th>
                        <th>Plaza</th>
                        <th>E-Check</th>
                        <th>Importe</th>
                        <th>Órden de Pago</th>
                        <th>Cod. Proveedor</th>
                        <th>Razón Social</th>
                    </tr>
                </x-slot>

                <x-slot name="body_tr">
                    @forelse ($cheques_pago as $cheque_pago)
                        <tr>
                            <td>{{ $cheque_pago->FechaEmision }}</td>
                            <td>{{ $cheque_pago->FechaAcreditacion }}</td>
                            <td>{{ $cheque_pago->banco->Nombre }}</td>
                            <td>{{ $cheque_pago->Numero }}</td>
                            <td>{{ $cheque_pago->Plaza }}</td>
                            <td>
                                <input type="checkbox" disabled {{ $cheque_pago->eCheck ? 'checked' : '' }}>
                            </td>
                            <td>{{ number_format($cheque_pago->pago->Total, 2, '.', '') }}</td>
                            <td>{{ $cheque_pago->pago->ordenPago->NumeroCompleto }}</td>
                            <td>{{ $cheque_pago->pago->ordenPago->IdProveedor }}</td>
                            <td>{{ $cheque_pago->pago->ordenPago->RazonSocial }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="10">No se encontraron resultados.</td></tr>
                    @endforelse
                </x-slot>

                <x-slot name="foot_tr">
                    <tr>
                        <th>Fecha</th>
                        <th>Fecha Venc.</th>
                        <th>Banco</th>
                        <th>Número</th>
                        <th>Plaza</th>
                        <th>E-Check</th>
                        <th>Importe</th>
                        <th>Órden de Pago</th>
                        <th>Cod. Proveedor</th>
                        <th>Razón Social</th>
                    </tr>
                </x-slot>
            </x-data-table-no-plus>

        </x-slot>

        <x-slot name="buttons">
            <div class="d-flex justify-content-between align-items-center">
                <x-button>
                    <x-slot name="text">Volver</x-slot>
                    <x-slot name="color">danger</x-slot>
                    <x-slot name="href">{{ route('index') }}</x-slot>
                </x-button>
            </div>
        </x-slot>
    </x-card>

</x-layout>