{{-- <x-layout>
    <x-slot name="title">Compras</x-slot>
    <x-slot name="breadcrumbs">
        <li class="nav-home">
            <a href="#"><i class="fas fa-money-bill-wave"></i></a>
        </li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="#">Listado de IVA Compras</a></li>
    </x-slot>

    <div class="card">
        <div class="card-header">
            <div class="card-title">Parámetros</div>
        </div>
        <div class="card-body">
            <div class="row">

                <div class="col-md-3">
                    <x-form-input-date-livewire>
                        <x-slot name="label">Fecha de Registro Desde</x-slot>
                        <x-slot name="livewire">wire:model.live="fecha_desde"</x-slot>
                        <x-slot name="value"></x-slot>
                        <x-slot name="name"></x-slot>
                        <x-slot name="placeholder"></x-slot>
                        <x-slot name="message"></x-slot>
                        <x-slot name="error"></x-slot>
                    </x-form-input-date-livewire>
                </div>

                <div class="col-md-3">
                    <x-form-input-date-livewire>
                        <x-slot name="label">Fecha de Registro Hasta</x-slot>
                        <x-slot name="livewire">wire:model.live="fecha_hasta"</x-slot>
                        <x-slot name="value"></x-slot>
                        <x-slot name="name"></x-slot>
                        <x-slot name="placeholder"></x-slot>
                        <x-slot name="message"></x-slot>
                        <x-slot name="error"></x-slot>
                    </x-form-input-date-livewire>
                </div>

                <div class="col-md-6">
                    <div class="row align-items-end">
                        <div class="col-md-9">
                            <x-form-input-disabled>
                                <x-slot name="label">Directorio Archivos AFIP RG 3685</x-slot>
                                <x-slot name="livewire">wire:model.live="archivoAFIP"</x-slot>
                                <x-slot name="name"></x-slot>
                                <x-slot name="placeholder"></x-slot>
                                <x-slot name="value"></x-slot>
                                <x-slot name="message"></x-slot>
                                <x-slot name="error"></x-slot>
                            </x-form-input-disabled>
                        </div>
                        <div class="col-md-2">
                            <div class="mb-3">
                                <label class="btn btn-success w-100">
                                    ...
                                    <input 
                                        type="file" 
                                        style="display: none;" 
                                        wire:model="archivoAFIP"
                                        onchange="this.closest('div.mb-3').previousElementSibling.querySelector('input').value = this.files[0].name"
                                    >
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <x-panel-horizontal-5-no-title>        
        <x-slot name="panel1">Documentos</x-slot>
        <x-slot name="body1">

            <x-data-table-no-plus>
                <x-slot name="table_title">Documentos</x-slot>
                <x-slot name="export_route">{{ route('programacion.export') }}</x-slot>
                <x-slot name="add_text">Añadir Item</x-slot>

                <x-slot name="head_tr">
                    <tr>
                        <th>F. Registro</th>
                        <th>F. Emisión</th>
                        <th>Número</th>
                        <th>Estado</th>
                        <th>Proveedor</th>
                        <th>Cond. IVA</th>
                        <th>CUIT</th>
                        <th>Exento</th>
                        <th>Neto no Agravado</th>
                        <th>Monotributo</th>
                        <th>Neto</th>
                        <th>Percepción IVA</th>
                        <th>Percepción IIBB</th>
                        <th>Percepción Ganancias</th>
                        <th>Conceptos no Gravados</th>
                        <th>Sellados</th>
                        <th>Impuesto Interno</th>
                        <th>Total Percepciones</th>
                        <th>IVA 27%</th>
                        <th>IVA 21%</th>
                        <th>IVA 10.5%</th>
                        <th>IVA 2.5%</th>
                        <th>Total IVA</th>
                        <th>Redondeo</th>
                        <th>Total</th>
                    </tr>
                </x-slot>

                <x-slot name="body_tr">
                    @foreach ($facturas_compra as $index => $factura_compra)
                        <tr>
                            <td>{{ $factura_compra->FechaRegistro }}</td>
                            <td>{{ $factura_compra->FechaEmision }}</td>
                            <td>{{ $factura_compra->NumeroCompleto }}</td>
                            <td>{{ $factura_compra->Estado }}</td>
                            <td>{{ $factura_compra->proveedor->Nombre }}</td>
                            <td>{{ $factura_compra->condicionIVA->Nombre }}</td>
                            <td>
                                @switch($factura_compra->condicionIVA->Nombre)
                                    @case('Exento')
                                        EX
                                        @break
                                    @case('Resp. inscripto')
                                        RI
                                        @break
                                    @case('Resp. no inscripto')
                                        RNI
                                        @break
                                    @case('Cons. final')
                                        CF
                                        @break
                                    @case('Resp. monotributo')
                                        RM
                                        @break
                                    @case('Resp. no identificado')
                                        NID
                                        @break
                                    @default
                                @endswitch
                            </td>
                            <td>{{ $factura_compra->NumeroDocumentoProveedor }}</td>
                            <td>{{ $factura_compra->NumeroDocumentoProveedor }}</td>
                            <td>{{ $factura_compra->NumeroDocumentoProveedor }}</td>
                            <td>{{ $factura_compra->NumeroDocumentoProveedor }}</td>
                            <td>{{ number_format($factura_compra->PercepcionIVA, 2, '.', '') }}</td>
                            <td>{{ number_format($factura_compra->PercepcionIIBB, 2, '.', '') }}</td>
                            <td>{{ number_format($factura_compra->PercepcionGanancias, 2, '.', '') }}</td>
                            <td>{{ number_format($factura_compra->ConceptosNoGravados, 2, '.', '') }}</td>
                            <td>{{ number_format($factura_compra->Sellados, 2, '.', '') }}</td>
                            <td>{{ number_format($factura_compra->ImpuestoInterno, 2, '.', '') }}</td>
                            <td>{{ number_format($factura_compra->ImpuestoInterno, 2, '.', '') }}</td>
                            <td>{{ number_format($factura_compra->ImpuestoInterno, 2, '.', '') }}</td>
                            <td>{{ number_format($factura_compra->ImpuestoInterno, 2, '.', '') }}</td>
                            <td>{{ number_format($factura_compra->ImpuestoInterno, 2, '.', '') }}</td>
                            <td>{{ number_format($factura_compra->ImpuestoInterno, 2, '.', '') }}</td>
                            <td>{{ number_format($factura_compra->ImpuestoInterno, 2, '.', '') }}</td>
                            <td>{{ number_format($factura_compra->AjustePorRedondeo, 2, '.', '') }}</td>
                            <td>{{ number_format($factura_compra->Total, 2, '.', '') }}</td>
                        </tr>
                    @endforeach

                    <tr class="fw-bold">
                        <td></td>
                        <td></td>
                        <td>SUBTOTALES FC</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>0.00</td>
                        <td>0.00</td>
                        <td>0.00</td>
                        <td>0.00</td>
                        <td>0.00</td>
                        <td>0.00</td>
                        <td>0.00</td>
                        <td>0.00</td>
                        <td>0.00</td>
                        <td>0.00</td>
                        <td>0.00</td>
                        <td>0.00</td>
                        <td>0.00</td>
                        <td>0.00</td>
                        <td>0.00</td>
                        <td>0.00</td>
                        <td>0.00</td>
                        <td>0.00</td>
                    </tr>

                    @foreach ($notas_credito_compra as $index => $notas_credito_compra)
                        <tr>
                            <td>{{ $notas_credito_compra->FechaRegistro }}</td>
                            <td>{{ $notas_credito_compra->FechaEmision }}</td>
                            <td>{{ $notas_credito_compra->NumeroCompleto }}</td>
                            <td>{{ $notas_credito_compra->Estado }}</td>
                            <td>{{ $notas_credito_compra->proveedor->Nombre }}</td>
                            <td>{{ $notas_credito_compra->condicionIVA->Nombre }}</td>
                            <td>
                                @switch($notas_credito_compra->condicionIVA->Nombre)
                                    @case('Exento')
                                        EX
                                        @break
                                    @case('Resp. inscripto')
                                        RI
                                        @break
                                    @case('Resp. no inscripto')
                                        RNI
                                        @break
                                    @case('Cons. final')
                                        CF
                                        @break
                                    @case('Resp. monotributo')
                                        RM
                                        @break
                                    @case('Resp. no identificado')
                                        NID
                                        @break
                                    @default
                                @endswitch
                            </td>
                            <td>{{ $notas_credito_compra->NumeroDocumentoProveedor }}</td>
                            <td>{{ $notas_credito_compra->NumeroDocumentoProveedor }}</td>
                            <td>{{ $notas_credito_compra->NumeroDocumentoProveedor }}</td>
                            <td>{{ $notas_credito_compra->NumeroDocumentoProveedor }}</td>
                            <td>{{ number_format($notas_credito_compra->PercepcionIVA, 2, '.', '') }}</td>
                            <td>{{ number_format($notas_credito_compra->PercepcionIIBB, 2, '.', '') }}</td>
                            <td>{{ number_format($notas_credito_compra->PercepcionGanancias, 2, '.', '') }}</td>
                            <td>{{ number_format($notas_credito_compra->ConceptosNoGravados, 2, '.', '') }}</td>
                            <td>{{ number_format($notas_credito_compra->Sellados, 2, '.', '') }}</td>
                            <td>{{ number_format($notas_credito_compra->ImpuestoInterno, 2, '.', '') }}</td>
                            <td>{{ number_format($notas_credito_compra->ImpuestoInterno, 2, '.', '') }}</td>
                            <td>{{ number_format($notas_credito_compra->ImpuestoInterno, 2, '.', '') }}</td>
                            <td>{{ number_format($notas_credito_compra->ImpuestoInterno, 2, '.', '') }}</td>
                            <td>{{ number_format($notas_credito_compra->ImpuestoInterno, 2, '.', '') }}</td>
                            <td>{{ number_format($notas_credito_compra->ImpuestoInterno, 2, '.', '') }}</td>
                            <td>{{ number_format($notas_credito_compra->ImpuestoInterno, 2, '.', '') }}</td>
                            <td>{{ number_format($notas_credito_compra->AjustePorRedondeo, 2, '.', '') }}</td>
                            <td>{{ number_format($notas_credito_compra->Total, 2, '.', '') }}</td>
                        </tr>
                    @endforeach
                    <tr class="fw-bold">
                        <td></td>
                        <td></td>
                        <td>SUBTOTALES NC</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>0.00</td>
                        <td>0.00</td>
                        <td>0.00</td>
                        <td>0.00</td>
                        <td>0.00</td>
                        <td>0.00</td>
                        <td>0.00</td>
                        <td>0.00</td>
                        <td>0.00</td>
                        <td>0.00</td>
                        <td>0.00</td>
                        <td>0.00</td>
                        <td>0.00</td>
                        <td>0.00</td>
                        <td>0.00</td>
                        <td>0.00</td>
                        <td>0.00</td>
                        <td>0.00</td>
                    </tr>
                </x-slot>

                <x-slot name="foot_tr">
                    <tr>
                        <th>F. Registro</th>
                        <th>F. Emisión</th>
                        <th>Número</th>
                        <th>Estado</th>
                        <th>Proveedor</th>
                        <th>Cond. IVA</th>
                        <th>CUIT</th>
                        <th>Exento</th>
                        <th>Neto no Agravado</th>
                        <th>Monotributo</th>
                        <th>Neto</th>
                        <th>Percepción IVA</th>
                        <th>Percepción IIBB</th>
                        <th>Percepción Ganancias</th>
                        <th>Conceptos no Gravados</th>
                        <th>Sellados</th>
                        <th>Impuesto Interno</th>
                        <th>Total Percepciones</th>
                        <th>IVA 27%</th>
                        <th>IVA 21%</th>
                        <th>IVA 10.5%</th>
                        <th>IVA 2.5%</th>
                        <th>Total IVA</th>
                        <th>Redondeo</th>
                        <th>Total</th>
                    </tr>
                </x-slot>
            </x-data-table-no-plus>

        </x-slot>

        <x-slot name="panel2">Condición IVA</x-slot>

        <x-slot name="body2">

            <x-data-table-no-plus>
                <x-slot name="table_title">Condición IVA</x-slot>
                <x-slot name="export_route">{{ route('programacion.export') }}</x-slot>
                <x-slot name="add_text">Añadir Item</x-slot>

                <x-slot name="head_tr">
                    <tr>
                        <th>Condición IVA</th>
                        <th>Exento</th>
                        <th>No Gravado</th>
                        <th>Monotributo</th>
                        <th>Percepción IVA</th>
                        <th>Otras Percepciones</th>
                        <th>Neto</th>
                        <th>IVA</th>
                        <th>Total</th>
                    </tr>
                </x-slot>

                <x-slot name="body_tr">
                    @foreach (['Responsable inscripto','Responsable monotributo','Exento'] as $tipo)
                        <tr>
                            <td>{{ $tipo }}</td>
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
                    <tr class="fw-bold">
                        <td>TOTALES</td>
                        <td>{{ number_format(0, 2, '.', '') }}</td>
                        <td>{{ number_format(0, 2, '.', '') }}</td>
                        <td>{{ number_format(0, 2, '.', '') }}</td>
                        <td>{{ number_format(0, 2, '.', '') }}</td>
                        <td>{{ number_format(0, 2, '.', '') }}</td>
                        <td>{{ number_format(0, 2, '.', '') }}</td>
                        <td>{{ number_format(0, 2, '.', '') }}</td>
                        <td>{{ number_format(0, 2, '.', '') }}</td>
                    </tr>
                </x-slot>

                <x-slot name="foot_tr">
                    <tr>
                        <th>Condición IVA</th>
                        <th>Exento</th>
                        <th>No Gravado</th>
                        <th>Monotributo</th>
                        <th>Percepción IVA</th>
                        <th>Otras Percepciones</th>
                        <th>Neto</th>
                        <th>IVA</th>
                        <th>Total</th>
                    </tr>
                </x-slot>
            </x-data-table-no-plus>

        </x-slot>

        <x-slot name="panel3">IVA</x-slot>

        <x-slot name="body3">

            <x-data-table-no-plus>
                <x-slot name="table_title">IVA</x-slot>
                <x-slot name="export_route">{{ route('programacion.export') }}</x-slot>
                <x-slot name="add_text">Añadir Item</x-slot>

                <x-slot name="head_tr">
                    <tr>
                        <th>Impuesto</th>
                        <th>Neto</th>
                        <th>IVA</th>
                    </tr>
                </x-slot>

                <x-slot name="body_tr">
                    @foreach (['IVA 21%','IVA 10.5%','IVA 27%', 'IVA 2.5%', 'IVA 0%'] as $tipo)
                        <tr>
                            <td>{{ $tipo }}</td>
                            <td>{{ number_format(0, 2, '.', '') }}</td>
                            <td>{{ number_format(0, 2, '.', '') }}</td>
                        </tr>
                    @endforeach
                    <tr class="fw-bold">
                        <td>TOTALES</td>
                        <td>{{ number_format(0, 2, '.', '') }}</td>
                        <td>{{ number_format(0, 2, '.', '') }}</td>
                    </tr>
                </x-slot>

                <x-slot name="foot_tr">
                    <tr>
                        <th>Impuesto</th>
                        <th>Neto</th>
                        <th>IVA</th>
                    </tr>
                </x-slot>
            </x-data-table-no-plus>

        </x-slot>

        <x-slot name="panel4">Percepciones</x-slot>

        <x-slot name="body4">

            <x-data-table-no-plus>
                <x-slot name="table_title">Percepciones</x-slot>
                <x-slot name="export_route">{{ route('programacion.export') }}</x-slot>
                <x-slot name="add_text">Añadir Item</x-slot>

                <x-slot name="head_tr">
                    <tr>
                        <th>Percepción</th>
                        <th>Total</th>
                    </tr>
                </x-slot>

                <x-slot name="body_tr">
                    @foreach (['IVA','IIBB','GANANCIAS', 'CONCEPTOS NO GRAVADOS', 'SELLADOS', 'IMPUESTO INTERNO'] as $tipo)
                        <tr>
                            <td>{{ $tipo }}</td>
                            <td>{{ number_format(0, 2, '.', '') }}</td>
                        </tr>
                    @endforeach
                    <tr class="fw-bold">
                        <td>TOTAL OTRAS PERCEPCIONES</td>
                        <td>{{ number_format(0, 2, '.', '') }}</td>
                    </tr>
                    <tr class="fw-bold">
                        <td>TOTAL</td>
                        <td>{{ number_format(0, 2, '.', '') }}</td>
                    </tr>
                </x-slot>

                <x-slot name="foot_tr">
                    <tr>
                        <th>Percepción</th>
                        <th>Total</th>
                    </tr>
                </x-slot>
            </x-data-table-no-plus>

        </x-slot>

        <x-slot name="panel5">Cuentas de Gastos</x-slot>

        <x-slot name="body5">

            <x-data-table-no-plus>
                <x-slot name="table_title">Cuentas de Gastos</x-slot>
                <x-slot name="export_route">{{ route('programacion.export') }}</x-slot>
                <x-slot name="add_text">Añadir Item</x-slot>

                <x-slot name="head_tr">
                    <tr>
                        <th>Nombre</th>
                        <th>Exento</th>
                        <th>No Gravado</th>
                        <th>Monotributo</th>
                        <th>Neto</th>
                        <th>IVA</th>
                        <th>Percepciones</th>
                        <th>Percepción IVA</th>
                        <th>Total</th>
                        <th>Gastos Neto IVA</th>
                    </tr>
                </x-slot>
              
                <x-slot name="body_tr">
                    @foreach ($cuentas_de_gastos as $cuenta_de_gasto)
                        <tr>
                            <td>{{ $cuenta_de_gasto->Nombre }}</td>
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
                    <tr class="fw-bold">
                        <td>TOTALES</td>
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
                </x-slot>

                <x-slot name="foot_tr">
                    <tr>
                        <th>Nombre</th>
                        <th>Exento</th>
                        <th>No Gravado</th>
                        <th>Monotributo</th>
                        <th>Neto</th>
                        <th>IVA</th>
                        <th>Percepciones</th>
                        <th>Percepción IVA</th>
                        <th>Total</th>
                        <th>Gastos Neto IVA</th>
                    </tr>
                </x-slot>
            </x-data-table-no-plus>

        </x-slot>

    </x-panel-horizontal-5-no-title>

</x-layout> --}}



