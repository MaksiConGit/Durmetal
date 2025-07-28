<x-layout>
    <x-slot name="title">Ventas</x-slot>
    <x-slot name="breadcrumbs">
        <li class="nav-home">
            <a href="#"><i class="fas fa-dollar-sign"></i></a>
        </li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="#">Listado de Cheques a Clientes</a></li>
    </x-slot>

    <div class="card">
        <div class="card-header">
            <div class="card-title">Filtros</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <x-form-input-date>
                        <x-slot name="label">Desde Fecha Emisión</x-slot>
                        <x-slot name="livewire">wire:model.live="cliente_desde"</x-slot>
                        <x-slot name="name"></x-slot>
                        <x-slot name="placeholder"></x-slot>
                        <x-slot name="value"></x-slot>
                        <x-slot name="message"></x-slot>
                        <x-slot name="error"></x-slot>
                    </x-form-input-date>
                </div>
                
                <div class="col-md-3">
                    <x-form-input-date>
                        <x-slot name="label">Hasta Fecha</x-slot>
                        <x-slot name="livewire">wire:model.live="cliente_hasta"</x-slot>
                        <x-slot name="name"></x-slot>
                        <x-slot name="placeholder"></x-slot>
                        <x-slot name="value"></x-slot>
                        <x-slot name="message"></x-slot>
                        <x-slot name="error"></x-slot>
                    </x-form-input-date>
                </div>
            </div>
        </div>

    </div>

    <x-card>
        <x-slot name="card_title">Editar Carga</x-slot>
        <x-slot name="body">

            <x-data-table-no-plus>
            
                <x-slot name="table_title">Listado de Cheques a Clientes</x-slot>
                <x-slot name="export_route">{{ route('clients.export') }}</x-slot>
                <x-slot name="head_tr">
                    <tr>
                        <th>Fecha Emisión</th>
                        <th>Fecha Venc.</th>
                        <th>Banco</th>
                        <th>Número</th>
                        <th>Plaza</th>
                        <th>E-Check</th>
                        <th>Importe</th>
                        <th>Recibo</th>
                        <th>Cod. Cliente</th>
                        <th>Razón Social</th>
                        <th>Destino</th>
                    </tr>
                </x-slot>
                <x-slot name="body_tr">
            
                    @forelse ($cheques_cobro as $cheque_cobro)
                        <tr>
                            <td>{{ $cheque_cobro->FechaEmision }}</td>
                            <td>{{ $cheque_cobro->FechaAcreditacion }}</td>
                            <td>{{ $cheque_cobro->banco->Nombre }}</td>
                            <td>{{ $cheque_cobro->Numero }}</td>
                            <td>{{ $cheque_cobro->Plaza }}</td>
                            <td><input type="checkbox" name="" id="" disabled {{ $cheque_cobro->eCheck == 1 ? 'checked' : '' }}></td>
                            <td>{{ number_format($cheque_cobro->cobro->Total, 2, '.', '') }}</td>
                            <td>{{ $cheque_cobro->cobro->reciboVenta->NumeroCompleto }}</td>
                            <td>{{ $cheque_cobro->cobro->reciboVenta->IdCliente }}</td>
                            <td>{{ $cheque_cobro->cobro->reciboVenta->RazonSocial }}</td>
                            <td>
                                <select name="" id="">
                                    @foreach ($destinos_cheque as $destino_cheque)
                                        <option value="{{$destino_cheque->id}}">{{$destino_cheque->Nombre}}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="11">No se encontraron resultados.</td></tr>
                    @endforelse
                </x-slot>
                <x-slot name="foot_tr">
                    <tr>
                        <th>Fecha Emisión</th>
                        <th>Fecha Venc.</th>
                        <th>Banco</th>
                        <th>Número</th>
                        <th>Plaza</th>
                        <th>E-Check</th>
                        <th>Importe</th>
                        <th>Recibo</th>
                        <th>Cod. Cliente</th>
                        <th>Razón Social</th>
                        <th>Destino</th>
                    </tr>
                </x-slot>
            </x-data-table-no-plus>
        </x-slot>

        <x-slot name="buttons">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex gap-2">
                    <x-button>
                        <x-slot name="text">Volver</x-slot>
                        <x-slot name="color">danger</x-slot>
                        <x-slot name="href">{{ route('index') }}</x-slot>
                    </x-button>
                </div>
            </div>
        </x-slot>

    </x-card>

</x-layout>