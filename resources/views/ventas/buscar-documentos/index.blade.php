<x-layout>
    <x-slot name="title">Ventas</x-slot>
    <x-slot name="breadcrumbs">
        <li class="nav-home">
            <a href="#"><i class="fas fa-dollar-sign"></i></a>
        </li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="#">Valorizar Trabajos</a></li>
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
                                @foreach ($clientes as $cliente)
                                    <option value="{{ $cliente->id }}">{{ $cliente->id }} | {{ $cliente->Nombre }}</option>
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
                        
                                @foreach ($clientes as $client)
                                    <tr style="cursor: pointer;" wire:click="$set('cliente_id', {{ $client->id }})" data-bs-dismiss="modal">
                                        <td>{{ $client->id }}</td>
                                        <td>{{ $client->Nombre }}</td>
                                        <td>{{ $client->TipoDocumento }}</td>
                                        <td>{{ $client->Telefono }}</td>
                                        <td>{{ $client->Domicilio }}</td>
                                        <td>{{ $client->localidad->Nombre ?? 'Ciudad no asignada' }}</td>
                                        <td>{{ $client->localidad->provincia->Nombre ?? 'Provincia no asignada' }}</td>
                                        <td>
                                            <input type="checkbox" name="" id="" disabled {{ $client->Activo == 1 ? 'checked' : '' }}>
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

    <x-panel-horizontal-6-no-title>
        <x-slot name="panel1">Todos</x-slot>
        <x-slot name="body1">

            <x-data-table-no-plus>
                <x-slot name="table_title">Documentos</x-slot>
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
                        <th>% Desc</th>
                        <th>Total</th>
                    </tr>
                </x-slot>

                <x-slot name="body_tr">

                    @forelse ($documentos as $index => $documento)
                        <tr>
                            <td class="text-start align-middle">
                                <div class="d-flex justify-content-start align-items-center gap-3 ms-2">
                                    <a
                                        href="{{ route('ventas.ficha-del-cliente-nota-envio.create', $cliente) }}"
                                        class="btn btn-link btn-primary p-0"
                                        data-bs-toggle="tooltip"
                                        title="Editar documento"
                                    >
                                        <i class="fa fa-edit fa-lg"></i>
                                    </a>
                                </div>
                            </td>
                            <td>{{ $documento->FechaEmision }}</td>
                            <td>{{ $documento->FechaVencimiento }}</td>
                            <td>{{ $documento->NumeroCompleto }}</td>
                            <td>{{ $documento->IdCliente }}</td>
                            <td>{{ $documento->RazonSocial }}</td>
                            <td>{{ $documento->Estado }}</td>
                            <td>{{ number_format($documento->PorcentajeDescuento, 2, '.', '') }}</td>
                            <td>{{ number_format($documento->Total, 2, '.', '') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="11">No se encontraron resultados.</td></tr>
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
                        <th>% Desc</th>
                        <th>Total</th>
                    </tr>
                </x-slot>
            </x-data-table-no-plus>

        </x-slot>

        <x-slot name="panel2">Nota de Envío</x-slot>

        <x-slot name="body2">

            <x-data-table-no-plus>
                <x-slot name="table_title">Notas de Envío</x-slot>
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
                        <th>% Desc</th>
                        <th>Total</th>
                    </tr>
                </x-slot>

                <x-slot name="body_tr">

                    @forelse ($notas_de_envio as $index => $nota_de_envio)
                        <tr>
                            <td class="text-start align-middle">
                                <div class="d-flex justify-content-start align-items-center gap-3 ms-2">
                                    <a
                                        href="{{ route('ventas.ficha-del-cliente-nota-envio.create', $cliente) }}"
                                        class="btn btn-link btn-primary p-0"
                                        data-bs-toggle="tooltip"
                                        title="Editar nota de envío"
                                    >
                                        <i class="fa fa-edit fa-lg"></i>
                                    </a>
                                </div>
                            </td>
                            <td>{{ $nota_de_envio->FechaEmision }}</td>
                            <td>{{ $nota_de_envio->FechaVencimiento }}</td>
                            <td>{{ $nota_de_envio->NumeroCompleto }}</td>
                            <td>{{ $nota_de_envio->IdCliente }}</td>
                            <td>{{ $nota_de_envio->RazonSocial }}</td>
                            <td>{{ $nota_de_envio->Estado }}</td>
                            <td>{{ number_format($nota_de_envio->PorcentajeDescuento, 2, '.', '') }}</td>
                            <td>{{ number_format($nota_de_envio->Total, 2, '.', '') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="11">No se encontraron resultados.</td></tr>
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
                        <th>% Desc</th>
                        <th>Total</th>
                    </tr>
                </x-slot>
            </x-data-table-no-plus>

        </x-slot>

        <x-slot name="panel3">Factura</x-slot>

        <x-slot name="body3">

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
                        <th>% Desc</th>
                        <th>Total</th>
                    </tr>
                </x-slot>

                <x-slot name="body_tr">

                    @forelse ($facturas as $index => $factura)
                        <tr>
                            <td class="text-start align-middle">
                                <div class="d-flex justify-content-start align-items-center gap-3 ms-2">
                                    <a
                                        href="{{ route('ventas.ficha-del-cliente-nota-envio.create', $cliente) }}"
                                        class="btn btn-link btn-primary p-0"
                                        data-bs-toggle="tooltip"
                                        title="Editar factura"
                                    >
                                        <i class="fa fa-edit fa-lg"></i>
                                    </a>
                                </div>
                            </td>
                            <td>{{ $factura->FechaEmision }}</td>
                            <td>{{ $factura->FechaVencimiento }}</td>
                            <td>{{ $factura->NumeroCompleto }}</td>
                            <td>{{ $factura->IdCliente }}</td>
                            <td>{{ $factura->RazonSocial }}</td>
                            <td>{{ $factura->Estado }}</td>
                            <td>{{ number_format($factura->PorcentajeDescuento, 2, '.', '') }}</td>
                            <td>{{ number_format($factura->Total, 2, '.', '') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="11">No se encontraron resultados.</td></tr>
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
                        <th>% Desc</th>
                        <th>Total</th>
                    </tr>
                </x-slot>
            </x-data-table-no-plus>

        </x-slot>

        <x-slot name="panel4">Nota de Débito</x-slot>

        <x-slot name="body4">

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
                        <th>% Desc</th>
                        <th>Total</th>
                    </tr>
                </x-slot>

                <x-slot name="body_tr">

                    @forelse ($notas_de_debito as $index => $nota_de_debito)
                        <tr>
                            <td class="text-start align-middle">
                                <div class="d-flex justify-content-start align-items-center gap-3 ms-2">
                                    <a
                                        href="{{ route('ventas.ficha-del-cliente-nota-envio.create', $cliente) }}"
                                        class="btn btn-link btn-primary p-0"
                                        data-bs-toggle="tooltip"
                                        title="Editar nota de débito"
                                    >
                                        <i class="fa fa-edit fa-lg"></i>
                                    </a>
                                </div>
                            </td>
                            <td>{{ $nota_de_debito->FechaEmision }}</td>
                            <td>{{ $nota_de_debito->FechaVencimiento }}</td>
                            <td>{{ $nota_de_debito->NumeroCompleto }}</td>
                            <td>{{ $nota_de_debito->IdCliente }}</td>
                            <td>{{ $nota_de_debito->RazonSocial }}</td>
                            <td>{{ $nota_de_debito->Estado }}</td>
                            <td>{{ number_format($nota_de_debito->PorcentajeDescuento, 2, '.', '') }}</td>
                            <td>{{ number_format($nota_de_debito->Total, 2, '.', '') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="11">No se encontraron resultados.</td></tr>
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
                        <th>% Desc</th>
                        <th>Total</th>
                    </tr>
                </x-slot>
            </x-data-table-no-plus>

        </x-slot>

        <x-slot name="panel5">Nota de Crédito</x-slot>

        <x-slot name="body5">

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
                        <th>% Desc</th>
                        <th>Total</th>
                    </tr>
                </x-slot>

                <x-slot name="body_tr">

                    @forelse ($notas_de_credito as $index => $nota_de_credito)
                        <tr>
                            <td class="text-start align-middle">
                                <div class="d-flex justify-content-start align-items-center gap-3 ms-2">
                                    <a
                                        href="{{ route('ventas.ficha-del-cliente-nota-envio.create', $cliente) }}"
                                        class="btn btn-link btn-primary p-0"
                                        data-bs-toggle="tooltip"
                                        title="Editar nota de crédito"
                                    >
                                        <i class="fa fa-edit fa-lg"></i>
                                    </a>
                                </div>
                            </td>
                            <td>{{ $nota_de_credito->FechaEmision }}</td>
                            <td>{{ $nota_de_credito->FechaVencimiento }}</td>
                            <td>{{ $nota_de_credito->NumeroCompleto }}</td>
                            <td>{{ $nota_de_credito->IdCliente }}</td>
                            <td>{{ $nota_de_credito->RazonSocial }}</td>
                            <td>{{ $nota_de_credito->Estado }}</td>
                            <td>{{ number_format($nota_de_credito->PorcentajeDescuento, 2, '.', '') }}</td>
                            <td>{{ number_format($nota_de_credito->Total, 2, '.', '') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="11">No se encontraron resultados.</td></tr>
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
                        <th>% Desc</th>
                        <th>Total</th>
                    </tr>
                </x-slot>
            </x-data-table-no-plus>

        </x-slot>

        <x-slot name="panel6">Recibo</x-slot>

        <x-slot name="body6">

            <x-data-table-no-plus>
                <x-slot name="table_title">Recibos</x-slot>
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
                        <th>% Desc</th>
                        <th>Total</th>
                    </tr>
                </x-slot>

                <x-slot name="body_tr">

                    @forelse ($recibos as $index => $recibo)
                        <tr>
                            <td class="text-start align-middle">
                                <div class="d-flex justify-content-start align-items-center gap-3 ms-2">
                                    <a
                                        href="{{ route('ventas.ficha-del-cliente-nota-envio.create', $cliente) }}"
                                        class="btn btn-link btn-primary p-0"
                                        data-bs-toggle="tooltip"
                                        title="Editar recibo"
                                    >
                                        <i class="fa fa-edit fa-lg"></i>
                                    </a>
                                </div>
                            </td>
                            <td>{{ $recibo->FechaEmision }}</td>
                            <td>{{ $recibo->FechaVencimiento }}</td>
                            <td>{{ $recibo->NumeroCompleto }}</td>
                            <td>{{ $recibo->IdCliente }}</td>
                            <td>{{ $recibo->RazonSocial }}</td>
                            <td>{{ $recibo->Estado }}</td>
                            <td>{{ number_format($recibo->PorcentajeDescuento, 2, '.', '') }}</td>
                            <td>{{ number_format($recibo->Total, 2, '.', '') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="11">No se encontraron resultados.</td></tr>
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
                        <th>% Desc</th>
                        <th>Total</th>
                    </tr>
                </x-slot>
            </x-data-table-no-plus>

        </x-slot>

    </x-panel-horizontal-6-no-title>

</x-layout>