<div>

    <x-panel-horizontal2>

        <x-slot name="pestañas">

            <li class="nav-item">
                <a class="nav-link {{ $activeTabParametros === 'custom-tabs-1' ? 'active' : '' }}" wire:click.prevent="setActiveTabParametros('custom-tabs-1')" id="custom-tabs-1-tab" data-toggle="pill" href="#custom-tabs-1" role="tab" aria-controls="custom-tabs-1" aria-selected="true">PARAMETROS</a>
            </li>

        </x-slot>

        <x-slot name="ventanas">

            <div class="tab-pane fade show {{ $activeTabParametros === 'custom-tabs-1' ? 'active' : '' }}" id="custom-tabs-1" role="tabpanel" aria-labelledby="custom-tabs-1-tab" style="height:6rem">

                <div class="row">

                    <div class="col-2">
                        <div class="form-group mb-0">
                            <label for="filtro1" class="font-weight-normal">FECHA DE REGISTRO DESDE</label>
                            <input type="date" id="filtro1" name="filtro1" wire:model.live="fecha_desde" class="form-control form-control-sm" value="{{ $fecha_desde }}">
                        </div>
                    </div>

                    <div class="col-2">
                        <div class="form-group mb-0">
                            <label for="filtro1" class="font-weight-normal">FECHA DE REGISTRO HASTA</label>
                            <input type="date" id="filtro1" name="filtro1" wire:model.live="fecha_hasta" class="form-control form-control-sm" value="{{ $fecha_hasta }}">
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="form-group mb-0">
                            <label for="archivoAFIP" class="font-weight-normal">DIRECTORIO ARCHIVOS AFIP RG 3685</label>
                        </div>
                        <div class="input-group">
                            <input id="archivoAFIP" 
                                type="file" 
                                class="d-none"
                                onchange="document.getElementById('sidebarSearch').value = this.files[0]?.name || ''">

                            <input id="sidebarSearch"
                                class="form-control form-control-sm bg-white text-dark" 
                                type="text" 
                                placeholder="Seleccione un archivo" 
                                disabled>

                            <div class="input-group-append">
                                <button type="button" class="btn btn-sidebar btn-sm bg-orange"
                                        onclick="document.getElementById('archivoAFIP').click();">
                                    <i class="fas fa-ellipsis-h fa-fw text-white"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </x-slot>

    </x-panel-horizontal2>
    

    <x-panel-horizontal2>

        <x-slot name="pestañas">

            <li class="nav-item">
                <a class="nav-link {{ $activeTabDocumentos === 'custom-tabs-2' ? 'active' : '' }}" wire:click.prevent="setActiveTabDocumentos('custom-tabs-2')" id="custom-tabs-2-tab" data-toggle="pill" href="#custom-tabs-2" role="tab" aria-controls="custom-tabs-2" aria-selected="true">DOCUMENTOS</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $activeTabDocumentos === 'custom-tabs-3' ? 'active' : '' }}" wire:click.prevent="setActiveTabDocumentos('custom-tabs-3')" id="custom-tabs-3-tab" data-toggle="pill" href="#custom-tabs-3" role="tab" aria-controls="custom-tabs-3" aria-selected="true">CONDICION IVA</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $activeTabDocumentos === 'custom-tabs-4' ? 'active' : '' }}" wire:click.prevent="setActiveTabDocumentos('custom-tabs-4')" id="custom-tabs-4-tab" data-toggle="pill" href="#custom-tabs-4" role="tab" aria-controls="custom-tabs-4" aria-selected="true">IVA</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $activeTabDocumentos === 'custom-tabs-5' ? 'active' : '' }}" wire:click.prevent="setActiveTabDocumentos('custom-tabs-5')" id="custom-tabs-5-tab" data-toggle="pill" href="#custom-tabs-5" role="tab" aria-controls="custom-tabs-5" aria-selected="true">PERCEPCIONES</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $activeTabDocumentos === 'custom-tabs-6' ? 'active' : '' }}" wire:click.prevent="setActiveTabDocumentos('custom-tabs-6')" id="custom-tabs-6-tab" data-toggle="pill" href="#custom-tabs-6" role="tab" aria-controls="custom-tabs-6" aria-selected="true">CUENTAS DE GASTOS</a>
            </li>     
        </x-slot>

        <x-slot name="ventanas">

            <div class="tab-pane fade show {{ $activeTabDocumentos === 'custom-tabs-2' ? 'active' : '' }}" id="custom-tabs-2" role="tabpanel" aria-labelledby="custom-tabs-2-tab" style="height:30rem">

                <x-simple-table2-no-limit>

                    <x-slot name="thead">

                        <tr>
                            <th>F. REGISTRO</th>
                            <th>F. EMISION</th>
                            <th>NUMERO</th>
                            <th>ESTADO</th>
                            <th>PROVEEDOR</th>
                            <th>COND. IVA</th>
                            <th>CUIT</th>
                            <th>EXENTO</th>
                            <th>NETO NO GRAVADO</th>
                            <th>MONOTRIBUTO</th>
                            <th>NETO</th>
                            <th>PERCEPCION IVA</th>
                            <th>PERCEPCION IIBB</th>
                            <th>PERCEPCION GANANCIAS</th>
                            <th>CONCEPTOS NO GRAVADOS</th>
                            <th>SELLADOS</th>
                            <th>IMPUESTO INTERNO</th>
                            <th>TOTAL PERCEPCIONES</th>
                            <th>IVA 27%</th>
                            <th>IVA 21%</th>
                            <th>IVA 10.5%</th>
                            <th>IVA 2.5%</th>
                            <th>TOTAL IVA</th>
                            <th>REDONDEO</th>
                            <th>TOTAL</th>
                        </tr>

                    </x-slot>

                    <x-slot name="tbody">

                        {{-- @php
                            $filasFaltantes = max(0, 11 - count($documentos));
                        @endphp

                        @foreach ($documentos as $index => $documento)
                            @php
                                $esNotaCredito = $documento instanceof \App\Models\NotaCreditoVenta;
                                $signo = $esNotaCredito ? '-' : '';
                            @endphp
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($documento->FechaEmision)->format('j/n/Y') }}</td>
                                <td>{{ $documento->NumeroCompleto }}</td>
                                <td>{{ $documento->Estado }}</td>
                                <td>{{ $documento->IdCliente }}</td>
                                <td>{{ $documento->RazonSocial }}</td>
                                <td>
                                    @switch($documento->condicionIVA->Nombre)
                                            @case('Exento')
                                                EX
                                                @break
                                            @case('Resp. inscripto')
                                                RI
                                                @break
                                            @case('Resp. no inscripto')
                                                RNI
                                                @break
                                            @case('Cons. final')
                                                CF
                                                @break
                                            @case('Resp. monotributo')
                                                RM
                                                @break
                                            @case('Resp. no identificado')
                                                NID
                                                @break
                                            @default
                                    @endswitch
                                </td>
                                <td>{{ $documento->cliente->NroDocumento }}</td>
                                <td>{{ $signo . number_format($documento->Neto, 2, '.', '') }}</td>
                                <td>{{ $signo . number_format($documento->IVA, 2, '.', '') }}</td>
                                <td>{{ $signo . number_format($documento->Total, 2, '.', '') }}</td>
                            </tr>
                        @endforeach

                        <tr class="text-bold">
                            <td colspan="7" class="text-end"></td>
                            <td>{{ number_format($total_neto, 2, '.', '') }}</td>
                            <td>{{ number_format($total_iva, 2, '.', '') }}</td>
                            <td>{{ number_format($total_total, 2, '.', '') }}</td>
                        </tr>

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
                        @endfor --}}

                        @foreach ($facturas_compra as $index => $factura_compra)
                            <tr>
                                <td>{{ $factura_compra->FechaRegistro }}</td>
                                <td>{{ $factura_compra->FechaEmision }}</td>
                                <td>{{ $factura_compra->NumeroCompleto }}</td>
                                <td>{{ $factura_compra->Estado }}</td>
                                <td>{{ $factura_compra->proveedor->Nombre }}</td>
                                <td>
                                    @switch($factura_compra->condicionIVA->Nombre)
                                        @case('Exento')
                                            EX
                                            @break
                                        @case('Resp. inscripto')
                                            RI
                                            @break
                                        @case('Resp. no inscripto')
                                            RNI
                                            @break
                                        @case('Cons. final')
                                            CF
                                            @break
                                        @case('Resp. monotributo')
                                            RM
                                            @break
                                        @case('Resp. no identificado')
                                            NID
                                            @break
                                        @default
                                    @endswitch
                                </td>
                                <td>{{ $factura_compra->NumeroDocumentoProveedor }}</td>
                                <td>0.00</td>
                                <td>0.00</td>
                                <td>0.00</td>
                                <td>0.00</td>
                                <td>{{ number_format($factura_compra->PercepcionIVA, 2, '.', '') }}</td>
                                <td>{{ number_format($factura_compra->PercepcionIIBB, 2, '.', '') }}</td>
                                <td>{{ number_format($factura_compra->PercepcionGanancias, 2, '.', '') }}</td>
                                <td>{{ number_format($factura_compra->ConceptosNoGravados, 2, '.', '') }}</td>
                                <td>{{ number_format($factura_compra->Sellados, 2, '.', '') }}</td>
                                <td>{{ number_format($factura_compra->ImpuestoInterno, 2, '.', '') }}</td>
                                <td>0.00</td>
                                <td>0.00</td>
                                <td>0.00</td>
                                <td>0.00</td>
                                <td>0.00</td>
                                <td>0.00</td>
                                <td>{{ number_format($factura_compra->AjustePorRedondeo, 2, '.', '') }}</td>
                                <td>{{ number_format($factura_compra->Total, 2, '.', '') }}</td>
                            </tr>
                        @endforeach

                        <tr class="text-bold">
                            <td></td>
                            <td></td>
                            <td>SUBTOTALES FC</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>0.00</td>
                            <td>0.00</td>
                            <td>0.00</td>
                            <td>0.00</td>
                            <td>{{ number_format($subtotal_fc['PercepcionIVA'], 2, '.', '') }}</td>
                            <td>{{ number_format($subtotal_fc['PercepcionIIBB'], 2, '.', '') }}</td>
                            <td>{{ number_format($subtotal_fc['PercepcionGanancias'], 2, '.', '') }}</td>
                            <td>{{ number_format($subtotal_fc['ConceptosNoGravados'], 2, '.', '') }}</td>
                            <td>{{ number_format($subtotal_fc['Sellados'], 2, '.', '') }}</td>
                            <td>{{ number_format($subtotal_fc['ImpuestoInterno'], 2, '.', '') }}</td>
                            <td>0.00</td>
                            <td>0.00</td>
                            <td>0.00</td>
                            <td>0.00</td>
                            <td>0.00</td>
                            <td>0.00</td>
                            <td>{{ number_format($subtotal_fc['AjustePorRedondeo'], 2, '.', '') }}</td>
                            <td>{{ number_format($subtotal_fc['Total'], 2, '.', '') }}</td>
                        </tr>

                        @foreach ($notas_credito_compra as $index => $notas_credito_compra)
                            <tr>
                                <td>{{ $notas_credito_compra->FechaRegistro }}</td>
                                <td>{{ $notas_credito_compra->FechaEmision }}</td>
                                <td>{{ $notas_credito_compra->NumeroCompleto }}</td>
                                <td>{{ $notas_credito_compra->Estado }}</td>
                                <td>{{ $notas_credito_compra->proveedor->Nombre }}</td>
                                <td>
                                    @switch($notas_credito_compra->condicionIVA->Nombre)
                                        @case('Exento')
                                            EX
                                            @break
                                        @case('Resp. inscripto')
                                            RI
                                            @break
                                        @case('Resp. no inscripto')
                                            RNI
                                            @break
                                        @case('Cons. final')
                                            CF
                                            @break
                                        @case('Resp. monotributo')
                                            RM
                                            @break
                                        @case('Resp. no identificado')
                                            NID
                                            @break
                                        @default
                                    @endswitch
                                </td>
                                <td>{{ $notas_credito_compra->NumeroDocumentoProveedor }}</td>
                                <td>0.00</td>
                                <td>0.00</td>
                                <td>0.00</td>
                                <td>0.00</td>
                                <td>{{ number_format($notas_credito_compra->PercepcionIVA, 2, '.', '') }}</td>
                                <td>{{ number_format($notas_credito_compra->PercepcionIIBB, 2, '.', '') }}</td>
                                <td>{{ number_format($notas_credito_compra->PercepcionGanancias, 2, '.', '') }}</td>
                                <td>{{ number_format($notas_credito_compra->ConceptosNoGravados, 2, '.', '') }}</td>
                                <td>{{ number_format($notas_credito_compra->Sellados, 2, '.', '') }}</td>
                                <td>{{ number_format($notas_credito_compra->ImpuestoInterno, 2, '.', '') }}</td>
                                <td>0.00</td>
                                <td>0.00</td>
                                <td>0.00</td>
                                <td>0.00</td>
                                <td>0.00</td>
                                <td>0.00</td>
                                <td>{{ number_format($notas_credito_compra->AjustePorRedondeo, 2, '.', '') }}</td>
                                <td>{{ number_format($notas_credito_compra->Total, 2, '.', '') }}</td>
                            </tr>
                        @endforeach
                        <tr class="text-bold">
                            <td></td>
                            <td></td>
                            <td>SUBTOTALES NC</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>0.00</td>
                            <td>0.00</td>
                            <td>0.00</td>
                            <td>0.00</td>
                            <td>{{ number_format($subtotal_nc['PercepcionIVA'], 2, '.', '') }}</td>
                            <td>{{ number_format($subtotal_nc['PercepcionIIBB'], 2, '.', '') }}</td>
                            <td>{{ number_format($subtotal_nc['PercepcionGanancias'], 2, '.', '') }}</td>
                            <td>{{ number_format($subtotal_nc['ConceptosNoGravados'], 2, '.', '') }}</td>
                            <td>{{ number_format($subtotal_nc['Sellados'], 2, '.', '') }}</td>
                            <td>{{ number_format($subtotal_nc['ImpuestoInterno'], 2, '.', '') }}</td>
                            <td>0.00</td>
                            <td>0.00</td>
                            <td>0.00</td>
                            <td>0.00</td>
                            <td>0.00</td>
                            <td>0.00</td>
                            <td>{{ number_format($subtotal_nc['AjustePorRedondeo'], 2, '.', '') }}</td>
                            <td>{{ number_format($subtotal_nc['Total'], 2, '.', '') }}</td>
                        </tr>



                    </x-slot>

                </x-simple-table2-no-limit>

            </div>

            <div class="tab-pane fade show {{ $activeTabDocumentos === 'custom-tabs-3' ? 'active' : '' }}" id="custom-tabs-3" role="tabpanel" aria-labelledby="custom-tabs-3-tab" style="height:30rem">

                <x-simple-table2-no-limit>

                    <x-slot name="thead">

                        <tr>
                            <th>CONDICION IVA</th>
                            <th>EXENTO</th>
                            <th>NO GRAVADO</th>
                            <th>MONOTRIBUTO</th>
                            <th>PERCEPCION IVA</th>
                            <th>OTRAS PERCEPCIONES</th>
                            <th>NETO</th>
                            <th>IVA</th>
                            <th>TOTAL</th>
                        </tr>

                    </x-slot>

                    <x-slot name="tbody">

                        @foreach ($totales_por_condicion as $condicion => $totales)
                            <tr>
                                <td>{{ $condicion }}</td>
                                <td>{{ number_format($totales['no_gravado'],2,'.','') }}</td>
                                <td>{{ number_format($totales['exento'],2,'.','') }}</td>
                                <td>{{ number_format($totales['neto'],2,'.','') }}</td>
                                <td>{{ number_format($totales['iva'],2,'.','') }}</td>
                                <td>{{ number_format($totales['total'],2,'.','') }}</td>
                            </tr>
                        @endforeach

                        <tr class="text-bold">
                            <td>TOTALES</td>
                            <td>{{ number_format($total_no_gravado,2,'.','') }}</td>
                            <td>{{ number_format($total_exento,2,'.','') }}</td>
                            <td>{{ number_format($total_neto,2,'.','') }}</td>
                            <td>{{ number_format($total_iva,2,'.','') }}</td>
                            <td>{{ number_format($total_total,2,'.','') }}</td>
                        </tr>

                    </x-slot>

                </x-simple-table2-no-limit>

            </div>

        </x-slot>

    </x-panel-horizontal2>

    <div class="d-flex justify-content-end">
        <a class="btn btn-app bg-primary disabled">
            <i class="fas fa-print"></i> Imprimir
        </a>
    </div>

</div>