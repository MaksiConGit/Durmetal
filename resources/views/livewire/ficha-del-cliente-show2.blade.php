<div>

    <x-layout2-sidebar>
        <x-slot name="title">Ficha del cliente</x-slot>

        <x-slot name="filtros">

            <div class="form-inline mt-5 mr-3 d-flex flex-column align-items-center">

                <div class="form-group mb-3">
                    <a href="{{ route('orden-trabajo.create') }}" 
                    class="btn btn-app bg-primary">
                        <i class="fas fa-plus"></i> Nuevo
                    </a>
                </div>

                <div class="form-group mb-3">
                    <a href="{{ $selectedId ? route('programacion.edit', $selectedId) : '#' }}" 
                    class="btn btn-app bg-primary {{ !$selectedId ? 'disabled' : '' }}">
                        <i class="fas fa-pen"></i> Modificar
                    </a>
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
                        >
                        <i class="fas fa-xmark"></i> Eliminar
                        </button>
                    </form>
                </div>

            </div>

        </x-slot>

        <div class="row">
            <div class="col-6">
                
                <h3><i class="fa-solid fa-image-portrait"></i> ({{ $cliente->id }}) {{ $cliente->Nombre }}</h3>
            </div>
            <div class="col-4"></div>
            <div class="col-2">
                
                <h3>${{ $cliente->Saldo }} <i class="fa-solid fa-money-bills"></i></h3>
            </div>
        </div>

    
        <x-panel-horizontal2>

            <x-slot name="pestañas">

                <li class="nav-item">
                    <a class="nav-link {{ $activeTabParametros === 'custom-tabs-1' ? 'active' : '' }}" wire:click.prevent="setActiveTabParametros('custom-tabs-1')" id="custom-tabs-1-tab" data-toggle="pill" href="#custom-tabs-1" role="tab" aria-controls="custom-tabs-1" aria-selected="true">ORDENES DE TRABAJO</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $activeTabParametros === 'custom-tabs-2' ? 'active' : '' }}" wire:click.prevent="setActiveTabParametros('custom-tabs-2')" id="custom-tabs-2-tab" data-toggle="pill" href="#custom-tabs-2" role="tab" aria-controls="custom-tabs-2" aria-selected="true">NOTAS DE ENVIO</a>
                </li>
                <li class="nav-item {{ $activeTabParametros === 'custom-tabs-3' ? 'active' : '' }}" wire:click.prevent="setActiveTabParametros('custom-tabs-3')">
                    <a class="nav-link" id="custom-tabs-3-tab" data-toggle="pill" href="#custom-tabs-3" role="tab" aria-controls="custom-tabs-3" aria-selected="true">FACTURAS</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $activeTabParametros === 'custom-tabs-4' ? 'active' : '' }}" wire:click.prevent="setActiveTabParametros('custom-tabs-4')" id="custom-tabs-4-tab" data-toggle="pill" href="#custom-tabs-4" role="tab" aria-controls="custom-tabs-4" aria-selected="true">RECIBOS</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $activeTabParametros === 'custom-tabs-5' ? 'active' : '' }}" wire:click.prevent="setActiveTabParametros('custom-tabs-5')" id="custom-tabs-5-tab" data-toggle="pill" href="#custom-tabs-5" role="tab" aria-controls="custom-tabs-5" aria-selected="true">NOTAS DE CREDITO</a>
                </li>
                <li class="nav-item {{ $activeTabParametros === 'custom-tabs-6' ? 'active' : '' }}" wire:click.prevent="setActiveTabParametros('custom-tabs-6')">
                    <a class="nav-link" id="custom-tabs-6-tab" data-toggle="pill" href="#custom-tabs-6" role="tab" aria-controls="custom-tabs-6" aria-selected="true">NOTAS DE DEBITO</a>
                </li>
                <li class="nav-item {{ $activeTabParametros === 'custom-tabs-7' ? 'active' : '' }}" wire:click.prevent="setActiveTabParametros('custom-tabs-7')">
                    <a class="nav-link" id="custom-tabs-7-tab" data-toggle="pill" href="#custom-tabs-7" role="tab" aria-controls="custom-tabs-7" aria-selected="true">MINUTAS</a>
                </li>

            </x-slot>

            <x-slot name="ventanas">

                <div class="tab-pane fade show {{ $activeTabParametros === 'custom-tabs-1' ? 'active' : '' }}" id="custom-tabs-1" role="tabpanel" aria-labelledby="custom-tabs-1-tab">

                    <div class="row mb-3">

                        <div class="col-2">
                            <div class="form-group mb-0">
                                <label for="filtro1" class="font-weight-normal">Desde fecha</label>
                                <input type="date" id="filtro1" name="filtro1" wire:model.live="fecha_desde" class="form-control form-control-sm" value="{">
                            </div>
                        </div>

                        <div class="col-2">
                            <div class="form-group mb-0">
                                <label for="filtro1" class="font-weight-normal">Hasta fecha</label>
                                <input type="date" id="filtro1" name="filtro1" wire:model.live="fecha_hasta" class="form-control form-control-sm" value="">
                            </div>
                        </div>

                    </div>

                    <x-data-table-acordion2>

                        <x-slot name="thead">
                            <tr class="bg-secondary text-white">
                                <th>FECHA</th>
                                <th>NUMERO</th>
                                <th>RAZON SOCIAL</th>
                                <th>ESTADO</th>
                                <th><i class="fa-solid fa-print"></i></th>
                                <th><i class="fa-solid fa-envelope"></i></th>
                            </tr>   
                        </x-slot>

                        <x-slot name="tbody">

                            @foreach ($ordenes_trabajo as $index => $orden_trabajo)

                                <tr data-widget="expandable-table" 
                                    aria-expanded="{{ in_array($orden_trabajo->id, $expanded) ? 'true' : 'false' }}"
                                    wire:click="toggleExpand('{{ $orden_trabajo->id }}')">
                                    <td>{{ \Carbon\Carbon::parse($orden_trabajo->FechaEmision)->format('d/m/Y') }}</td>
                                    <td>{{ $orden_trabajo->NumeroCompleto }}</td>
                                    <td>{{ $orden_trabajo->cliente->Nombre ?? 'Sin razón social' }}</td>
                                    <td>{{ $orden_trabajo->Estado }}</td>
                                    <td>{{ $orden_trabajo->CantidadImpresiones }}</td>
                                    <td>{{ $orden_trabajo->CantidadEnviosPorCorreo }}</td>
                                </tr>

                                <tr class="expandable-body" style="display: {{ in_array($orden_trabajo->id, $expanded) ? 'table-row' : 'none' }};">

                                    <td colspan="15">
                                        <div class="p-0">
                                            <table class="table table-sm table-bordered mb-0">
                                                <thead>
                                                <tr class="bg-dark text-white">
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

                                </tr>

                            @endforeach

                            @php
                                $filasFaltantes = max(0, 10 - count($ordenes_trabajo));
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

                    </x-data-table-acordion2>

                </div>


                <div class="tab-pane fade show {{ $activeTabParametros === 'custom-tabs-2' ? 'active' : '' }}" id="custom-tabs-2" role="tabpanel" aria-labelledby="custom-tabs-2-tab">

                    <div class="row mb-3">

                        <div class="col-2">
                            <div class="form-group mb-0">
                                <label for="filtro1" class="font-weight-normal">Desde fecha</label>
                                <input type="date" id="filtro1" name="filtro1" wire:model.live="fecha_desde" class="form-control form-control-sm" value="{">
                            </div>
                        </div>

                        <div class="col-2">
                            <div class="form-group mb-0">
                                <label for="filtro1" class="font-weight-normal">Hasta fecha</label>
                                <input type="date" id="filtro1" name="filtro1" wire:model.live="fecha_hasta" class="form-control form-control-sm" value="">
                            </div>
                        </div>

                    </div>

                    <x-data-table-acordion2>

                        <x-slot name="thead">
                            <tr class="bg-secondary text-white">
                                <th>FECHA</th>
                                <th>NUMERO</th>
                                <th>N° DOC. ASOCIADO</th>
                                <th>RAZON SOCIAL</th>
                                <th>% DESCUENTO</th>
                                <th>SUBTOTAL</th>
                                <th>IVA</th>
                                <th>TOTAL</th>
                                <th>ESTADO</th>
                                <th><i class="fa-solid fa-print"></i></th>
                                <th><i class="fa-solid fa-envelope"></i></th>
                            </tr>   
                        </x-slot>

                        <x-slot name="tbody">

                            @foreach ($notas_de_envio as $index => $nota_de_envio)

                                <tr data-widget="expandable-table" 
                                    aria-expanded="{{ in_array($nota_de_envio->id, $expanded) ? 'true' : 'false' }}"
                                    wire:click="toggleExpand('{{ $nota_de_envio->id }}')">
                                    <td>{{ \Carbon\Carbon::parse($nota_de_envio->FechaEmision)->format('d/m/Y') }}</td>
                                    <td>{{ $nota_de_envio->NumeroCompleto }}</td>
                                    <td></td>
                                    <td>{{ $nota_de_envio->cliente->Nombre ?? 'Sin razón social' }}</td>
                                    <td>{{  number_format($nota_de_envio->PorcentajeDescuento, 2, '.', '') }}</td>
                                    <td>{{  number_format($nota_de_envio->Neto, 2, '.', '') }}</td>
                                    <td>{{  number_format($nota_de_envio->IVA, 2, '.', '') }}</td>
                                    <td>{{  number_format($nota_de_envio->Total, 2, '.', '') }}</td>
                                    <td>{{ $nota_de_envio->Estado }}</td>
                                    <td>{{ $nota_de_envio->CantidadImpresiones }}</td>
                                    <td>{{ $nota_de_envio->CantidadEnviosPorCorreo }}</td>
                                </tr>

                                <tr class="expandable-body" style="display: {{ in_array($nota_de_envio->id, $expanded) ? 'table-row' : 'none' }};">

                                    <td colspan="15">
                                        <div class="p-0">
                                            <table class="table table-sm table-bordered mb-0">
                                                <thead>
                                                <tr class="bg-dark text-white">
                                                    <th>N°</th>
                                                    <th>OTI</th>
                                                    <th>DESCRIPCION</th>
                                                    <th>CANT.</th>
                                                    <th>PESO</th>
                                                    <th>CC</th>
                                                    <th>COEFIC.</th>
                                                    <th>PRECIO U.</th>
                                                    <th>% DESC</th>
                                                    <th>TOTAL</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($nota_de_envio->itemsNotaEnvio as $index => $item_nota_envio)
                                                        <tr>
                                                            <td>{{ $item_orden_trabajo->ItemNumero }}</td>
                                                            <td>{{ $item_nota_envio->itemOrdenTrabajo->ordenTrabajo->NumeroCompleto }}</td>
                                                            <td>{{ $item_nota_envio->Descripcion }}</td>
                                                            <td>{{ $item_nota_envio->Cantidad }}</td>
                                                            <td>{{ $item_nota_envio->Peso }}</td>
                                                            <td>{{ $item_nota_envio->CodigoComplejidad }}</td>
                                                            <td>{{ $item_nota_envio->Coeficiente }}</td>
                                                            <td>{{ $item_nota_envio->PrecioUnitario }}</td>
                                                            <td>{{ $item_nota_envio->PorcentajeDescuento }}</td>
                                                            <td>{{ $item_nota_envio->Total }}</td>
                                                        </tr>
                                                    @endforeach

                                                    @php
                                                        $filasFaltantes = max(0, 6 - count($nota_de_envio->itemsNotaEnvio));
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
                                                            <td>&nbsp;</td>
                                                        </tr>
                                                    @endfor
                                                </tbody>
                                            </table>
                                        </div>
                                    </td>

                                </tr>

                            @endforeach

                            @php
                                $filasFaltantes = max(0, 10 - count($notas_de_envio));
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
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                            @endfor

                        </x-slot>

                    </x-data-table-acordion2>

                </div>


                <div class="tab-pane fade show {{ $activeTabParametros === 'custom-tabs-3' ? 'active' : '' }}" id="custom-tabs-3" role="tabpanel" aria-labelledby="custom-tabs-3-tab">

                    <div class="row mb-3">

                        <div class="col-2">
                            <div class="form-group mb-0">
                                <label for="filtro1" class="font-weight-normal">Desde fecha</label>
                                <input type="date" id="filtro1" name="filtro1" wire:model.live="fecha_desde" class="form-control form-control-sm" value="{">
                            </div>
                        </div>

                        <div class="col-2">
                            <div class="form-group mb-0">
                                <label for="filtro1" class="font-weight-normal">Hasta fecha</label>
                                <input type="date" id="filtro1" name="filtro1" wire:model.live="fecha_hasta" class="form-control form-control-sm" value="">
                            </div>
                        </div>

                    </div>

                    <x-data-table-acordion2>

                        <x-slot name="thead">
                            <tr class="bg-secondary text-white">
                                <th>FECHA</th>
                                <th>NUMERO</th>
                                <th>RAZON SOCIAL</th>
                                <th>SUBTOTAL</th>
                                <th>IVA</th>
                                <th>TOTAL</th>
                                <th>ESTADO</th>
                                <th><i class="fa-solid fa-print"></i></th>
                                <th><i class="fa-solid fa-envelope"></i></th>
                            </tr>   
                        </x-slot>

                        <x-slot name="tbody">

                            @foreach ($facturas as $index => $factura)

                                <tr data-widget="expandable-table" 
                                    aria-expanded="{{ in_array($factura->id, $expanded) ? 'true' : 'false' }}"
                                    wire:click="toggleExpand('{{ $factura->id }}')">

                                    <td>{{ \Carbon\Carbon::parse($factura->FechaEmision)->format('d/m/Y') }}</td>
                                    <td>{{ $factura->NumeroCompleto }}</td>
                                    <td>{{ $factura->RazonSocial }}</td>
                                    <td>{{  number_format($factura->Neto, 2, '.', '') }}</td>
                                    <td>{{  number_format($factura->IVA, 2, '.', '') }}</td>
                                    <td>{{  number_format($factura->Total, 2, '.', '') }}</td>
                                    <td>{{ $factura->Estado }}</td>
                                    <td>{{ $factura->CantidadImpresiones }}</td>
                                    <td>{{ $factura->CantidadEnviosPorCorreo }}</td>
                                </tr>

                                {{-- <tr class="expandable-body" style="display: {{ in_array($factura->id, $expanded) ? 'table-row' : 'none' }};">

                                    <td colspan="15">
                                        <div class="p-0">
                                            <table class="table table-sm table-bordered mb-0">
                                                <thead>
                                                <tr class="bg-dark text-white">
                                                    <th>N°</th>
                                                    <th>OTI</th>
                                                    <th>DESCRIPCION</th>
                                                    <th>CANT.</th>
                                                    <th>PESO</th>
                                                    <th>CC</th>
                                                    <th>COEFIC.</th>
                                                    <th>PRECIO U.</th>
                                                    <th>% DESC</th>
                                                    <th>TOTAL</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($nota_de_envio->itemsNotaEnvio as $index => $item_nota_envio)
                                                        <tr>
                                                            <td>{{ $item_orden_trabajo->ItemNumero }}</td>
                                                            <td>{{ $item_nota_envio->itemOrdenTrabajo->ordenTrabajo->NumeroCompleto }}</td>
                                                            <td>{{ $item_nota_envio->Descripcion }}</td>
                                                            <td>{{ $item_nota_envio->Cantidad }}</td>
                                                            <td>{{ $item_nota_envio->Peso }}</td>
                                                            <td>{{ $item_nota_envio->CodigoComplejidad }}</td>
                                                            <td>{{ $item_nota_envio->Coeficiente }}</td>
                                                            <td>{{ $item_nota_envio->PrecioUnitario }}</td>
                                                            <td>{{ $item_nota_envio->PorcentajeDescuento }}</td>
                                                            <td>{{ $item_nota_envio->Total }}</td>
                                                        </tr>
                                                    @endforeach

                                                    @php
                                                        $filasFaltantes = max(0, 6 - count($nota_de_envio->itemsNotaEnvio));
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
                                $filasFaltantes = max(0, 10 - count($notas_de_envio));
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

                    </x-data-table-acordion2>

                </div>

                <div class="tab-pane fade show {{ $activeTabParametros === 'custom-tabs-4' ? 'active' : '' }}" id="custom-tabs-4" role="tabpanel" aria-labelledby="custom-tabs-4-tab">

                    <div class="row mb-3">

                        <div class="col-2">
                            <div class="form-group mb-0">
                                <label for="filtro1" class="font-weight-normal">Desde fecha</label>
                                <input type="date" id="filtro1" name="filtro1" wire:model.live="fecha_desde" class="form-control form-control-sm" value="{">
                            </div>
                        </div>

                        <div class="col-2">
                            <div class="form-group mb-0">
                                <label for="filtro1" class="font-weight-normal">Hasta fecha</label>
                                <input type="date" id="filtro1" name="filtro1" wire:model.live="fecha_hasta" class="form-control form-control-sm" value="">
                            </div>
                        </div>

                    </div>

                    <x-data-table-acordion2>

                        <x-slot name="thead">
                            <tr class="bg-secondary text-white">
                                <th>FECHA</th>
                                <th>NUMERO</th>
                                <th>RAZON SOCIAL</th>
                                <th>TOTAL</th>
                                <th>SALDO TRANSP.</th>
                                <th>ESTADO</th>
                                <th><i class="fa-solid fa-print"></i></th>
                                <th><i class="fa-solid fa-envelope"></i></th>
                            </tr>   
                        </x-slot>

                        <x-slot name="tbody">

                            @foreach ($recibos as $index => $recibo)

                                <tr data-widget="expandable-table" 
                                    aria-expanded="{{ in_array($recibo->id, $expanded) ? 'true' : 'false' }}"
                                    wire:click="toggleExpand('{{ $recibo->id }}')">

                                    <td>{{ \Carbon\Carbon::parse($recibo->FechaEmision)->format('d/m/Y') }}</td>
                                    <td>{{ $recibo->NumeroCompleto }}</td>
                                    <td>{{ $recibo->RazonSocial }}</td>
                                    <td>{{  number_format($recibo->Total, 2, '.', '') }}</td>
                                    <td>{{  number_format($recibo->ImporteSaldoTransportado, 2, '.', '') }}</td>
                                    <td>{{ $recibo->Estado }}</td>
                                    <td>{{ $recibo->CantidadImpresiones }}</td>
                                    <td>{{ $recibo->CantidadEnviosPorCorreo }}</td>
                                </tr>

                                <tr class="expandable-body" style="display: {{ in_array($recibo->id, $expanded) ? 'table-row' : 'none' }};">

                                    <td colspan="9">
                                        <div class="p-0">
                                            <table class="table table-sm table-bordered mb-0">
                                                <thead>
                                                <tr class="bg-dark text-white">
                                                    <th>DESCRIPCION</th>
                                                    <th>TOTAL</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($recibo->itemsReciboVenta as $index => $item_recibo_venta)
                                                        <tr>
                                                            <td>{{ $item_recibo_venta->Descripcion }}</td>
                                                            <td>{{ number_format($item_recibo_venta->Total, 2, '.', '') }}</td>
                                                        </tr>
                                                    @endforeach

                                                    @php
                                                        $filasFaltantes = max(0, 5 - count($nota_de_envio->itemsNotaEnvio));
                                                    @endphp

                                                    @for ($i = 0; $i < $filasFaltantes; $i++)
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                            <td>&nbsp;</td>
                                                        </tr>
                                                    @endfor
                                                </tbody>
                                            </table>
                                        </div>
                                    </td>

                                </tr>

                            @endforeach

                            @php
                                $filasFaltantes = max(0, 10 - count($recibos));
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

                    </x-data-table-acordion2>

                </div>


                <div class="tab-pane fade show {{ $activeTabParametros === 'custom-tabs-5' ? 'active' : '' }}" id="custom-tabs-5" role="tabpanel" aria-labelledby="custom-tabs-5-tab">

                    <div class="row mb-3">

                        <div class="col-2">
                            <div class="form-group mb-0">
                                <label for="filtro1" class="font-weight-normal">Desde fecha</label>
                                <input type="date" id="filtro1" name="filtro1" wire:model.live="fecha_desde" class="form-control form-control-sm" value="{">
                            </div>
                        </div>

                        <div class="col-2">
                            <div class="form-group mb-0">
                                <label for="filtro1" class="font-weight-normal">Hasta fecha</label>
                                <input type="date" id="filtro1" name="filtro1" wire:model.live="fecha_hasta" class="form-control form-control-sm" value="">
                            </div>
                        </div>

                    </div>

                    <x-data-table-acordion2>

                        <x-slot name="thead">
                            <tr class="bg-secondary text-white">
                                <th>FECHA</th>
                                <th>NUMERO</th>
                                <th>N° DOC. ASOCIADO</th>
                                <th>RAZON SOCIAL</th>
                                <th>SUBTOTAL</th>
                                <th>IVA</th>
                                <th>TOTAL</th>
                                <th>ESTADO</th>
                                <th><i class="fa-solid fa-print"></i></th>
                                <th><i class="fa-solid fa-envelope"></i></th>
                            </tr>   
                        </x-slot>

                        <x-slot name="tbody">

                            @foreach ($notas_de_credito as $index => $nota_de_credito)

                                <tr data-widget="expandable-table" 
                                    aria-expanded="{{ in_array($nota_de_credito->id, $expanded) ? 'true' : 'false' }}"
                                    wire:click="toggleExpand('{{ $nota_de_credito->id }}')">

                                    <td>{{ \Carbon\Carbon::parse($nota_de_credito->FechaEmision)->format('d/m/Y') }}</td>
                                    <td>{{ $nota_de_credito->NumeroCompleto }}</td>
                                    <td>{{ $nota_de_credito->facturaVenta->NumeroCompleto }}</td>
                                    <td>{{ $nota_de_credito->RazonSocial }}</td>
                                    <td>{{  number_format($nota_de_credito->Neto, 2, '.', '') }}</td>
                                    <td>{{  number_format($nota_de_credito->IVA, 2, '.', '') }}</td>
                                    <td>{{  number_format($nota_de_credito->Total, 2, '.', '') }}</td>
                                    <td>{{ $nota_de_credito->Estado }}</td>
                                    <td>{{ $nota_de_credito->CantidadImpresiones }}</td>
                                    <td>{{ $nota_de_credito->CantidadEnviosPorCorreo }}</td>
                                </tr>

                                <tr class="expandable-body" style="display: {{ in_array($nota_de_credito->id, $expanded) ? 'table-row' : 'none' }};">

                                    <td colspan="9">
                                        <div class="p-0">
                                            <table class="table table-sm table-bordered mb-0">
                                                <thead>
                                                <tr class="bg-dark text-white">
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

                                </tr>

                            @endforeach

                            @php
                                $filasFaltantes = max(0, 10 - count($recibos));
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
                                    <td>&nbsp;</td>
                                </tr>
                            @endfor

                        </x-slot>

                    </x-data-table-acordion2>

                </div>


                <div class="tab-pane fade show {{ $activeTabParametros === 'custom-tabs-6' ? 'active' : '' }}" id="custom-tabs-6" role="tabpanel" aria-labelledby="custom-tabs-6-tab">

                    <div class="row mb-3">

                        <div class="col-2">
                            <div class="form-group mb-0">
                                <label for="filtro1" class="font-weight-normal">Desde fecha</label>
                                <input type="date" id="filtro1" name="filtro1" wire:model.live="fecha_desde" class="form-control form-control-sm" value="{">
                            </div>
                        </div>

                        <div class="col-2">
                            <div class="form-group mb-0">
                                <label for="filtro1" class="font-weight-normal">Hasta fecha</label>
                                <input type="date" id="filtro1" name="filtro1" wire:model.live="fecha_hasta" class="form-control form-control-sm" value="">
                            </div>
                        </div>

                    </div>

                    <x-data-table-acordion2>

                        <x-slot name="thead">
                            <tr class="bg-secondary text-white">
                                <th>FECHA</th>
                                <th>NUMERO</th>
                                <th>N° DOC. ASOCIADO</th>
                                <th>RAZON SOCIAL</th>
                                <th>SUBTOTAL</th>
                                <th>IVA</th>
                                <th>TOTAL</th>
                                <th>ESTADO</th>
                                <th><i class="fa-solid fa-print"></i></th>
                                <th><i class="fa-solid fa-envelope"></i></th>
                            </tr>   
                        </x-slot>

                        <x-slot name="tbody">

                            @foreach ($notas_de_debito as $index => $nota_de_debito)

                                <tr data-widget="expandable-table" 
                                    aria-expanded="{{ in_array($nota_de_debito->id, $expanded) ? 'true' : 'false' }}"
                                    wire:click="toggleExpand('{{ $nota_de_debito->id }}')">

                                    <td>{{ \Carbon\Carbon::parse($nota_de_debito->FechaEmision)->format('d/m/Y') }}</td>
                                    <td>{{ $nota_de_debito->NumeroCompleto }}</td>
                                    <td>{{ $nota_de_debito->NroFacturaNotaDebito }}</td>
                                    <td>{{ $nota_de_debito->RazonSocial }}</td>
                                    <td>{{  number_format($nota_de_debito->Neto, 2, '.', '') }}</td>
                                    <td>{{  number_format($nota_de_debito->IVA, 2, '.', '') }}</td>
                                    <td>{{  number_format($nota_de_debito->Total, 2, '.', '') }}</td>
                                    <td>{{ $nota_de_debito->Estado }}</td>
                                    <td>{{ $nota_de_debito->CantidadImpresiones }}</td>
                                    <td>{{ $nota_de_debito->CantidadEnviosPorCorreo }}</td>
                                </tr>

                                <tr class="expandable-body" style="display: {{ in_array($nota_de_debito->id, $expanded) ? 'table-row' : 'none' }};">

                                    <td colspan="9">
                                        <div class="p-0">
                                            <table class="table table-sm table-bordered mb-0">
                                                <thead>
                                                <tr class="bg-dark text-white">
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

                                </tr>

                            @endforeach

                            @php
                                $filasFaltantes = max(0, 10 - count($recibos));
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
                                    <td>&nbsp;</td>
                                </tr>
                            @endfor

                        </x-slot>

                    </x-data-table-acordion2>

                </div>


                <div class="tab-pane fade show {{ $activeTabParametros === 'custom-tabs-7' ? 'active' : '' }}" id="custom-tabs-7" role="tabpanel" aria-labelledby="custom-tabs-7-tab">

                    <div class="row mb-3">

                        <div class="col-2">
                            <div class="form-group mb-0">
                                <label for="filtro1" class="font-weight-normal">Desde fecha</label>
                                <input type="date" id="filtro1" name="filtro1" wire:model.live="fecha_desde" class="form-control form-control-sm" value="{">
                            </div>
                        </div>

                        <div class="col-2">
                            <div class="form-group mb-0">
                                <label for="filtro1" class="font-weight-normal">Hasta fecha</label>
                                <input type="date" id="filtro1" name="filtro1" wire:model.live="fecha_hasta" class="form-control form-control-sm" value="">
                            </div>
                        </div>

                    </div>

                    <x-data-table-acordion2>

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
                                    <td>{{  number_format($minuta->Total, 2, '.', '') }}</td>
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

                    </x-data-table-acordion2>

                </div>

            </x-slot>

        </x-panel-horizontal2>
    
    </x-layout2-sidebar>

</div>