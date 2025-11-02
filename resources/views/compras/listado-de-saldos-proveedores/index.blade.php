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

<div>

    <x-layout2>
        <x-slot name="title">Listado de saldos de proveedores</x-slot>
        
        <x-simple-table2>
            <x-slot name="filtros">
                <div class="row">
                    <div class="col-2">
                        <label>LISTA DESDE</label>
                        <input type="text" class="form-control form-control-sm" wire:model.live="lista_desde" placeholder="Desde letra...">
                    </div>
                    <div class="col-2">
                        <label>LISTA HASTA</label>
                        <input type="text" class="form-control form-control-sm" wire:model.live="lista_hasta" placeholder="Hasta letra...">
                    </div>
                    <div class="col-2">
                        <label>HASTA FECHA</label>
                        <input type="date" class="form-control form-control-sm" wire:model.live="hasta_fecha">
                    </div>
                    <div class="col-2 mt-4">
                        <div class="form-check">
                            <input id="saldo0" type="checkbox" class="form-check-input" wire:model.live="incluir_saldos">
                            <label for="saldo0" class="form-check-label">INCLUIR SALDOS EN 0</label>
                        </div>
                    </div>
                </div>

            </div>
            </x-slot>
            <x-slot name="thead">
                <tr>
                    <th>CODIGO</th>
                    <th>NOMBRE</th>
                    <th>CUIT</th>
                    <th>CUENTA GASTOS</th>
                    <th>FECHA FACTURA PENDIENTE</th>
                    <th>FECHA VENC.</th>
                    <th>SALDO</th>
                </tr>
            </x-slot>
            <x-slot name="tbody">

                {{-- @forelse ($clientes as $cliente)
                    <tr wire:click="seleccionarCliente({{ $cliente->id }})" 
                        class="{{ $clienteSeleccionado == $cliente->id ? 'table-primary' : '' }}" style="cursor: pointer;">
                        <td><input type="checkbox" name="cliente_seleccionado" value=""></td>
                        <td>{{ $cliente->id }}</td>
                        <td>{{ $cliente->Nombre }}</td>
                        <td>{{ $cliente->NroDocumento }}</td>
                        <td>{{ $cliente->factura_atrasada_emision ? \Carbon\Carbon::parse($cliente->factura_atrasada_emision)->format('j/n/Y') : '' }}</td>
                        <td class="text-red">{{ $cliente->factura_atrasada_vencimiento ? \Carbon\Carbon::parse($cliente->factura_atrasada_vencimiento)->format('j/n/Y') : '' }}</td>
                        <td>{{ number_format($cliente->saldo, 2, '.', '') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="7">No se encontraron resultados.</td></tr>
                @endforelse --}}

            </x-slot>
        </x-simple-table2>

        <div class="d-flex justify-content-end mr-3">
            {{-- <a class="btn btn-app bg-primary" 
            href="{{ $clienteSeleccionado ? route('ventas.resumen-cuenta-corriente', $clienteSeleccionado) : '#' }}">
                <i class="fas fa-share"></i> Resumen Cta Cte
            </a>
            <a class="btn btn-app bg-primary disabled">
                <i class="fas fa-share"></i> Enviar Resumen
            </a>
            <a class="btn btn-app bg-primary" 
            href="{{ $clienteSeleccionado ? route('ventas.ficha-del-cliente-recibo-venta.create', $clienteSeleccionado) : '#' }}">
                <i class="fas fa-plus"></i> Nuevo Recibo
            </a>
            <a class="btn btn-app bg-primary disabled">
                <i class="fas fa-print"></i> Imprimir
            </a> --}}
        </div>

    </x-layout2>
</div>
