{{-- <x-layout>
    <x-slot name="title">Compras</x-slot>
    <x-slot name="breadcrumbs">
        <li class="nav-home">
            <a href="#"><i class="fas fa-money-bill-wave"></i></a>
        </li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="#">Listado de movimientos por cuentas de gastos</a></li>
    </x-slot>

    <div class="card">

        <div class="card-header">
            <div class="card-title">Filtros</div>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <x-form-input-date>
                        <x-slot name="label">Fecha Desde</x-slot>
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
                        <x-slot name="label">Fecha Hasta</x-slot>
                        <x-slot name="livewire">wire:model.live="cliente_hasta"</x-slot>
                        <x-slot name="name">cliente_hasta</x-slot>
                        <x-slot name="placeholder"></x-slot>
                        <x-slot name="value"></x-slot>
                        <x-slot name="message"></x-slot>
                        <x-slot name="error"></x-slot>
                    </x-form-input-date>
                </div>

                <div class="col-md-4">
                    <x-form-input-select-livewire>
                        <x-slot name="label">Filtros</x-slot>
                        <x-slot name="livewire">wire:model.live=""</x-slot>
                        <x-slot name="name"></x-slot>
                        <x-slot name="option">
                            <option value="">Todas</option>
                            @foreach ($cuentas_de_gastos as $cuenta_de_gastos)
                                <option value="{{ $cuenta_de_gastos->id }}">{{ $cuenta_de_gastos->Nombre }}</option>
                            @endforeach
                        </x-slot>
                        <x-slot name="message"></x-slot>
                        <x-slot name="error"></x-slot>
                    </x-form-input-select-livewire>
                </div>
            </div>
        </div>
    </div>

    <x-card>
        <x-slot name="card_title">Listado de Documentos</x-slot>
        <x-slot name="body">
            <x-data-table-no-plus>
                <x-slot name="table_title">Listado de Documentos</x-slot>
                <x-slot name="export_route"></x-slot>
                <x-slot name="head_tr">
                    <tr>
                        <th>Opciones</th>
                        <th>Fecha</th>
                        <th>N° Comprobante</th>
                        <th>Proveedor</th>
                        <th>Cuenta</th>
                        <th>Exento</th>
                        <th>Item Nro</th>
                        <th>No Gravado</th>
                        <th>Monotributo</th>
                        <th>Neto</th>
                        <th>IVA</th>
                        <th>Percepciones</th>
                        <th>Percepcion IVA</th>
                        <th>Gastos Neto IVA</th>
                        <th>Total</th>
                    </tr>
                </x-slot>

                <x-slot name="body_tr">

                    @foreach ($facturas_compra as $factura_compra)

                        @foreach ($factura_compra->items as $item)

                            <tr>
                                <td class="text-center align-middle">
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                    <a
                                        href="{{ route('compras.actualizaciones.proveedores.edit', $factura_compra) }}"
                                        class="btn btn-link btn-primary p-0"
                                        data-bs-toggle="tooltip"
                                        title="Editar factura compra"
                                    >
                                        <i class="fa fa-edit fa-lg"></i>
                                    </a>
                                    </div>
                                </td>
                                <td>{{ $factura_compra->FechaEmision }}</td>
                                <td>{{ $factura_compra->NumeroCompleto }}</td>
                                <td>{{ $factura_compra->proveedor->Nombre }}</td>
                                <td>{{ $item->cuentaGastos->Nombre }}</td>
                                <td>{{ number_format(0, 2, '.', '') }}</td>
                                <td>{{ number_format(0, 2, '.', '') }}</td>
                                <td>{{ number_format(0, 2, '.', '') }}</td>
                                <td>{{ number_format(0, 2, '.', '') }}</td>
                                <td>{{ number_format(0, 2, '.', '') }}</td>
                                <td>{{ number_format(0, 2, '.', '') }}</td>
                                <td>{{ number_format(0, 2, '.', '') }}</td>
                                <td>{{ number_format(0, 2, '.', '') }}</td>
                                <td>{{ number_format(0, 2, '.', '') }}</td>
                                <td>{{ number_format(0, 2, '.', '') }}</td>
                            </tr>
                            
                        @endforeach

                    @endforeach

                    @foreach ($notas_credito_compra as $nota_credito_compra)

                        @foreach ($nota_credito_compra->items as $item)

                            <tr>
                                <td class="text-center align-middle">
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                    <a
                                        href="{{ route('compras.actualizaciones.proveedores.edit', $nota_credito_compra) }}"
                                        class="btn btn-link btn-primary p-0"
                                        data-bs-toggle="tooltip"
                                        title="Editar nota crédito compra"
                                    >
                                        <i class="fa fa-edit fa-lg"></i>
                                    </a>
                                    </div>
                                </td>
                                <td>{{ $nota_credito_compra->FechaEmision }}</td>
                                <td>{{ $nota_credito_compra->NumeroCompleto }}</td>
                                <td>{{ $nota_credito_compra->proveedor->Nombre }}</td>
                                <td>{{ $item->cuentaGastos->Nombre }}</td>
                                <td>{{ number_format(0, 2, '.', '') }}</td>
                                <td>{{ number_format(0, 2, '.', '') }}</td>
                                <td>{{ number_format(0, 2, '.', '') }}</td>
                                <td>{{ number_format(0, 2, '.', '') }}</td>
                                <td>{{ number_format(0, 2, '.', '') }}</td>
                                <td>{{ number_format(0, 2, '.', '') }}</td>
                                <td>{{ number_format(0, 2, '.', '') }}</td>
                                <td>{{ number_format(0, 2, '.', '') }}</td>
                                <td>{{ number_format(0, 2, '.', '') }}</td>
                                <td>{{ number_format(0, 2, '.', '') }}</td>
                            </tr>
                            
                        @endforeach

                    @endforeach

                </x-slot>

                <x-slot name="foot_tr">
                    <tr>
                        <th>Opciones</th>
                        <th>Fecha</th>
                        <th>N° Comprobante</th>
                        <th>Proveedor</th>
                        <th>Cuenta</th>
                        <th>Exento</th>
                        <th>Item Nro</th>
                        <th>No Gravado</th>
                        <th>Monotributo</th>
                        <th>Neto</th>
                        <th>IVA</th>
                        <th>Percepciones</th>
                        <th>Percepcion IVA</th>
                        <th>Gastos Neto IVA</th>
                        <th>Total</th>
                    </tr>
                </x-slot>
            </x-data-table-no-plus>
        </x-slot>

        <x-slot name="buttons">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex gap-2">
                    <x-button>
                        <x-slot name="text">Abrir</x-slot>
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
    <x-slot name="title">Listado de movimientos por cuentas de gastos</x-slot>
    
    <x-simple-table2>
        <x-slot name="filtros">
            <div class="row">
            <div class="col-2">
                <div class="form-group mb-0">
                    <label for="filtro1" class="font-weight-normal">FECHA DESDE</label>
                    <input type="date" id="filtro1" name="filtro1" wire:model.live="cliente_desde" class="form-control form-control-sm" placeholder="Buscar...">
                </div>
            </div>

            <div class="col-2">
                <div class="form-group mb-0">
                    <label for="filtro1" class="font-weight-normal">FECHA HASTA</label>
                    <input type="date" id="filtro1" name="filtro1" wire:model.live="cliente_hasta" class="form-control form-control-sm" placeholder="Buscar...">
                </div>
            </div>

            <div class="col-4">
                <div class="form-group mb-0">
                    <label for="filtro1" class="font-weight-normal">CUENTA DE GASTOS</label>
                    <select name="" id="" wire:model.live="filtro" class="form-control form-control-sm">
                        <option value="">Todas</option>
                        @foreach ($cuentas_de_gastos as $cuenta_de_gastos)
                            <option value="{{ $cuenta_de_gastos->id }}">{{ $cuenta_de_gastos->Nombre }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            </div>
        </div>
        </x-slot>
        <x-slot name="thead">
            <tr>
                <th>FECHA</th>
                <th>N° COMPROBANTE</th>
                <th>PROVEEDOR</th>
                <th>CUENTA</th>
                <th>EXENTO</th>
                <th>ITEM NRO</th>
                <th>NO GRAVADO</th>
                <th>MONOTRIBUTO</th>
                <th>NETO</th>
                <th>IVA</th>
                <th>PERCEPCIONES</th>
                <th>PERCEPCION IVA</th>
                <th>GASTOS NETO IVA</th>
                <th>TOTAL</th>
            </tr>
        </x-slot>
        <x-slot name="tbody">
            {{-- @forelse ($clientes as $cliente)
                <tr style="cursor: pointer;" 
                    onclick="window.location='{{ match($filtro) {
                        'trabajos_pendientes_nota_envio' => route('ventas.ficha-del-cliente-nota-envio.create', $cliente),
                        'notas_pendientes' => route('ventas.ficha-del-cliente-factura-venta.create', $cliente),
                        'facturas_pendientes' => route('ventas.ficha-del-cliente-recibo-venta.create', $cliente),
                        default => route('ventas.ficha-del-cliente.show', $cliente)
                    } }}'">
                    
                    @if($filtro !== null && $filtro !== '')
                        <td>
                            @switch($filtro)
                                @case('notas_pendientes')
                                    {{ $cliente->notas_envio_pendientes_count }}
                                    @break
                                @case('facturas_pendientes')
                                    {{ $cliente->facturas_pendientes_count }}
                                    @break
                                @case('trabajos_pendientes_nota_envio')
                                    {{ $cliente->ordenes_trabajo_pendientes_count  }}
                                    @break
                            @endswitch
                        </td>
                    @endif

                    <td>{{ $cliente->id }}</td>
                    <td>{{ $cliente->Nombre }}</td>
                    <td>{{ $cliente->NroDocumento }}</td>
                    <td>{{ $cliente->Domicilio }}</td>
                    <td>{{ $cliente->localidad->Nombre ?? '-' }}</td>
                    <td>{{ $cliente->localidad->provincia->Nombre ?? '-' }}</td>
                    <td>{{ $cliente->condicionIVA->Nombre ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="9">No se encontraron resultados.</td>
                </tr>
            @endforelse --}}
        </x-slot>
    </x-simple-table2>

</x-layout2>