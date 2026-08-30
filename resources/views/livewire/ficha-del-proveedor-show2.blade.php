<div>

    <form action="{{ route('ventas.divisas.update.edit', [\App\Models\ConfiguracionGlobal::first(), $selectedId]) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- .modal -->
        <div class="modal fade" id="modal-recibo" wire:ignore.self>
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                        Órdenes de pago pendientes
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="row">

                            <input type="hidden" name="Pendientes" value="0" wire:model.live="pendientes">

                            <div class="col-12">
                                <div class="form-check">

                                    <p>El proveedor tiene órdenes de pago pendientes. Confirme si quiere imputar el saldo con las facturas adeudadas.</p>

                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="modal-footer justify-content-end">

                        @if ($orden_pago_pendiente_mas_antiguo)
                            <a href="{{ route('compras.ficha-del-proveedor.orden-pago.edit', $orden_pago_pendiente_mas_antiguo)}}" 
                                class="btn btn-sidebar btn-sm bg-orange">
                                <span class="text-white">Imputar saldo</span>
                            </a>
                        @endif

                        <a href="{{ route('compras.ficha-del-proveedor.orden-pago.create', $proveedor->id) }}"
                            class="btn btn-sidebar btn-sm bg-orange">
                            <span class="text-white">Crear OP</span>
                        </a>


                        <a class="btn btn-sidebar btn-sm bg-orange" data-dismiss="modal">
                            <span class="text-white">Salir</span>
                        </a>

                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal -->

        <!-- .modal -->
        <div class="modal fade" id="modal-edit" wire:ignore.self>
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                        PARAMETROS NOTA DE ENVIO
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="row">

                            <input type="hidden" name="Pendientes" value="0" wire:model.live="pendientes">

                            <div class="col-6">
                                <div class="form-check">
                                    <input id="Pendientes" name="Pendientes" type="checkbox" value="1"
                                        wire:model.live="pendientes"
                                        class="form-check-input">                                    
                                    <div>
                                        <label for="Pendientes" class="form-check-label">FACTURAR TRABAJOS SIN APROBACION</label>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="modal-footer justify-content-end">

                        <a class="btn btn-sidebar btn-sm bg-orange" data-dismiss="modal" data-toggle="modal" data-target="#modal-divisas-2">
                            <span class="text-white">Aceptar</span>
                            <i class="fas fa-check fa-fw text-white ml-2"></i>
                        </a>

                        <a class="btn btn-sidebar btn-sm bg-orange" data-dismiss="modal">
                            <span class="text-white">Cancelar</span>
                            <i class="fas fa-xmark fa-fw text-white ml-2"></i>
                        </a>

                    </div>

                </div>
            </div>
        </div>
        <!-- /.modal -->

        <!-- .modal -->
        <div class="modal fade" id="modal-divisas-2">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title">DIVISAS</h4>
                    <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-6">
                            <label>USD -> ARS</label>
                            <input type="number" step="0.01" name="USD_ARS" 
                            value="{{ number_format(\App\Models\ConfiguracionGlobal::first()->USD_ARS, 2, '.', '') }}"
                                class="form-control form-control-sm">
                        </div>

                        <input type="hidden" name="IdCliente" value="{{ $proveedor->id }}">

                        <div class="col-6">
                            <label>Fecha de actualización</label>
                            <input type="date" readonly 
                                value="{{ \App\Models\ConfiguracionGlobal::first()->FechaActualizacionUSD_ARS }}" 
                                class="form-control form-control-sm">
                            <input type="hidden" name="FechaActualizacionUSD_ARS" 
                                value="{{ \App\Models\ConfiguracionGlobal::first()->FechaActualizacionUSD_ARS }}">
                        </div>
                    </div>
                </div>

                <div class="modal-footer justify-content-end">
                    <button type="submit" class="btn btn-sidebar btn-sm bg-orange">
                        <span class="text-white">Guardar</span>
                        <i class="fas fa-floppy-disk fa-fw text-white ml-2"></i>
                    </button>

                    <a href="{{ route('ventas.ficha-del-cliente-nota-envio.edit', ['nota_envio' => $selectedId, 'pendientes' => $pendientes]) }}" 
                        class="btn btn-sidebar btn-sm bg-orange">
                        <span class="text-white">Cancelar</span>
                        <i class="fas fa-xmark fa-fw text-white ml-2"></i>
                    </a>

                </div>

                </div>
            </div>
        </div>
        <!-- /.modal -->
    </form>

    <x-layout2-sidebar>
        <x-slot name="title">Ficha del proveedor</x-slot>

        <x-slot name="filtros">

            <div class="form-inline mt-5 mr-3 d-flex flex-column align-items-center">

                <div class="form-group mb-3">

                    @switch($activeTabParametros)
                        @case('custom-tabs-1')
                            <a href="{{ route('compras.ficha-del-proveedor.factura-compra.create', $proveedor->id) }}" class="btn btn-app bg-primary">
                                <i class="fas fa-plus"></i> Nuevo
                            </a>
                            
                            @break
                        @case('custom-tabs-2')

                            @if ($ordenes_pago->contains('Estado', 'PENDIENTE'))
                                <a class="btn btn-app bg-primary disabled" data-toggle="modal" data-target="#modal-recibo">
                                {{-- <a href="{{ route('ventas.ficha-del-cliente-recibo-venta.create', $proveedor->id) }}" class="btn btn-app bg-primary"> --}}
                                    <i class="fas fa-plus"></i> Nuevo
                                </a>
                            @else
                                <a href="{{ route('ventas.ficha-del-cliente-recibo-venta.create', $proveedor->id) }}" class="btn btn-app bg-primary disabled">
                                    <i class="fas fa-plus"></i> Nuevo
                                </a>    
                            @endif
                            
                            @break
                        @case('custom-tabs-3')
                            <a data-toggle="modal" data-target="#modal-create-nc" class="btn btn-app bg-primary disabled">
                                <i class="fas fa-plus"></i> Nuevo
                            </a>
                            
                            @break
                        @case('custom-tabs-4')
                            <a data-toggle="modal" data-target="#modal-create-nd" class="btn btn-app bg-primary disabled">
                                <i class="fas fa-plus"></i> Nuevo
                            </a>
                            
                            @break
                        @case('custom-tabs-5')
                            <a href="{{ route('ventas.ficha-del-cliente-minuta.create', $proveedor->id) }}" class="btn btn-app bg-primary disabled">
                                <i class="fas fa-plus"></i> Nuevo
                            </a>
                            
                            @break
                        @default
                            
                    @endswitch

                </div>

                <div class="form-group mb-3">

                    @switch($activeTabParametros)
                        @case('custom-tabs-1')
                            <a 
                            class="btn btn-app bg-primary disabled">
                                <i class="fas fa-pen"></i> Modificar
                            </a>
                            @break
                        @case('custom-tabs-2')

                            <a 
                            class="btn btn-app bg-primary disabled {{ !$selectedId ? 'disabled' : '' }}" href="{{ route('ventas.ficha-del-cliente-nota-envio.edit', $selectedId) }}">
                                <i class="fas fa-pen"></i> Modificar
                            </a>

                            @break
                        @case('custom-tabs-3')
                            <a 
                            class="btn btn-app bg-primary disabled {{ !$selectedId ? 'disabled' : '' }}" href="{{ route('ventas.ficha-del-cliente-factura-venta.edit', $selectedId) }}">
                                <i class="fas fa-pen"></i> Modificar
                            </a>
                            
                            @break
                        @case('custom-tabs-4')
                            <a 
                            class="btn btn-app bg-primary disabled {{ !$selectedId ? 'disabled' : '' }}" href="{{ route('ventas.ficha-del-cliente-recibo-venta.edit', $selectedId) }}">
                                <i class="fas fa-pen"></i> Modificar
                            </a>
                            
                            @break
                        @case('custom-tabs-5')
                            <a 
                            class="btn btn-app bg-primary disabled {{ !$selectedId ? 'disabled' : '' }}" href="{{ route('ventas.ficha-del-cliente-nota-credito.edit', $selectedId) }}">
                                <i class="fas fa-pen"></i> Modificar
                            </a>
                            
                            @break
                        @case('custom-tabs-6')
                            <a 
                            class="btn btn-app bg-primary disabled {{ !$selectedId ? 'disabled' : '' }}" href="{{ route('ventas.ficha-del-cliente-nota-debito.edit', $selectedId) }}">
                                <i class="fas fa-pen"></i> Modificar
                            </a>
                            
                            @break
                        @case('custom-tabs-7')
                            <a 
                            class="btn btn-app bg-primary disabled">
                                <i class="fas fa-pen"></i> Modificar
                            </a>
                            
                            @break
                        @default
                    @endswitch

                </div>

                <div class="form-group mb-3">
                    <form
                        action="{{ $selectedId ? route('programacion.destroy', $selectedId) : '#' }}"
                        method="POST"
                        onsubmit="return confirm('¿Estás seguro de que quieres eliminar esta programación?')"
                        class="m-0 p-0"
                    >
                        @csrf
                        @method('DELETE')
                        <button
                            type="submit"
                            class="btn btn-app bg-primary {{ !$selectedId ? 'disabled' : '' }}"
                            data-bs-toggle="tooltip"
                            title="Eliminar programación"
                            disabled
                        >
                        <i class="fas fa-xmark"></i> Eliminar
                        </button>
                    </form>
                </div>

            </div>

        </x-slot>

        <div class="d-flex justify-content-between align-items-center flex-nowrap mb-3">
            
            <h3 class="mb-0 text-truncate">
                <i class="fa-solid fa-image-portrait"></i> 
                ({{ $proveedor->id }}) {{ $proveedor->Nombre }}
            </h3>

            <h3 class="mb-0 text-nowrap">
                ${{ number_format($saldo, 2, ',', '.') }} 
                <i class="fa-solid fa-money-bills"></i>
            </h3>

        </div>
    
        <x-panel-horizontal2>

            <x-slot name="pestañas">

                <li class="nav-item">
                    <a class="nav-link {{ $activeTabParametros === 'custom-tabs-1' ? 'active' : '' }}" wire:click.prevent="setActiveTabParametros('custom-tabs-1')" id="custom-tabs-1-tab" data-toggle="pill" href="#custom-tabs-1" role="tab" aria-controls="custom-tabs-1" aria-selected="true">FACTURAS</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $activeTabParametros === 'custom-tabs-2' ? 'active' : '' }}" wire:click.prevent="setActiveTabParametros('custom-tabs-2')" id="custom-tabs-2-tab" data-toggle="pill" href="#custom-tabs-2" role="tab" aria-controls="custom-tabs-2" aria-selected="true">ORDENES DE PAGO</a>
                </li>
                <li class="nav-item {{ $activeTabParametros === 'custom-tabs-3' ? 'active' : '' }}" wire:click.prevent="setActiveTabParametros('custom-tabs-3')">
                    <a class="nav-link" id="custom-tabs-3-tab" data-toggle="pill" href="#custom-tabs-3" role="tab" aria-controls="custom-tabs-3" aria-selected="true">NOTAS DE CREDITO</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $activeTabParametros === 'custom-tabs-4' ? 'active' : '' }}" wire:click.prevent="setActiveTabParametros('custom-tabs-4')" id="custom-tabs-4-tab" data-toggle="pill" href="#custom-tabs-4" role="tab" aria-controls="custom-tabs-4" aria-selected="true">NOTAS DE DEBITO</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $activeTabParametros === 'custom-tabs-5' ? 'active' : '' }}" wire:click.prevent="setActiveTabParametros('custom-tabs-5')" id="custom-tabs-5-tab" data-toggle="pill" href="#custom-tabs-5" role="tab" aria-controls="custom-tabs-5" aria-selected="true">MINUTAS</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link bg-warning" 
                    href="{{ route('compras.resumen-cuenta-corriente', $proveedor->id) }}">
                    CTA CTE
                    </a>
                </li>

                <style>
                    .nav-tabs .nav-link {
                        font-size: 1rem !important;
                        padding: 0.3rem 0.6rem !important;
                    }
                </style>

            </x-slot>

            <x-slot name="ventanas">

                <div class="tab-pane fade show {{ $activeTabParametros === 'custom-tabs-1' ? 'active' : '' }}" id="custom-tabs-1" role="tabpanel" aria-labelledby="custom-tabs-1-tab">

                    <div class="row mb-3">

                        <div class="col-2">
                            <div class="form-group mb-0">
                                <label for="filtro1" class="font-weight-normal">Desde fecha</label>
                                <input type="date" id="filtro1" name="filtro1" wire:model.live="fact_desde" class="form-control form-control-sm" value="{">
                            </div>
                        </div>

                        <div class="col-2">
                            <div class="form-group mb-0">
                                <label for="filtro1" class="font-weight-normal">Hasta fecha</label>
                                <input type="date" id="filtro1" name="filtro1" wire:model.live="fact_hasta" class="form-control form-control-sm" value="">
                            </div>
                        </div>

                    </div>

                    <x-data-table-acordion3>

                        <x-slot name="thead">
                            <tr class="bg-secondary text-white">
                                <th>FECHA</th>
                                <th>VENCIMIENTO</th>
                                <th>FECHA REGISTRO</th>
                                <th>NUMERO</th>
                                <th>SUBTOTAL</th>
                                <th>IVA</th>
                                <th>IMPORTE</th>
                                <th>ESTADO</th>
                            </tr>   
                        </x-slot>

                        <x-slot name="tbody">

                            @foreach ($facturas as $index => $factura)

                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($factura->FechaEmision)->format('d/m/Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($factura->FechaVencimiento)->format('d/m/Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($factura->FechaRegistro)->format('d/m/Y') }}</td>
                                    <td>{{ $factura->NumeroCompleto }}</td>
                                    <td>{{  number_format($factura->Neto, 2, '.', '') }}</td>
                                    <td>{{  number_format($factura->IVA, 2, '.', '') }}</td>
                                    <td>{{  number_format($factura->Total, 2, '.', '') }}</td>
                                    <td>{{ $factura->Estado }}</td>
                                </tr>

                                {{-- <tr class="expandable-body" style="display: {{ in_array($factura->id, $expanded) ? 'table-row' : 'none' }};">

                                    <td colspan="15">
                                        <div class="p-0">
                                            <table class="table table-sm table-bordered mb-0">
                                                <thead>
                                                <tr>
                                                    <th>CODIGO</th>
                                                    <th>DESCRIPCION</th>
                                                    <th>CANTIDAD</th>
                                                    <th>PRECIO UNITARIO</th>
                                                    <th>% IVA</th>
                                                    <th>SUBTOTAL</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($factura->itemsFacturaVenta as $index => $item_factura_venta)
                                                        <tr>
                                                            <td>¡¡REVISAR!!</td>
                                                            <td>{{ $item_factura_venta->Descripcion }}</td>
                                                            <td>{{ number_format($item_factura_venta->Cantidad, 2, '.', '') }}</td>
                                                            <td>{{ number_format($item_factura_venta->PrecioUnitario, 2, '.', '') }}</td>
                                                            <td>{{ number_format($item_factura_venta->AlicuotaIVA, 2, '.', '') }}</td>
                                                            <td>{{ number_format($item_factura_venta->Total, 2, '.', '') }}</td>
                                                        </tr>
                                                    @endforeach

                                                    @php
                                                        $filasFaltantes = max(0, 6 - count($factura->itemsFacturaVenta));
                                                    @endphp

                                                    @for ($i = 3; $i < $filasFaltantes; $i++)
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                            <td>&nbsp;</td>
                                                            <td>&nbsp;</td>
                                                            <td>&nbsp;</td>
                                                            <td>&nbsp;</td>
                                                            <td>&nbsp;</td>
                                                        </tr>
                                                    @endfor
                                                </tbody>
                                            </table>
                                        </div>
                                    </td>

                                </tr> --}}

                            @endforeach

                            @php
                                $filasFaltantes = max(0, 10 - count($facturas));
                            @endphp

                            @for ($i = 0; $i < $filasFaltantes; $i++)
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                            @endfor

                        </x-slot>

                    </x-data-table-acordion3>

                </div>


                <div class="tab-pane fade show {{ $activeTabParametros === 'custom-tabs-2' ? 'active' : '' }}" id="custom-tabs-2" role="tabpanel" aria-labelledby="custom-tabs-2-tab">

                    <div class="row mb-3">

                        <div class="col-2">
                            <div class="form-group mb-0">
                                <label for="filtro1" class="font-weight-normal">Desde fecha</label>
                                <input type="date" id="filtro1" name="filtro1" wire:model.live="ot_desde" class="form-control form-control-sm" value="{">
                            </div>
                        </div>

                        <div class="col-2">
                            <div class="form-group mb-0">
                                <label for="filtro1" class="font-weight-normal">Hasta fecha</label>
                                <input type="date" id="filtro1" name="filtro1" wire:model.live="ot_hasta" class="form-control form-control-sm" value="">
                            </div>
                        </div>

                    </div>

                    <x-data-table-acordion3>

                        <x-slot name="thead">
                            <tr>
                                <th>FECHA</th>
                                <th>NUMERO</th>
                                <th>TOTAL</th>
                                <th>ESTADO</th>
                                <th><i class="fa-solid fa-print"></i></th>
                                <th><i class="fa-solid fa-envelope"></i></th>
                            </tr>   
                        </x-slot>

                        <x-slot name="tbody">

                            @foreach ($ordenes_pago as $index => $orden_pago)

                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($orden_pago->FechaEmision)->format('d/m/Y') }}</td>
                                    <td>{{ $orden_pago->NumeroCompleto }}</td>
                                    <td>{{ number_format($orden_pago->Total, 2, '.', '') }}</td>
                                    <td>{{ $orden_pago->Estado }}</td>
                                    <td>{{ $orden_pago->CantidadImpresiones }}</td>
                                    <td>{{ $orden_pago->CantidadEnviosPorCorreo }}</td>
                                </tr>

                                {{-- <tr class="expandable-body" style="display: {{ in_array($orden_pago->id, $expanded) ? 'table-row' : 'none' }};">

                                    <td colspan="15">
                                        <div class="p-0">
                                            <table class="table table-sm table-bordered mb-0">
                                                <thead>
                                                <tr>
                                                    <th>N°</th>
                                                    <th>DESCRIPCION</th>
                                                    <th>MATERIAL</th>
                                                    <th>CANT.</th>
                                                    <th>PESO</th>
                                                    <th>TRAT.</th>
                                                    <th>DUREZA</th>
                                                    <th>DSMIN</th>
                                                    <th>DSMAX</th>
                                                    <th>ESTADO</th>
                                                    <th>CC</th>
                                                    <th>CERT.</th>
                                                    <th>NOTA DE ENVIO</th>
                                                </tr>
                                                </thead>
                                                <tbody>

                                                    @foreach ($orden_trabajo->itemsOrdenTrabajo as $index => $item_orden_trabajo)
                                                        <tr>
                                                            <td>{{ $item_orden_trabajo->ItemNumero }}</td>
                                                            <td>{{ $item_orden_trabajo->Descripcion }}</td>
                                                            <td>{{ $item_orden_trabajo->material->Nombre }}</td>
                                                            <td>{{ $item_orden_trabajo->Cantidad }}</td>
                                                            <td>{{ $item_orden_trabajo->Peso }}</td>
                                                            <td>{{ $item_orden_trabajo->tratamiento->Nombre }}</td>
                                                            <td>{{ $item_orden_trabajo->dureza->Nombre }}</td>
                                                            <td>{{ $item_orden_trabajo->DurezaSolicitadaMinima }}</td>
                                                            <td>{{ $item_orden_trabajo->DurezaSolicitadaMaxima }}</td>
                                                            <td>{{ $item_orden_trabajo->Estado }}</td>
                                                            <td>{{ $item_orden_trabajo->CodigoComplejidad }}</td>
                                                            <td class="text-start align-middle">
                                                                @if ($item_orden_trabajo->Estado == 'APROBADO')
                                                                    <div class="d-flex justify-content-start align-items-center gap-3 ms-2">
                                                                        <a
                                                                            class="btn btn-link btn-secondary p-0"
                                                                            data-bs-toggle="tooltip"
                                                                            title="Imprimir programación"
                                                                        >
                                                                            <i class="fa fa-print fa-lg"></i>
                                                                        </a>
                                                                        <a
                                                                            class="btn btn-link btn-info p-0"
                                                                            data-bs-toggle="tooltip"
                                                                            title="Enviar por correo"
                                                                        >
                                                                            <i class="fa fa-envelope fa-lg"></i>
                                                                        </a>
                                                                    </div>
                                                                @endif
                                                            </td>
                                                            <td></td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </td>

                                </tr> --}}

                            @endforeach

                            @php
                                $filasFaltantes = max(0, 10 - count($ordenes_pago));
                            @endphp

                            @for ($i = 0; $i < $filasFaltantes; $i++)
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                            @endfor

                        </x-slot>

                    </x-data-table-acordion3>

                </div>


                <div class="tab-pane fade show {{ $activeTabParametros === 'custom-tabs-3' ? 'active' : '' }}" id="custom-tabs-3" role="tabpanel" aria-labelledby="custom-tabs-3-tab">

                    <div class="row mb-3">

                        <div class="col-2">
                            <div class="form-group mb-0">
                                <label for="filtro1" class="font-weight-normal">Desde fecha</label>
                                <input type="date" id="filtro1" name="filtro1" wire:model.live="nc_desde" class="form-control form-control-sm" value="{">
                            </div>
                        </div>

                        <div class="col-2">
                            <div class="form-group mb-0">
                                <label for="filtro1" class="font-weight-normal">Hasta fecha</label>
                                <input type="date" id="filtro1" name="filtro1" wire:model.live="nc_hasta" class="form-control form-control-sm" value="">
                            </div>
                        </div>

                    </div>

                    <x-data-table-acordion3>

                        <x-slot name="thead">
                            <tr class="bg-secondary text-white">
                                <th>FECHA</th>
                                <th>VENCIMIENTO</th>
                                <th>FECHA REGISTRO</th>
                                <th>NUMERO</th>
                                <th>N° DOC. ASOCIADO</th>
                                <th>SUBTOTAL</th>
                                <th>IVA</th>
                                <th>TOTAL</th>
                                <th>ESTADO</th>
                            </tr>   
                        </x-slot>

                        <x-slot name="tbody">

                            @foreach ($notas_de_credito as $index => $nota_de_credito)

                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($nota_de_credito->FechaEmision)->format('d/m/Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($nota_de_credito->FechaVencimiento)->format('d/m/Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($nota_de_credito->FechaRegistro)->format('d/m/Y') }}</td>
                                    <td>{{ $nota_de_credito->NumeroCompleto }}</td>
                                    <td>{{ $nota_de_credito->facturaCompra->NumeroCompleto }}</td>
                                    <td>{{  number_format($nota_de_credito->Neto, 2, '.', '') }}</td>
                                    <td>{{  number_format($nota_de_credito->IVA, 2, '.', '') }}</td>
                                    <td>{{  number_format($nota_de_credito->Total, 2, '.', '') }}</td>
                                    <td>{{ $nota_de_credito->Estado }}</td>
                                </tr>

                                {{-- <tr class="expandable-body" style="display: {{ in_array($nota_de_credito->id, $expanded) ? 'table-row' : 'none' }};">

                                    <td colspan="9">
                                        <div class="p-0">
                                            <table class="table table-sm table-bordered mb-0">
                                                <thead>
                                                <tr>
                                                    <th>CODIGO</th>
                                                    <th>DESCRIPCION</th>
                                                    <th>CANTIDAD</th>
                                                    <th>PRECIO UNITARIO</th>
                                                    <th>% IVA</th>
                                                    <th>SUBTOTAL</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($nota_de_credito->itemsNotaCredito as $index => $item_nota_credito)
                                                        <tr>
                                                            <td>{{ $item_nota_credito->IdArticulo }}</td>
                                                            <td>{{ $item_nota_credito->Descripcion }}</td>
                                                            <td>{{ number_format($item_nota_credito->Cantidad, 2, '.', '') }}</td>
                                                            <td>{{ number_format($item_nota_credito->PrecioUnitario, 2, '.', '') }}</td>
                                                            <td>{{ number_format($item_nota_credito->AlicuotaIVA, 2, '.', '') }}</td>
                                                            <td>{{ number_format($item_nota_credito->Neto, 2, '.', '') }}</td>
                                                        </tr>
                                                    @endforeach

                                                    @php
                                                        $filasFaltantes = max(0, 6 - count($nota_de_credito->itemsNotaCredito));
                                                    @endphp

                                                    @for ($i = 0; $i < $filasFaltantes; $i++)
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                            <td>&nbsp;</td>
                                                            <td>&nbsp;</td>
                                                            <td>&nbsp;</td>
                                                            <td>&nbsp;</td>
                                                            <td>&nbsp;</td>
                                                        </tr>
                                                    @endfor
                                                </tbody>
                                            </table>
                                        </div>
                                    </td>

                                </tr> --}}

                            @endforeach

                            @php
                                $filasFaltantes = max(0, 10 - count($notas_de_credito));
                            @endphp

                            @for ($i = 0; $i < $filasFaltantes; $i++)
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                            @endfor

                        </x-slot>

                    </x-data-table-acordion3>

                </div>


                <div class="tab-pane fade show {{ $activeTabParametros === 'custom-tabs-4' ? 'active' : '' }}" id="custom-tabs-4" role="tabpanel" aria-labelledby="custom-tabs-4-tab">

                    <div class="row mb-3">

                        <div class="col-2">
                            <div class="form-group mb-0">
                                <label for="filtro1" class="font-weight-normal">Desde fecha</label>
                                <input type="date" id="filtro1" name="filtro1" wire:model.live="nd_desde" class="form-control form-control-sm" value="{">
                            </div>
                        </div>

                        <div class="col-2">
                            <div class="form-group mb-0">
                                <label for="filtro1" class="font-weight-normal">Hasta fecha</label>
                                <input type="date" id="filtro1" name="filtro1" wire:model.live="nd_hasta" class="form-control form-control-sm" value="">
                            </div>
                        </div>

                    </div>

                    <x-data-table-acordion3>

                        <x-slot name="thead">
                            <tr class="bg-secondary text-white">
                                <th>FECHA</th>
                                <th>VENCIMIENTO</th>
                                <th>NUMERO</th>
                                <th>N° DOC. ASOCIADO</th>
                                <th>SUBTOTAL</th>
                                <th>IVA</th>
                                <th>IMPORTE</th>
                                <th>ESTADO</th>
                            </tr>   
                        </x-slot>

                        <x-slot name="tbody">

                            @foreach ($notas_de_debito as $index => $nota_de_debito)

                                <tr>

                                    <td>{{ \Carbon\Carbon::parse($nota_de_debito->FechaEmision)->format('d/m/Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($nota_de_debito->FechaVencimiento)->format('d/m/Y') }}</td>
                                    <td>{{ $nota_de_debito->NumeroCompleto }}</td>
                                    <td>{{ $nota_de_debito->NroFacturaNotaDebito }}</td>
                                    <td>{{  number_format($nota_de_debito->Neto, 2, '.', '') }}</td>
                                    <td>{{  number_format($nota_de_debito->IVA, 2, '.', '') }}</td>
                                    <td>{{  number_format($nota_de_debito->Total, 2, '.', '') }}</td>
                                    <td>{{ $nota_de_debito->Estado }}</td>
                                </tr>

                                {{-- <tr class="expandable-body" style="display: {{ in_array($nota_de_debito->id, $expanded) ? 'table-row' : 'none' }};">

                                    <td colspan="9">
                                        <div class="p-0">
                                            <table class="table table-sm table-bordered mb-0">
                                                <thead>
                                                <tr>
                                                    <th>CODIGO</th>
                                                    <th>DESCRIPCION</th>
                                                    <th>CANTIDAD</th>
                                                    <th>PRECIO UNITARIO</th>
                                                    <th>% IVA</th>
                                                    <th>SUBTOTAL</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($nota_de_debito->itemsFacturaVenta as $index => $item_nota_debito)
                                                        <tr>
                                                            <td>{{ $item_nota_debito->ItemNumero }}</td>
                                                            <td>{{ $item_nota_debito->Descripcion }}</td>
                                                            <td>{{ number_format($item_nota_debito->Cantidad, 2, '.', '') }}</td>
                                                            <td>{{ number_format($item_nota_debito->PrecioUnitario, 2, '.', '') }}</td>
                                                            <td>{{ number_format($item_nota_debito->AlicuotaIVA, 2, '.', '') }}</td>
                                                            <td>{{ number_format($item_nota_debito->Neto, 2, '.', '') }}</td>
                                                        </tr>
                                                    @endforeach

                                                    @php
                                                        $filasFaltantes = max(0, 6 - count($nota_de_debito->itemsFacturaVenta));
                                                    @endphp

                                                    @for ($i = 0; $i < $filasFaltantes; $i++)
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                            <td>&nbsp;</td>
                                                            <td>&nbsp;</td>
                                                            <td>&nbsp;</td>
                                                            <td>&nbsp;</td>
                                                            <td>&nbsp;</td>
                                                        </tr>
                                                    @endfor
                                                </tbody>
                                            </table>
                                        </div>
                                    </td>

                                </tr> --}}

                            @endforeach

                            @php
                                $filasFaltantes = max(0, 10 - count($notas_de_debito));
                            @endphp

                            @for ($i = 0; $i < $filasFaltantes; $i++)
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                            @endfor

                        </x-slot>

                    </x-data-table-acordion3>

                </div>


                <div class="tab-pane fade show {{ $activeTabParametros === 'custom-tabs-5' ? 'active' : '' }}" id="custom-tabs-5" role="tabpanel" aria-labelledby="custom-tabs-5-tab">

                    <div class="row mb-3">

                        <div class="col-2">
                            <div class="form-group mb-0">
                                <label for="filtro1" class="font-weight-normal">Desde fecha</label>
                                <input type="date" id="filtro1" name="filtro1" wire:model.live="min_desde" class="form-control form-control-sm" value="{">
                            </div>
                        </div>

                        <div class="col-2">
                            <div class="form-group mb-0">
                                <label for="filtro1" class="font-weight-normal">Hasta fecha</label>
                                <input type="date" id="filtro1" name="filtro1" wire:model.live="min_hasta" class="form-control form-control-sm" value="">
                            </div>
                        </div>

                    </div>

                    <x-data-table-acordion3>

                        <x-slot name="thead">
                            <tr class="bg-secondary text-white">
                                <th>FECHA</th>
                                <th>NUMERO</th>
                                <th>TOTAL</th>
                                <th>ESTADO</th>
                            </tr>   
                        </x-slot>

                        <x-slot name="tbody">

                            @foreach ($minutas as $index => $minuta)

                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($minuta->FechaEmision)->format('d/m/Y') }}</td>
                                    <td>{{ $minuta->NumeroCompleto }}</td>
                                    <td>{{ number_format($minuta->Total, 2, '.', '') }}</td>
                                    <td>{{ $minuta->Estado }}</td>
                                </tr>

                            @endforeach

                            @php
                                $filasFaltantes = max(0, 10 - count($minutas));
                            @endphp

                            @for ($i = 0; $i < $filasFaltantes; $i++)
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                            @endfor

                        </x-slot>

                    </x-data-table-acordion3>

                </div>

            </x-slot>

        </x-panel-horizontal2>

    <!-- .modal -->
    <div class="modal fade" id="modal-create-nd" wire:ignore.self wire:key="modal-nd">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title">
                    PARAMETROS NOTA DE DEBITO
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
                                            <label for="filtro1" class="font-weight-normal">Desde fecha</label>
                                            <input type="date" id="filtro1" name="filtro1" value="{{ \Carbon\Carbon::now()->subMonth()->format('Y-m-d') }}" class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group mb-0">
                                            <label for="filtro2" class="font-weight-normal">Hasta fecha</label>
                                            <input type="date" id="filtro2" name="filtro1" value="{{ \Carbon\Carbon::today()->format('Y-m-d') }}" class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <div class="form-group mb-0">
                                            <label for="filtro2" class="font-weight-normal">Número de comprobante</label>
                                            <input type="text" id="filtro2" name="filtro1" class="form-control form-control-sm">
                                        </div>
                                    </div>
                                </div>

                            </x-slot>

                            <x-slot name="thead">
                                <tr>
                                    <th>FECHA</th>
                                    <th>NUMERO</th>
                                    <th>ESTADO</th>
                                    <th>IMPORTE</th>
                                </tr>
                            </x-slot>
                            <x-slot name="tbody">
                                
                                @forelse ($facturas_pendientes_completas as $factura_pendiente_completa)
                                    <tr wire:click.prevent="seleccionarCliente({{ $factura_pendiente_completa->id }})"
                                        style="cursor:pointer;"
                                        class="{{ $factura_venta_id == $factura_pendiente_completa->id ? 'table-primary' : '' }}">
                                        <td>{{ \Carbon\Carbon::parse($factura_pendiente_completa->FechaEmision)->format('d/m/Y') }}</td>
                                        <td style="width: 200px;">
                                            {{ $factura_pendiente_completa->NumeroCompleto }}
                                        </td>
                                        <td>{{ $factura_pendiente_completa->Estado }}</td>
                                        <td>{{ number_format($factura_pendiente_completa->Total, 2, '.', '') }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="8">No se encontraron resultados.</td></tr>
                                @endforelse
                            </x-slot>
                        </x-simple-table2>

                    </div>
                    </div>
                    </div>

                </div>

                <div class="modal-footer justify-content-end">

                    <a href="{{ route('compras.ficha-del-proveedor.nota-debito.create', [$proveedor, $factura_venta_id]) }}" class="btn btn-sidebar btn-sm bg-orange">
                        <span class="text-white">Aceptar</span>
                        <i class="fas fa-check fa-fw text-white ml-2"></i>
                    </a>

                    <button class="btn btn-sidebar btn-sm bg-orange" data-dismiss="modal">
                        <span class="text-white">Cancelar</span>
                        <i class="fas fa-xmark fa-fw text-white ml-2"></i>
                    </button>

                </div>

            </div>
        </div>
    </div>
    <!-- /.modal -->

    <!-- .modal -->
    <div class="modal fade" id="modal-create-nc" wire:ignore.self wire:key="modal-nc">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title">
                    PARAMETROS NOTA DE CREDITO
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
                                        <label for="filtro1" class="font-weight-normal">Desde fecha</label>
                                        <input type="date" id="filtro1" name="filtro1" value="{{ \Carbon\Carbon::now()->subMonth()->format('Y-m-d') }}" class="form-control form-control-sm">
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group mb-0">
                                        <label for="filtro2" class="font-weight-normal">Hasta fecha</label>
                                        <input type="date" id="filtro2" name="filtro1" value="{{ \Carbon\Carbon::today()->format('Y-m-d') }}" class="form-control form-control-sm">
                                    </div>
                                </div>
                                <div class="col-5">
                                    <div class="form-group mb-0">
                                        <label for="filtro2" class="font-weight-normal">Número de comprobante</label>
                                        <input type="text" id="filtro2" name="filtro1" class="form-control form-control-sm">
                                    </div>
                                </div>
                            </div>

                        </x-slot>

                        <x-slot name="thead">
                            <tr>
                                <th>FECHA</th>
                                <th>NUMERO</th>
                                <th>ESTADO</th>
                                <th>IMPORTE</th>
                                <th>PENDIENTE</th>
                            </tr>
                        </x-slot>
                        <x-slot name="tbody">
                            
                            @forelse ($facturas_pendientes as $factura_pendiente)
                                <tr wire:click.prevent="seleccionarCliente({{ $factura_pendiente->id }})"
                                    style="cursor:pointer;"
                                    class="{{ $factura_venta_id == $factura_pendiente->id ? 'table-primary' : '' }}">
                                    <td>{{ \Carbon\Carbon::parse($factura_pendiente->FechaEmision)->format('d/m/Y') }}</td>
                                    <td style="width: 200px;">
                                        {{ $factura_pendiente->NumeroCompleto }}
                                    </td>
                                    <td>{{ $factura_pendiente->Estado }}</td>
                                    <td>{{ number_format($factura_pendiente->Total, 2, '.', '') }}</td>
                                    @php
                                        $notas_credito_venta = \App\Models\NotaCreditoVenta::where('IdFacturaVenta', $factura_pendiente->id)->get();
                                        $pendiente = $factura_pendiente->Total - $notas_credito_venta->sum('Total');
                                    @endphp
                                    <td>{{ number_format($pendiente, 2, '.', '') }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="8">No se encontraron resultados.</td></tr>
                            @endforelse
                        </x-slot>
                    </x-simple-table2>

                </div>

                </div>

                <div class="modal-footer justify-content-start">

                    <a href="{{ route('compras.ficha-del-proveedor.nota-credito.create', [$proveedor, $factura_venta_id]) }}" class="btn btn-sidebar btn-sm bg-orange">
                        <span class="text-white">Aceptar</span>
                        <i class="fas fa-check fa-fw text-white ml-2"></i>
                    </a>

                    <button class="btn btn-sidebar btn-sm bg-orange" data-dismiss="modal">
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