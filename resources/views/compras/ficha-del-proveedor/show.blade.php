@livewire('ficha-del-proveedor-show2', ['proveedor' => $proveedor])


{{-- <x-layout>
    <x-slot name="title">Compras</x-slot>
    <x-slot name="breadcrumbs">
        <li class="nav-home">
            <a href="#"><i class="fas fa-money-bill-wave"></i></a>
        </li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="#">Ficha del Proveedor</a></li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="#">Ver</a></li>
    </x-slot>

    <x-panel-horizontal-5-no-title>
        <x-slot name="title">({{$proveedor->id}}) {{$proveedor->Nombre}}</x-slot>
        
        <x-slot name="panel1">Facturas</x-slot>
        <x-slot name="body1">

            <x-data-table>
                <x-slot name="table_title">Factura Compra</x-slot>
                <x-slot name="export_route">{{ route('programacion.export') }}</x-slot>
                <x-slot name="add_text">Añadir FC</x-slot>
                <x-slot name="create_route">{{ route('compras.ficha-del-proveedor.factura-compra.create', $proveedor) }}</x-slot>

                <x-slot name="head_tr">
                    <tr>
                        <th>Opciones</th>
                        <th>Fecha</th>
                        <th>Vencimiento</th>
                        <th>Fecha Registro</th>
                        <th>Número</th>
                        <th>Subtotal</th>
                        <th>IVA</th>
                        <th>Importe</th>
                        <th>Estado</th>
                    </tr>
                </x-slot>
            
                <x-slot name="body_tr">
            
                    @forelse ($facturas_compra as $factura_compra)
                        <tr>
                            <td class="text-center align-middle">
                                <div class="d-flex justify-content-center align-items-center gap-3">
                                    <a
                                        href="{{ route('compras.ficha-del-proveedor.factura-compra.edit', $factura_compra) }}"
                                        class="btn btn-link btn-primary p-0"
                                        data-bs-toggle="tooltip"
                                        title="Editar factura compra"
                                    >
                                        <i class="fa fa-edit fa-lg"></i>
                                    </a>
                                    <form
                                        action="{{ route('compras.ficha-del-proveedor.factura-compra.destroy', $factura_compra) }}"
                                        method="POST"
                                        onsubmit="return confirm('¿Estás seguro de que quieres eliminar esta factura compra?')"
                                        class="m-0 p-0"
                                    >
                                        @csrf
                                        @method('DELETE')
                                        <button
                                        type="submit"
                                        class="btn btn-link btn-danger p-0"
                                        data-bs-toggle="tooltip"
                                        title="Eliminar factura compra"
                                        >
                                        <i class="fa fa-times fa-lg"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                            <td>{{ $factura_compra->FechaEmision }}</td>
                            <td>{{ $factura_compra->FechaVencimiento }}</td>
                            <td>{{ $factura_compra->FechaRegistro }}</td>
                            <td>{{ $factura_compra->NumeroCompleto }}</td>
                            <td>{{ number_format($factura_compra->Neto, 2, '.', '') }}</td>
                            <td>{{ number_format($factura_compra->IVA, 2, '.', '') }}</td>
                            <td>{{ number_format($factura_compra->Total, 2, '.', '') }}</td>
                            <td>{{ $factura_compra->Estado }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="9">No se encontraron resultados.</td></tr>
                    @endforelse
                </x-slot>
                <x-slot name="foot_tr">
                    <tr>
                        <th>Opciones</th>
                        <th>Fecha</th>
                        <th>Vencimiento</th>
                        <th>Fecha Registro</th>
                        <th>Número</th>
                        <th>Subtotal</th>
                        <th>IVA</th>
                        <th>Importe</th>
                        <th>Estado</th>
                    </tr>
                </x-slot>
            </x-data-table>

        </x-slot>


        <x-slot name="panel2">Órdenes de Pago</x-slot>

        <x-slot name="body2">

            <x-data-table>
                <x-slot name="table_title">Órdenes de Pago</x-slot>
                <x-slot name="export_route">{{ route('programacion.export') }}</x-slot>
                <x-slot name="add_text">Añadir OP</x-slot>
                <x-slot name="create_route">{{ route('compras.ficha-del-proveedor.orden-pago.create', $proveedor) }}</x-slot>

                <x-slot name="head_tr">
                    <tr>
                        <th>Opciones</th>
                        <th>Fecha</th>
                        <th>Número</th>
                        <th>Total</th>
                        <th>Estado</th>
                        <th>Impresiones</th>
                        <th>Correos</th>
                    </tr>
                </x-slot>
            
                <x-slot name="body_tr">
            
                    @forelse ($ordenes_pago as $orden_pago)
                        <tr>
                            <td class="text-center align-middle">
                                <div class="d-flex justify-content-center align-items-center gap-3">
                                    <a
                                        href="{{ route('compras.ficha-del-proveedor.orden-pago.edit', $orden_pago) }}"
                                        class="btn btn-link btn-primary p-0"
                                        data-bs-toggle="tooltip"
                                        title="Editar órden de pago"
                                    >
                                        <i class="fa fa-edit fa-lg"></i>
                                    </a>
                                    <form
                                        action="{{ route('compras.ficha-del-proveedor.orden-pago.destroy', $orden_pago) }}"
                                        method="POST"
                                        onsubmit="return confirm('¿Estás seguro de que quieres eliminar esta órden de pago?')"
                                        class="m-0 p-0"
                                    >
                                        @csrf
                                        @method('DELETE')
                                        <button
                                        type="submit"
                                        class="btn btn-link btn-danger p-0"
                                        data-bs-toggle="tooltip"
                                        title="Eliminar órden de pago"
                                        >
                                        <i class="fa fa-times fa-lg"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                            <td>{{ $orden_pago->FechaEmision }}</td>
                            <td>{{ $orden_pago->NumeroCompleto }}</td>
                            <td>{{ number_format($orden_pago->Total, 2, '.', '') }}</td>
                            <td>{{ $orden_pago->Estado }}</td>
                            <td>{{ $orden_pago->CantidadImpresiones }}</td>
                            <td>{{ $orden_pago->CantidadEnviosPorCorreo }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="7">No se encontraron resultados.</td></tr>
                    @endforelse
                </x-slot>
                <x-slot name="foot_tr">
                    <tr>
                        <th>Opciones</th>
                        <th>Fecha</th>
                        <th>Número</th>
                        <th>Total</th>
                        <th>Estado</th>
                        <th>Impresiones</th>
                        <th>Correos</th>
                    </tr>
                </x-slot>
            </x-data-table>
              
        </x-slot>

        <x-slot name="panel3">Notas de Crédito</x-slot>

        <x-slot name="body3">
        
            <x-data-table>
                <x-slot name="table_title">Notas de Crédito</x-slot>
                <x-slot name="export_route">{{ route('programacion.export') }}</x-slot>
                <x-slot name="add_text">Añadir NC</x-slot>
                <x-slot name="create_route">{{ route('compras.ficha-del-proveedor.nota-credito.create', $proveedor) }}</x-slot>

                <x-slot name="head_tr">
                    <tr>
                        <th>Opciones</th>
                        <th>Fecha</th>
                        <th>Vencimiento</th>
                        <th>Fecha Registro</th>
                        <th>Número</th>
                        <th>N° Doc. Asociado</th>
                        <th>Subtotal</th>
                        <th>IVA</th>
                        <th>Importe</th>
                        <th>Estado</th>
                    </tr>
                </x-slot>
            
                <x-slot name="body_tr">
            
                    @forelse ($notas_credito_compra as $nota_credito_compra)
                        <tr>
                            <td class="text-center align-middle">
                                <div class="d-flex justify-content-center align-items-center gap-3">
                                    <a
                                        href="{{ route('compras.ficha-del-proveedor.nota-credito.edit', $nota_credito_compra) }}"
                                        class="btn btn-link btn-primary p-0"
                                        data-bs-toggle="tooltip"
                                        title="Editar nota de crédito"
                                    >
                                        <i class="fa fa-edit fa-lg"></i>
                                    </a>
                                    <form
                                        action="{{ route('compras.ficha-del-proveedor.nota-credito.destroy', $nota_credito_compra) }}"
                                        method="POST"
                                        onsubmit="return confirm('¿Estás seguro de que quieres eliminar esta nota de crédito?')"
                                        class="m-0 p-0"
                                    >
                                        @csrf
                                        @method('DELETE')
                                        <button
                                        type="submit"
                                        class="btn btn-link btn-danger p-0"
                                        data-bs-toggle="tooltip"
                                        title="Eliminar nota de crédito"
                                        >
                                        <i class="fa fa-times fa-lg"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                            <td>{{ $nota_credito_compra->FechaEmision }}</td>
                            <td>{{ $nota_credito_compra->FechaVencimiento }}</td>
                            <td>{{ $nota_credito_compra->FechaRegistro }}</td>
                            <td>{{ $nota_credito_compra->NumeroCompleto }}</td>
                            <td>{{ $nota_credito_compra->facturaCompra->NumeroCompleto ?? '' }}</td>
                            <td>{{ number_format($nota_credito_compra->Neto, 2, '.', '') }}</td>
                            <td>{{ number_format($nota_credito_compra->IVA, 2, '.', '') }}</td>
                            <td>{{ number_format($nota_credito_compra->Total, 2, '.', '') }}</td>
                            <td>{{ $nota_credito_compra->Estado }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="10">No se encontraron resultados.</td></tr>
                    @endforelse
                </x-slot>
                <x-slot name="foot_tr">
                    <tr>
                        <th>Opciones</th>
                        <th>Fecha</th>
                        <th>Vencimiento</th>
                        <th>Fecha Registro</th>
                        <th>Número</th>
                        <th>N° Doc. Asociado</th>
                        <th>Subtotal</th>
                        <th>IVA</th>
                        <th>Importe</th>
                        <th>Estado</th>
                    </tr>
                </x-slot>
            </x-data-table>

        </x-slot>

        <x-slot name="panel4">Notas de Débito</x-slot>

        <x-slot name="body4">

            <x-data-table>
                <x-slot name="table_title">Notas de Débito</x-slot>
                <x-slot name="export_route">{{ route('programacion.export') }}</x-slot>
                <x-slot name="add_text">Añadir ND</x-slot>
                <x-slot name="create_route">{{ route('compras.ficha-del-proveedor.nota-debito.create', $proveedor) }}</x-slot>

                <x-slot name="head_tr">
                    <tr>
                        <th>Opciones</th>
                        <th>Fecha</th>
                        <th>Vencimiento</th>
                        <th>Número</th>
                        <th>N° Doc. Asociado</th>
                        <th>Subtotal</th>
                        <th>IVA</th>
                        <th>Importe</th>
                        <th>Estado</th>
                    </tr>
                </x-slot>
            
                <x-slot name="body_tr">
            
                    @forelse ($notas_debito_compra as $nota_debito_compra)
                        <tr>
                            <td class="text-center align-middle">
                                <div class="d-flex justify-content-center align-items-center gap-3">
                                    <a
                                        href="{{ route('compras.ficha-del-proveedor.nota-debito.edit', $nota_debito_compra) }}"
                                        class="btn btn-link btn-primary p-0"
                                        data-bs-toggle="tooltip"
                                        title="Editar nota de débito"
                                    >
                                        <i class="fa fa-edit fa-lg"></i>
                                    </a>
                                    <form
                                        action="{{ route('compras.ficha-del-proveedor.nota-debito.destroy', $nota_debito_compra) }}"
                                        method="POST"
                                        onsubmit="return confirm('¿Estás seguro de que quieres eliminar esta nota de débito?')"
                                        class="m-0 p-0"
                                    >
                                        @csrf
                                        @method('DELETE')
                                        <button
                                        type="submit"
                                        class="btn btn-link btn-danger p-0"
                                        data-bs-toggle="tooltip"
                                        title="Eliminar nota de débito"
                                        >
                                        <i class="fa fa-times fa-lg"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                            <td>{{ $nota_debito_compra->FechaEmision }}</td>
                            <td>{{ $nota_debito_compra->FechaVencimiento }}</td>
                            <td>{{ $nota_debito_compra->NumeroCompleto }}</td>
                            <td>{{ $nota_debito_compra->NroFacturaNotaDebito }}</td>
                            <td>{{ number_format($nota_debito_compra->Neto, 2, '.', '') }}</td>
                            <td>{{ number_format($nota_debito_compra->IVA, 2, '.', '') }}</td>
                            <td>{{ number_format($nota_debito_compra->Total, 2, '.', '') }}</td>
                            <td>{{ $nota_debito_compra->Estado }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="9">No se encontraron resultados.</td></tr>
                    @endforelse
                </x-slot>
                <x-slot name="foot_tr">
                    <tr>
                        <th>Opciones</th>
                        <th>Fecha</th>
                        <th>Vencimiento</th>
                        <th>Número</th>
                        <th>N° Doc. Asociado</th>
                        <th>Subtotal</th>
                        <th>IVA</th>
                        <th>Importe</th>
                        <th>Estado</th>
                    </tr>
                </x-slot>
            </x-data-table>
        
        </x-slot>

        <x-slot name="panel5">Minutas</x-slot>

        <x-slot name="body5">
        
            <x-data-table>
                <x-slot name="table_title">Minutas</x-slot>
                <x-slot name="export_route">{{ route('programacion.export') }}</x-slot>
                <x-slot name="add_text">Añadir MC</x-slot>
                <x-slot name="create_route">{{ route('compras.ficha-del-proveedor.minuta.create', $proveedor) }}</x-slot>

                <x-slot name="head_tr">
                    <tr>
                        <th>Opciones</th>
                        <th>Fecha</th>
                        <th>Número</th>
                        <th>Total</th>
                        <th>Estado</th>
                    </tr>
                </x-slot>
            
                <x-slot name="body_tr">
            
                    @forelse ($minutas_compra as $minuta_compra)
                        <tr>
                            <td class="text-center align-middle">
                                <div class="d-flex justify-content-center align-items-center gap-3">
                                    <a
                                        href="{{ route('compras.ficha-del-proveedor.minuta.edit', $minuta_compra) }}"
                                        class="btn btn-link btn-primary p-0"
                                        data-bs-toggle="tooltip"
                                        title="Editar minuta"
                                    >
                                        <i class="fa fa-edit fa-lg"></i>
                                    </a>
                                    <form
                                        action="{{ route('compras.ficha-del-proveedor.minuta.destroy', $minuta_compra) }}"
                                        method="POST"
                                        onsubmit="return confirm('¿Estás seguro de que quieres eliminar esta minuta?')"
                                        class="m-0 p-0"
                                    >
                                        @csrf
                                        @method('DELETE')
                                        <button
                                        type="submit"
                                        class="btn btn-link btn-danger p-0"
                                        data-bs-toggle="tooltip"
                                        title="Eliminar minuta"
                                        >
                                        <i class="fa fa-times fa-lg"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                            <td>{{ $minuta_compra->FechaEmision }}</td>
                            <td>{{ $minuta_compra->NumeroCompleto }}</td>
                            <td>{{ number_format($minuta_compra->Total, 2, '.', '') }}</td>
                            <td>{{ $minuta_compra->Estado }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5">No se encontraron resultados.</td></tr>
                    @endforelse
                </x-slot>
                <x-slot name="foot_tr">
                    <tr>
                        <th>Opciones</th>
                        <th>Fecha</th>
                        <th>Número</th>
                        <th>Total</th>
                        <th>Estado</th>
                    </tr>
                </x-slot>
            </x-data-table>
        
        </x-slot>

    </x-panel-horizontal-5-no-title>

</x-layout> --}}