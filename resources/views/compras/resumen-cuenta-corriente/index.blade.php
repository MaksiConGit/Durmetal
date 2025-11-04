{{-- <x-layout>
    <x-slot name="title">Compras</x-slot>
    <x-slot name="breadcrumbs">
        <li class="nav-home">
            <a href="#"><i class="fas fa-money-bill-wave"></i></a>
        </li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="#">Resumen de cuenta corriente proveedor</a></li>
    </x-slot>

    <div class="card">

        <div class="card-header">
            <div class="card-title">Filtros</div>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="d-flex flex-wrap gap-2">

                    <div class="col-md-2">

                        <x-form-input-default-livewire>
                            <x-slot name="label">Cod. Cliente</x-slot>
                            <x-slot name="livewire">wire:model.live="cliente_id"</x-slot>
                            <x-slot name="name">cliente_id</x-slot>
                            <x-slot name="placeholder"></x-slot>
                            <x-slot name="value"></x-slot>
                            <x-slot name="message"></x-slot>
                            <x-slot name="error"></x-slot>
                        </x-form-input-default-livewire>

                    </div>

                    <div class="col-md-4">

                        <x-form-input-select-livewire>
                            <x-slot name="label">Nombre</x-slot>
                            <x-slot name="livewire">wire:model.live="cliente_id"</x-slot>
                            <x-slot name="name">cliente_id</x-slot>
                            <x-slot name="option">
                                <option value="">-- Todos los clientes --</option>
                                @foreach ($proveedores as $proveedor)
                                    <option value="{{ $proveedor->id }}">{{ $proveedor->Nombre }}</option>
                                @endforeach
                            </x-slot>
                            <x-slot name="message"></x-slot>
                            <x-slot name="error"></x-slot>
                        </x-form-input-select-livewire>
                        
                    </div>
                    
                    <div class="align-self-end">
                        <div class="form-group">
                            <a href="" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalToggle">Buscar</a>
                        </div>
                    </div>

                    <x-modal-table>
                        <x-slot name="title">Buscar Cliente</x-slot>
                        <x-slot name="body">

                            <div class="table-responsive" style="max-height: 60vh; overflow-y: auto;">

                                <x-data-table-no-plus-no-export>
        
                                    <x-slot name="table_title">Clientes</x-slot>
                                    <x-slot name="export_route">{{ route('clients.export') }}</x-slot>
                                    <x-slot name="create_route">{{ route('clients.create') }}</x-slot>
                                    <x-slot name="add_text">Añadir cliente</x-slot>
                                    <x-slot name="head_tr">
                                        <tr>
                                            <th>Código</th>
                                            <th>Nombre</th>
                                            <th>Tipo de Documento</th>
                                            <th>Número</th>
                                            <th>Domicilio</th>
                                            <th>Localidad</th>
                                            <th>Provincia</th>
                                            <th>Activo</th>
                                        </tr>
                                    </x-slot>
                                    <x-slot name="body_tr">
                                
                                        @foreach ($proveedores as $proveedor)
                                            <tr style="cursor: pointer;" wire:click="$set('cliente_id', {{ $proveedor->id }})" data-bs-dismiss="modal">
                                                <td>{{ $proveedor->id }}</td>
                                                <td>{{ $proveedor->Nombre }}</td>
                                                <td>{{ $proveedor->TipoDocumento }}</td>
                                                <td>{{ $proveedor->Telefono }}</td>
                                                <td>{{ $proveedor->Domicilio }}</td>
                                                <td>{{ $proveedor->localidad->Nombre ?? 'Ciudad no asignada' }}</td>
                                                <td>{{ $proveedor->localidad->provincia->Nombre ?? 'Provincia no asignada' }}</td>
                                                <td>
                                                    <input type="checkbox" name="" id="" disabled {{ $proveedor->Activo == 1 ? 'checked' : '' }}>
                                                </td>
                                            </tr>
                                        @endforeach

                                    </x-slot>
                                    <x-slot name="foot_tr">
                                        <tr>
                                            <th>Código</th>
                                            <th>Nombre</th>
                                            <th>Tipo de Documento</th>
                                            <th>Número</th>
                                            <th>Domicilio</th>
                                            <th>Localidad</th>
                                            <th>Provincia</th>
                                            <th>Activo</th>
                                        </tr>
                                    </x-slot>
                                </x-data-table-no-plus-no-export>

                            </div>

                        </x-slot>
                        <x-slot name="primary_text">Aceptar</x-slot>
                        <x-slot name="secondary_text">Volver</x-slot>
                    </x-modal-table>
                
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <x-form-input-date>
                        <x-slot name="label">Desde Fecha</x-slot>
                        <x-slot name="livewire">wire:model.live="cliente_desde"</x-slot>
                        <x-slot name="name">cliente_desde</x-slot>
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
                        <x-slot name="name">cliente_hasta</x-slot>
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
        <x-slot name="card_title">Listado de Cheques</x-slot>
        <x-slot name="body">
            <x-data-table-no-plus>
                <x-slot name="table_title">Listado de Cheques a Clientes</x-slot>
                <x-slot name="export_route"></x-slot>
                <x-slot name="head_tr">
                    <tr>
                        <th>Fecha</th>
                        <th>Fecha Venc.</th>
                        <th>Conceptos</th>
                        <th>Debe</th>
                        <th>Haber</th>
                        <th>Saldo</th>
                    </tr>
                </x-slot>

                <x-slot name="body_tr">
                    @if($proveedor)
                        @php
                            $saldo = $proveedor->SaldoSistemaAnterior;
                        @endphp

                        <tr>
                            <td></td>
                            <td></td>
                            <td>Saldo Anterior</td>
                            <td>{{ number_format($proveedor->SaldoSistemaAnterior, 2, '.', '') }}</td>
                            <td></td>
                            <td>{{ number_format($saldo, 2, '.', '') }}</td>
                        </tr>

                        @foreach ($documentos as $documento)
                            @php
                                if ($documento instanceof App\Models\OrdenPago || $documento instanceof App\Models\NotaCreditoCompra) {
                                    $saldo -= $documento->Total;
                                    $debe = '';
                                    $haber = number_format($documento->Total, 2, '.', '');
                                } else {
                                    $saldo += $documento->Total;
                                    $debe = number_format($documento->Total, 2, '.', '');
                                    $haber = '';
                                }
                            @endphp

                            <tr>
                                <td>{{ $documento->FechaEmision }}</td>
                                <td>{{ $documento->FechaVencimiento ?? '' }}</td>
                                <td>{{ $documento->NumeroCompleto ?? '' }}</td>
                                <td>{{ $debe }}</td>
                                <td>{{ $haber }}</td>
                                <td>{{ number_format($saldo, 2, '.', '') }}</td>
                            </tr>
                        @endforeach


                        <tr>
                            <td></td>
                            <td></td>
                            <td><strong>Total Saldo</strong></td>
                            <td></td>
                            <td></td>
                            <td><strong>{{ number_format($saldo, 2, '.', '') }}</strong></td>
                        </tr>
                    @endif
                </x-slot>

                <x-slot name="foot_tr">
                    <tr>
                        <th>Fecha</th>
                        <th>Fecha Venc.</th>
                        <th>Conceptos</th>
                        <th>Debe</th>
                        <th>Haber</th>
                        <th>Saldo</th>
                    </tr>
                </x-slot>
            </x-data-table-no-plus>
        </x-slot>

        <x-slot name="buttons">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex gap-2">
                    <x-button>
                        <x-slot name="text">Imprimir</x-slot>
                        <x-slot name="color">success</x-slot>
                        <x-slot name="href"></x-slot>
                    </x-button>
                    <x-button>
                        <x-slot name="text">Enviar</x-slot>
                        <x-slot name="color">success</x-slot>
                        <x-slot name="href"></x-slot>
                    </x-button>
                    <x-button>
                        <x-slot name="text">Salir</x-slot>
                        <x-slot name="color">danger</x-slot>
                        <x-slot name="href"></x-slot>
                    </x-button>
                </div>
            </div>
        </x-slot>
    </x-card>

</x-layout> --}}

<x-layout2>
    <x-slot name="title">Resumen de cuenta corriente proveedor</x-slot>

    @livewire('resumen-cuenta-corriente-proveedor2')

</x-layout2>