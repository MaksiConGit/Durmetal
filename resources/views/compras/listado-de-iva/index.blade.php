<x-layout>
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

</x-layout>