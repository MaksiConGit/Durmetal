{{-- <x-layout>
    <x-slot name="title">Compras</x-slot>
    <x-slot name="breadcrumbs">
        <li class="nav-home">
            <a href="#"><i class="fas fa-money-bill-wave"></i></a>
        </li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="#">Listado de saldos de proveedores</a></li>
    </x-slot>

    <div class="card">
        <div class="card-header">
            <div class="card-title">Filtros</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <x-form-input-default>
                        <x-slot name="label">Lista Desde</x-slot>
                        <x-slot name="livewire">wire:model.live="cliente_desde"</x-slot>
                        <x-slot name="name"></x-slot>
                        <x-slot name="placeholder"></x-slot>
                        <x-slot name="value"></x-slot>
                        <x-slot name="message"></x-slot>
                        <x-slot name="error"></x-slot>
                    </x-form-input-default>
                </div>
                
                <div class="col-md-3">
                    <x-form-input-default>
                        <x-slot name="label">Lista Hasta</x-slot>
                        <x-slot name="livewire">wire:model.live="cliente_desde"</x-slot>
                        <x-slot name="name"></x-slot>
                        <x-slot name="placeholder"></x-slot>
                        <x-slot name="value"></x-slot>
                        <x-slot name="message"></x-slot>
                        <x-slot name="error"></x-slot>
                    </x-form-input-default>
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

                <div class="col-md-3">
                    <label for="saldo">Incluir saldos en 0</label>
                    <input type="checkbox" name="" id="saldo">
                </div>
            </div>
        </div>

    </div>

    <x-card>
        <x-slot name="card_title">Editar Carga</x-slot>
        <x-slot name="body">

            <x-data-table-no-plus>
            
                <x-slot name="table_title">Listado de Saldos de Proveedores</x-slot>
                <x-slot name="export_route">{{ route('clients.export') }}</x-slot>
                <x-slot name="head_tr">
                    <tr>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>CUIT</th>
                        <th>Cuenta Gastos</th>
                        <th>Fecha Factura Pendiente</th>
                        <th>Fecha Venc.</th>
                        <th>Saldo</th>
                    </tr>
                </x-slot>
                <x-slot name="body_tr">
            
                    @forelse ($proveedores as $proveedor)
                        <tr>
                            <td>{{ $proveedor->id }}</td>
                            <td>{{ $proveedor->Nombre }}</td>
                            <td>{{ $proveedor->NumeroDocumento }}</td>
                            <td>{{ $proveedor->cuentaGastos->Nombre }}</td>
                            <td>{{ $proveedor->factura_atrasada_emision }}</td>
                            <td>{{ $proveedor->factura_atrasada_vencimiento }}</td>
                            <td>{{ number_format($proveedor->saldo, 2, '.', '') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="7">No se encontraron resultados.</td></tr>
                    @endforelse
                    <tr>
                        <td><strong>Total</strong></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><strong>{{ number_format($total_general, 2, '.', '') }}</strong></td>
                    </tr>
                </x-slot>
                <x-slot name="foot_tr">
                    <tr>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>CUIT</th>
                        <th>Cuenta Gastos</th>
                        <th>Fecha Factura Pendiente</th>
                        <th>Fecha Venc.</th>
                        <th>Saldo</th>
                    </tr>
                </x-slot>
            </x-data-table-no-plus>
        </x-slot>

        <x-slot name="buttons">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex gap-2">
                    <x-button>
                        <x-slot name="text">Resumen Cta Cte</x-slot>
                        <x-slot name="color">success</x-slot>
                        <x-slot name="href">{{ route('index') }}</x-slot>
                    </x-button>
                    <x-button>
                        <x-slot name="text">Nueva OP</x-slot>
                        <x-slot name="color">success</x-slot>
                        <x-slot name="href">{{ route('index') }}</x-slot>
                    </x-button>
                    <x-button>
                        <x-slot name="text">Imprimir</x-slot>
                        <x-slot name="color">success</x-slot>
                        <x-slot name="href">{{ route('index') }}</x-slot>
                    </x-button>
                    <x-button>
                        <x-slot name="text">Salir</x-slot>
                        <x-slot name="color">danger</x-slot>
                        <x-slot name="href">{{ route('index') }}</x-slot>
                    </x-button>
                </div>
            </div>
        </x-slot>

    </x-card>

</x-layout> --}}

@livewire('listado-saldo-proveedores2')