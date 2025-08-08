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
                    <x-form-input-default>
                        <x-slot name="label">Desde Fecha Emisión</x-slot>
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
                        <x-slot name="label">Desde Fecha Emisión</x-slot>
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
            
                <x-slot name="table_title">Listado de Cheques a Clientes</x-slot>
                <x-slot name="export_route">{{ route('clients.export') }}</x-slot>
                <x-slot name="head_tr">
                    <tr>
                        <th></th>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>CUIT</th>
                        <th>Fecha Factura Pendiente</th>
                        <th>Fecha Venc.</th>
                        <th>Saldo</th>
                    </tr>
                </x-slot>
                <x-slot name="body_tr">
            
                    @forelse ($clientes as $cliente)
                        <tr>
                            <td><input type="checkbox" name="" id=""></td>
                            <td>{{ $cliente->id }}</td>
                            <td>{{ $cliente->Nombre }}</td>
                            <td>{{ $cliente->NroDocumento }}</td>
                            <td></td>
                            <td></td>
                            <td>{{ number_format($cliente->Saldo, 2, '.', '') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="11">No se encontraron resultados.</td></tr>
                    @endforelse
                </x-slot>
                <x-slot name="foot_tr">
                    <tr>
                        <th></th>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>CUIT</th>
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
                        <x-slot name="text">Enviar Resumen</x-slot>
                        <x-slot name="color">success</x-slot>
                        <x-slot name="href">{{ route('index') }}</x-slot>
                    </x-button>
                    <x-button>
                        <x-slot name="text">Nuevo Recibo</x-slot>
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

</x-layout>