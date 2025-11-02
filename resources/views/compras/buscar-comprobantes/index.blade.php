{{-- <x-layout>
    <x-slot name="title">Compras</x-slot>
    <x-slot name="breadcrumbs">
        <li class="nav-home">
            <a href="#"><i class="fas fa-money-bill-wave"></i></a>
        </li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="#">Buscar comprobantes</a></li>
    </x-slot>

    <div class="card">
        <div class="card-header">
            <div class="card-title">Filtros</div>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="d-flex flex-wrap gap-2">

                    <div class="col-md-2">
                        <x-form-input-date>
                            <x-slot name="label">Desde Fecha</x-slot>
                            <x-slot name="livewire">wire:model.live="cliente_hasta"</x-slot>
                            <x-slot name="name"></x-slot>
                            <x-slot name="placeholder"></x-slot>
                            <x-slot name="value"></x-slot>
                            <x-slot name="message"></x-slot>
                            <x-slot name="error"></x-slot>
                        </x-form-input-date>
                    </div>

                    <div class="col-md-2">
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

            <div class="row">
                <div class="d-flex flex-wrap gap-2">

                    <div class="col-md-2">
                        <x-form-input-default-livewire>
                            <x-slot name="label">Punto de Venta</x-slot>
                            <x-slot name="livewire">wire:model.live="oti_item_numero"</x-slot>
                            <x-slot name="name"></x-slot>
                            <x-slot name="placeholder">0</x-slot>
                            <x-slot name="value"></x-slot>
                            <x-slot name="message"></x-slot>
                            <x-slot name="error"></x-slot>
                        </x-form-input-default-livewire>
                    </div>

                    <div class="col-md-2">
                        <x-form-input-default-livewire>
                            <x-slot name="label">Número</x-slot>
                            <x-slot name="livewire">wire:model.live="oti_item_numero"</x-slot>
                            <x-slot name="name"></x-slot>
                            <x-slot name="placeholder">0</x-slot>
                            <x-slot name="value"></x-slot>
                            <x-slot name="message"></x-slot>
                            <x-slot name="error"></x-slot>
                        </x-form-input-default-livewire>
                    </div>

                </div>
            </div>

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
                                    <option value="{{ $proveedor->id }}">{{ $proveedor->id }} | {{ $proveedor->Nombre }}</option>
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

                </div>
            </div>

            <x-modal-table>
                <x-slot name="title">Buscar Proveedor</x-slot>
                <x-slot name="body">

                    <div class="table-responsive" style="max-height: 60vh; overflow-y: auto;">

                        <x-data-table-no-plus-no-export>

                            <x-slot name="table_title">Proveedores</x-slot>
                            <x-slot name="export_route">{{ route('clients.export') }}</x-slot>
                            <x-slot name="create_route">{{ route('compras.actualizaciones.proveedores.create') }}</x-slot>
                            <x-slot name="add_text">Añadir proveedor</x-slot>
                            <x-slot name="head_tr">
                                <tr>
                                    <th>Código</th>
                                    <th>Nombre</th>
                                    <th>CUIT</th>
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
                                        <td>{{ $proveedor->NumeroDocumento }}</td>
                                        <td>{{ $proveedor->Direccion }}</td>
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
                                    <th>CUIT</th>
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

    <x-panel-horizontal-5-no-title>
        <x-slot name="panel1">Todos</x-slot>
        <x-slot name="body1">

            <x-data-table-no-plus>
                <x-slot name="table_title">Todos</x-slot>
                <x-slot name="export_route">{{ route('programacion.export') }}</x-slot>
                <x-slot name="add_text">Añadir Item</x-slot>

                <x-slot name="head_tr">
                    <tr>
                        <th>Opciones</th>
                        <th>Fecha</th>
                        <th>Fecha Venc.</th>
                        <th>Número</th>
                        <th>Código</th>
                        <th>Razón Social</th>
                        <th>Estado</th>
                        <th>Total</th>
                    </tr>
                </x-slot>

                <x-slot name="body_tr">

                    @forelse ($documentos as $index => $documento)
                        <tr>
                            @if ($documento instanceof App\Models\Facturacompra)
                                @if ($documento->EsNotaDeDebito == 0)
                                    <td class="text-start align-middle">
                                        <div class="d-flex justify-content-start align-items-center gap-3 ms-2">
                                            <a
                                                href="{{ route('compras.ficha-del-proveedor.factura-compra.edit', $proveedor) }}"
                                                class="btn btn-link btn-primary p-0"
                                                data-bs-toggle="tooltip"
                                                title="Editar factura compra"
                                            >
                                                <i class="fa fa-edit fa-lg"></i>
                                            </a>
                                        </div>
                                    </td>
                                @else
                                    <td class="text-start align-middle">
                                        <div class="d-flex justify-content-start align-items-center gap-3 ms-2">
                                            <a
                                                href="{{ route('compras.ficha-del-proveedor.nota-debito.edit', $proveedor) }}"
                                                class="btn btn-link btn-primary p-0"
                                                data-bs-toggle="tooltip"
                                                title="Editar nota de débito"
                                            >
                                                <i class="fa fa-edit fa-lg"></i>
                                            </a>
                                        </div>
                                    </td>
                                @endif
                            @elseif ($documento instanceof App\Models\NotaCreditoCompra)
                                <td class="text-start align-middle">
                                    <div class="d-flex justify-content-start align-items-center gap-3 ms-2">
                                        <a
                                            href="{{ route('compras.ficha-del-proveedor.nota-credito.edit', $proveedor) }}"
                                            class="btn btn-link btn-primary p-0"
                                            data-bs-toggle="tooltip"
                                            title="Editar nota de crédito"
                                        >
                                            <i class="fa fa-edit fa-lg"></i>
                                        </a>
                                    </div>
                                </td>
                            @elseif ($documento instanceof App\Models\OrdenPago)
                                <td class="text-start align-middle">
                                    <div class="d-flex justify-content-start align-items-center gap-3 ms-2">
                                        <a
                                            href="{{ route('compras.ficha-del-proveedor.orden-pago.edit', $proveedor) }}"
                                            class="btn btn-link btn-primary p-0"
                                            data-bs-toggle="tooltip"
                                            title="Editar órden de pago"
                                        >
                                            <i class="fa fa-edit fa-lg"></i>
                                        </a>
                                    </div>
                                </td>
                            @endif
                            <td>{{ $documento->FechaEmision }}</td>
                            <td>{{ $documento->FechaVencimiento }}</td>
                            <td>{{ $documento->NumeroCompleto }}</td>
                            <td>{{ $documento->IdProveedor }}</td>
                            @if ($documento instanceof App\Models\OrdenPago)
                                <td>{{ $documento->RazonSocial ?? '' }}</td>
                            @else
                                <td>{{ $documento->proveedor->Nombre }}</td>
                            @endif
                            <td>{{ $documento->Estado }}</td>
                            <td>{{ number_format($documento->Total, 2, '.', '') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="7">No se encontraron resultados.</td></tr>
                    @endforelse
                </x-slot>

                <x-slot name="foot_tr">
                    <tr>
                        <th>Opciones</th>
                        <th>Fecha</th>
                        <th>Fecha Venc.</th>
                        <th>Número</th>
                        <th>Código</th>
                        <th>Razón Social</th>
                        <th>Estado</th>
                        <th>Total</th>
                    </tr>
                </x-slot>
            </x-data-table-no-plus>

        </x-slot>

        <x-slot name="panel2">Factura</x-slot>

        <x-slot name="body2">

            <x-data-table-no-plus>
                <x-slot name="table_title">Facturas</x-slot>
                <x-slot name="export_route">{{ route('programacion.export') }}</x-slot>
                <x-slot name="add_text">Añadir Item</x-slot>

                <x-slot name="head_tr">
                    <tr>
                        <th>Opciones</th>
                        <th>Fecha</th>
                        <th>Fecha Venc.</th>
                        <th>Número</th>
                        <th>Código</th>
                        <th>Razón Social</th>
                        <th>Estado</th>
                        <th>Total</th>
                    </tr>
                </x-slot>

                <x-slot name="body_tr">

                    @forelse ($facturas_compra as $factura_compra)
                        <tr>
                            <td class="text-start align-middle">
                                <div class="d-flex justify-content-start align-items-center gap-3 ms-2">
                                    <a
                                        href="{{ route('compras.ficha-del-proveedor.factura-compra.edit', $proveedor) }}"
                                        class="btn btn-link btn-primary p-0"
                                        data-bs-toggle="tooltip"
                                        title="Editar órden de pago"
                                    >
                                        <i class="fa fa-edit fa-lg"></i>
                                    </a>
                                </div>
                            </td>
                            <td>{{ $factura_compra->FechaEmision }}</td>
                            <td>{{ $factura_compra->FechaVencimiento }}</td>
                            <td>{{ $factura_compra->NumeroCompleto }}</td>
                            <td>{{ $factura_compra->IdProveedor }}</td>
                            <td>{{ $factura_compra->proveedor->Nombre }}</td>
                            <td>{{ $factura_compra->Estado }}</td>
                            <td>{{ number_format($factura_compra->Total, 2, '.', '') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="7">No se encontraron resultados.</td></tr>
                    @endforelse
                </x-slot>

                <x-slot name="foot_tr">
                    <tr>
                        <th>Opciones</th>
                        <th>Fecha</th>
                        <th>Fecha Venc.</th>
                        <th>Número</th>
                        <th>Código</th>
                        <th>Razón Social</th>
                        <th>Estado</th>
                        <th>Total</th>
                    </tr>
                </x-slot>
            </x-data-table-no-plus>

        </x-slot>

        <x-slot name="panel3">Nota de Débito</x-slot>

        <x-slot name="body3">

            <x-data-table-no-plus>
                <x-slot name="table_title">Notas de Débito</x-slot>
                <x-slot name="export_route">{{ route('programacion.export') }}</x-slot>
                <x-slot name="add_text">Añadir Item</x-slot>

                <x-slot name="head_tr">
                    <tr>
                        <th>Opciones</th>
                        <th>Fecha</th>
                        <th>Fecha Venc.</th>
                        <th>Número</th>
                        <th>Código</th>
                        <th>Razón Social</th>
                        <th>Estado</th>
                        <th>Total</th>
                    </tr>
                </x-slot>

                <x-slot name="body_tr">

                    @forelse ($notas_debito_compra as $nota_debito_compra)
                        <tr>
                            <td class="text-start align-middle">
                                <div class="d-flex justify-content-start align-items-center gap-3 ms-2">
                                    <a
                                        href="{{ route('compras.ficha-del-proveedor.nota-debito.edit', $proveedor) }}"
                                        class="btn btn-link btn-primary p-0"
                                        data-bs-toggle="tooltip"
                                        title="Editar órden de pago"
                                    >
                                        <i class="fa fa-edit fa-lg"></i>
                                    </a>
                                </div>
                            </td>
                            <td>{{ $nota_debito_compra->FechaEmision }}</td>
                            <td>{{ $nota_debito_compra->FechaVencimiento }}</td>
                            <td>{{ $nota_debito_compra->NumeroCompleto }}</td>
                            <td>{{ $nota_debito_compra->IdProveedor }}</td>
                            <td>{{ $nota_debito_compra->proveedor->Nombre }}</td>
                            <td>{{ $nota_debito_compra->Estado }}</td>
                            <td>{{ number_format($nota_debito_compra->Total, 2, '.', '') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="7">No se encontraron resultados.</td></tr>
                    @endforelse
                </x-slot>

                <x-slot name="foot_tr">
                    <tr>
                        <th>Opciones</th>
                        <th>Fecha</th>
                        <th>Fecha Venc.</th>
                        <th>Número</th>
                        <th>Código</th>
                        <th>Razón Social</th>
                        <th>Estado</th>
                        <th>Total</th>
                    </tr>
                </x-slot>
            </x-data-table-no-plus>

        </x-slot>

        <x-slot name="panel4">Nota de Crédito</x-slot>

        <x-slot name="body4">

            <x-data-table-no-plus>
                <x-slot name="table_title">Notas de Crédito</x-slot>
                <x-slot name="export_route">{{ route('programacion.export') }}</x-slot>
                <x-slot name="add_text">Añadir Item</x-slot>

                <x-slot name="head_tr">
                    <tr>
                        <th>Opciones</th>
                        <th>Fecha</th>
                        <th>Fecha Venc.</th>
                        <th>Número</th>
                        <th>Código</th>
                        <th>Razón Social</th>
                        <th>Estado</th>
                        <th>Total</th>
                    </tr>
                </x-slot>

                <x-slot name="body_tr">

                    @forelse ($notas_credito_compra as $nota_credito_compra)
                        <tr>
                            <td class="text-start align-middle">
                                <div class="d-flex justify-content-start align-items-center gap-3 ms-2">
                                    <a
                                        href="{{ route('compras.ficha-del-proveedor.nota-credito.edit', $proveedor) }}"
                                        class="btn btn-link btn-primary p-0"
                                        data-bs-toggle="tooltip"
                                        title="Editar órden de pago"
                                    >
                                        <i class="fa fa-edit fa-lg"></i>
                                    </a>
                                </div>
                            </td>
                            <td>{{ $nota_credito_compra->FechaEmision }}</td>
                            <td>{{ $nota_credito_compra->FechaVencimiento }}</td>
                            <td>{{ $nota_credito_compra->NumeroCompleto }}</td>
                            <td>{{ $nota_credito_compra->IdProveedor }}</td>
                            <td>{{ $nota_credito_compra->proveedor->Nombre }}</td>
                            <td>{{ $nota_credito_compra->Estado }}</td>
                            <td>{{ number_format($nota_credito_compra->Total, 2, '.', '') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="7">No se encontraron resultados.</td></tr>
                    @endforelse
                </x-slot>

                <x-slot name="foot_tr">
                    <tr>
                        <th>Opciones</th>
                        <th>Fecha</th>
                        <th>Fecha Venc.</th>
                        <th>Número</th>
                        <th>Código</th>
                        <th>Razón Social</th>
                        <th>Estado</th>
                        <th>Total</th>
                    </tr>
                </x-slot>
            </x-data-table-no-plus>

        </x-slot>

        <x-slot name="panel5">Órden de Pago</x-slot>

        <x-slot name="body5">

            <x-data-table-no-plus>
                <x-slot name="table_title">Órdenes de Pago</x-slot>
                <x-slot name="export_route">{{ route('programacion.export') }}</x-slot>
                <x-slot name="add_text">Añadir Item</x-slot>

                <x-slot name="head_tr">
                    <tr>
                        <th>Opciones</th>
                        <th>Fecha</th>
                        <th>Fecha Venc.</th>
                        <th>Número</th>
                        <th>Código</th>
                        <th>Razón Social</th>
                        <th>Estado</th>
                        <th>Total</th>
                    </tr>
                </x-slot>

                <x-slot name="body_tr">

                    @forelse ($ordenes_pago as $orden_pago)
                        <tr>
                            <td class="text-start align-middle">
                                <div class="d-flex justify-content-start align-items-center gap-3 ms-2">
                                    <a
                                        href="{{ route('compras.ficha-del-proveedor.orden-pago.edit', $proveedor) }}"
                                        class="btn btn-link btn-primary p-0"
                                        data-bs-toggle="tooltip"
                                        title="Editar órden de pago"
                                    >
                                        <i class="fa fa-edit fa-lg"></i>
                                    </a>
                                </div>
                            </td>
                            <td>{{ $orden_pago->FechaEmision }}</td>
                            <td>{{ $orden_pago->FechaVencimiento }}</td>
                            <td>{{ $orden_pago->NumeroCompleto }}</td>
                            <td>{{ $orden_pago->IdProveedor }}</td>
                            <td>{{ $orden_pago->RazonSocial }}</td>
                            <td>{{ $orden_pago->Estado }}</td>
                            <td>{{ number_format($orden_pago->Total, 2, '.', '') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="7">No se encontraron resultados.</td></tr>
                    @endforelse
                </x-slot>

                <x-slot name="foot_tr">
                    <tr>
                        <th>Opciones</th>
                        <th>Fecha</th>
                        <th>Fecha Venc.</th>
                        <th>Número</th>
                        <th>Código</th>
                        <th>Razón Social</th>
                        <th>Estado</th>
                        <th>Total</th>
                    </tr>
                </x-slot>
            </x-data-table-no-plus>

        </x-slot>
        
    </x-panel-horizontal-5-no-title>

</x-layout> --}}


<div>
    <x-layout2-sidebar>
        <x-slot name="title">Buscar comprobantes</x-slot>
        <x-slot name="filtros">

            <div class="form-inline mt-5">

                <div class="form-group w-100 mb-3">
                
                    <label for="sidebarSearch" class="form-label text-muted small">
                        DESDE FECHA
                    </label>
                    
                    <div class="input-group" data-widget="sidebar-search">
                        <input id="sidebarSearch" 
                            class="form-control form-control-sm bg-white text-dark" 
                            type="date" placeholder="0" aria-label="Search" wire:model.live="fechaDesde">
                        <div class="input-group-append">
                        </div>
                    </div>
                
                </div>

                <div class="form-group w-100 mb-3">
                
                    <label for="sidebarSearch" class="form-label text-muted small">
                        HASTA FECHA
                    </label>
                    
                    <div class="input-group" data-widget="sidebar-search">
                        <input id="sidebarSearch" 
                            class="form-control form-control-sm bg-white text-dark" 
                            type="date" aria-label="Search" wire:model.live="fechaHasta">
                        <div class="input-group-append">
                        </div>
                    </div>
                
                </div>

                <div class="form-group w-100 mb-3">
                
                <label for="sidebarSearch" class="form-label text-muted small">
                    PUNTO DE VENTA
                </label>
                
                <div class="input-group" data-widget="sidebar-search">
                    <input id="sidebarSearch" 
                        class="form-control form-control-sm bg-white text-dark" 
                        type="search" placeholder="0" aria-label="Search" wire:model.live="puntoVenta">
                    <div class="input-group-append">
                    </div>
                </div>
                
                </div>

                <div class="form-group w-100 mb-3">
                
                <label for="sidebarSearch" class="form-label text-muted small">
                    NUMERO
                </label>
                
                <div class="input-group" data-widget="sidebar-search">
                    <input id="sidebarSearch" 
                        class="form-control form-control-sm bg-white text-dark" 
                        type="search" placeholder="0" aria-label="Search" wire:model.live="numero">
                    <div class="input-group-append">
                    </div>
                </div>
                
                </div>

                <div class="form-group w-100 mb-3">
                
                <label for="sidebarSearch" class="form-label text-muted small">
                    CODIGO PROVEEDOR
                </label>
                
                <div class="input-group">
                    <input id="sidebarSearch" 
                        class="form-control form-control-sm bg-white text-dark" 
                        type="search" placeholder="0" wire:model.live="cliente_id">
                    <div class="input-group-append">
                        <button type="button" 
                                class="btn btn-sidebar btn-sm bg-orange" 
                                data-toggle="modal" 
                                data-target="#modal-cliente">
                            <i class="fas fa-search fa-fw text-white"></i>
                        </button>
                    </div>
                </div>
                
                </div>
            </div>

        </x-slot>

        <x-simple-table2>
            <x-slot name="filtros">
                <div class="d-flex justify-content-between align-items-center mb-4 mt-2">
                    <div class="custom-control custom-radio">
                        <input class="custom-control-input" type="radio" id="customRadio1" name="customRadio" wire:model.live="filtroTipo" value="Todos">
                        <label for="customRadio1" class="custom-control-label font-weight-normal">Todos</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input class="custom-control-input" type="radio" id="customRadio2" name="customRadio" wire:model.live="filtroTipo" value="FacturaVenta">
                        <label for="customRadio2" class="custom-control-label font-weight-normal">Factura</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input class="custom-control-input" type="radio" id="customRadio3" name="customRadio" wire:model.live="filtroTipo" value="NotaDebito">
                        <label for="customRadio3" class="custom-control-label font-weight-normal">Nota de Débito</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input class="custom-control-input" type="radio" id="customRadio4" name="customRadio" wire:model.live="filtroTipo" value="NotaCreditoVenta">
                        <label for="customRadio4" class="custom-control-label font-weight-normal">Nota de crédito</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input class="custom-control-input" type="radio" id="customRadio5" name="customRadio" wire:model.live="filtroTipo" value="OrdenPago">
                        <label for="customRadio5" class="custom-control-label font-weight-normal">Orden de pago</label>
                    </div>
                </div>
            </x-slot>

            <x-slot name="thead">
                <tr>
                    <th>FECHA</th>
                    <th>FECHA VENC.</th>
                    <th>NUMERO</th>
                    <th>CODIGO</th>
                    <th>RAZON SOCIAL</th>
                    <th>ESTADO</th>
                    <th>TOTAL</th>
                </tr>
            </x-slot>
            <x-slot name="tbody">
                {{-- @forelse ($this->documentosFiltrados as $index => $documento)
                    <tr style="cursor:pointer;" onclick="window.location='{{ $this->getUrlEditarDocumento($documento) }}'">
                        <td>{{ \Carbon\Carbon::parse($documento['FechaEmision'])->format('j/n/Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($documento['FechaVencimiento'])->format('j/n/Y') }}</td>
                        <td>{{ $documento['NumeroCompleto'] }}</td>
                        <td>{{ $documento['IdCliente'] }}</td>
                        <td>{{ $documento['RazonSocial'] }}</td>
                        <td>{{ $documento['Estado'] }}</td>
                        <td>{{ number_format($documento['PorcentajeDescuento'], 2, '.', '') }}</td>
                        <td>{{ number_format($documento['Total'], 2, '.', '') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="8">No se encontraron resultados.</td></tr>
                @endforelse --}}
            </x-slot>
        </x-simple-table2>

    <!-- .modal -->
    <div class="modal fade" id="modal-cliente" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title">
                    BUSCAR CLIENTE
                </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                <div class="row">

                    <x-simple-table2>

                        <x-slot name="filtros">

                            <div class="row">
                                <div class="col-3">
                                    <div class="form-group mb-0">
                                        <label for="filtro1" class="font-weight-normal">NOMBRE</label>
                                        <input type="text" id="filtro1" name="filtro1" class="form-control form-control-sm">
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group mb-0">
                                        <label for="filtro2" class="font-weight-normal">NUMERO DE DOCUMENTO</label>
                                        <input type="text" id="filtro2" name="filtro1" class="form-control form-control-sm">
                                    </div>
                                </div>
                            </div>

                        </x-slot>

                        <x-slot name="thead">
                            <tr>
                                <th>CODIGO</th>
                                <th>NOMBRE</th>
                                <th>TIPO DE DOCUMENTO</th>
                                <th>NUMERO</th>
                                <th>DOMICILIO</th>
                                <th>LOCALIDAD</th>
                                <th>PROVINCIA</th>
                                <th>ACTIVO</th>
                            </tr>
                        </x-slot>
                        <x-slot name="tbody">
                            
                            {{-- @forelse ($clientes as $cliente)
                                <tr wire:click.prevent="seleccionarCliente({{ $cliente->id }})"
                                    style="cursor:pointer;"
                                    class="{{ $cliente_id == $cliente->id ? 'table-primary' : '' }}">
                                    <td>{{ $cliente->id }}</td>
                                    <td>{{ $cliente->Nombre }}</td>
                                    <td>{{ $cliente->TipoDocumento }}</td>
                                    <td>{{ $cliente->NroDocumento }}</td>
                                    <td>{{ $cliente->Domicilio }}</td>
                                    <td>{{ $cliente->localidad->Nombre ?? 'Ciudad no asignada' }}</td>
                                    <td>{{ $cliente->localidad->provincia->Nombre ?? 'Provincia no asignada' }}</td>
                                    <td><input type="checkbox" name="" id="" disabled {{ $cliente->Activo == 1 ? 'checked' : '' }}></td>
                                </tr>
                            @empty
                                <tr><td colspan="8">No se encontraron resultados.</td></tr>
                            @endforelse --}}
                        </x-slot>
                    </x-simple-table2>

                </div>

                </div>

                <div class="modal-footer justify-content-end">

                    <button class="btn btn-sidebar btn-sm bg-orange" data-dismiss="modal">
                        <span class="text-white">Aceptar</span>
                        <i class="fas fa-check fa-fw text-white ml-2"></i>
                    </button>

                    <button class="btn btn-sidebar btn-sm bg-orange" data-dismiss="modal" wire:click="cancelarCliente">
                        <span class="text-white">Cancelar</span>
                        <i class="fas fa-xmark fa-fw text-white ml-2"></i>
                    </button>

                </div>

            </div>
        </div>
    </div>
    <!-- /.modal -->

    </x-layout2-sidebar>
</div>