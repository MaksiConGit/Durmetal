<div>

    <x-panel-horizontal2>

        <x-slot name="pestañas">

            <li class="nav-item">
                <a class="nav-link active" id="custom-tabs-1-tab" data-toggle="pill" href="#custom-tabs-1" role="tab" aria-controls="custom-tabs-1" aria-selected="true">PARAMETROS</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="custom-tabs-2-tab" data-toggle="pill" href="#custom-tabs-2" role="tab" aria-controls="custom-tabs-2" aria-selected="true">PUNTOS DE VENTA</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="custom-tabs-3-tab" data-toggle="pill" href="#custom-tabs-3" role="tab" aria-controls="custom-tabs-3" aria-selected="true">ARTICULOS PARA EXCLUIR</a>
            </li>

        </x-slot>

        <x-slot name="ventanas">

            <div class="tab-pane fade show active" id="custom-tabs-1" role="tabpanel" aria-labelledby="custom-tabs-1-tab" style="height:6rem">

                <div class="row">

                    <div class="col-2">
                        <div class="form-group mb-0">
                            <label for="filtro1" class="font-weight-normal">FECHA DESDE</label>
                            <input type="date" id="filtro1" name="filtro1" wire:model.live="fecha_desde" class="form-control form-control-sm" value="{{ $fecha_desde }}">
                        </div>
                    </div>

                    <div class="col-2">
                        <div class="form-group mb-0">
                            <label for="filtro1" class="font-weight-normal">FECHA HASTA</label>
                            <input type="date" id="filtro1" name="filtro1" wire:model.live="fecha_hasta" class="form-control form-control-sm" value="{{ $fecha_hasta }}">
                        </div>
                    </div>



                    <div class="col-4">
                        <div class="form-group mb-0">
                            <label for="filtro1" class="font-weight-normal">DIRECTORIO ARCHIVOS AFIP RG 3685</label>
                        </div>
                        <div class="input-group">
                            <input id="sidebarSearch" wire:model.live="archivoAFIP"
                                class="form-control form-control-sm bg-white text-dark" 
                                type="search" aria-label="Search" disabled>
                            <div class="input-group-append">
                                <a href="" class="btn btn-sidebar btn-sm bg-orange">
                                    <i class="fas fa-ellipsis-h fa-fw text-white"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>

            </div>


            <div class="tab-pane fade show" id="custom-tabs-2" role="tabpanel" aria-labelledby="custom-tabs-2-tab" style="height:6rem">

                <x-simple-table2-no-limit>

                    <x-slot name="thead">

                        <tr>
                            <th  style="width: 5%;"></th>
                            <th>NOMBRE</th>
                            <th style="width: 60%;"></th>
                        </tr>

                    </x-slot>

                    <x-slot name="tbody">

                        @foreach ($pto_ventas as $index => $pto_venta)
                            <tr>
                                <td><input type="checkbox" name="" id=""></td>
                                <td>{{ $pto_venta->Nombre }}</td>
                                <td></td>
                            </tr>
                        @endforeach

                    </x-slot>

                </x-simple-table2-no-limit>

            </div>

            <div class="tab-pane fade show" id="custom-tabs-3" role="tabpanel" aria-labelledby="custom-tabs-3-tab" style="height:6rem">

                <x-simple-table2-no-limit>

                    <x-slot name="thead">

                        <tr>
                            <th  style="width: 5%;"></th>
                            <th>CODIGO</th>
                            <th style="width: 80%;">ARTICULO</th>
                        </tr>

                    </x-slot>

                    <x-slot name="tbody">

                        @foreach ($articulos as $index => $articulo)
                            <tr>
                                <td><input type="checkbox" name="" id=""></td>
                                <td>{{ $articulo->id }}</td>
                                <td>{{ $articulo->DESART }}</td>
                            </tr>
                        @endforeach

                    </x-slot>

                </x-simple-table2-no-limit>

            </div>

        </x-slot>

    </x-panel-horizontal2>
    

    <x-panel-horizontal2>

        <x-slot name="pestañas">

            <li class="nav-item">
                <a class="nav-link active" id="custom-tabs-4-tab" data-toggle="pill" href="#custom-tabs-4" role="tab" aria-controls="custom-tabs-4" aria-selected="true">DOCUMENTOS</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="custom-tabs-5-tab" data-toggle="pill" href="#custom-tabs-5" role="tab" aria-controls="custom-tabs-5" aria-selected="true">CONDICION IVA</a>
            </li>
            
        </x-slot>

        <x-slot name="ventanas">

            <div class="tab-pane fade show active" id="custom-tabs-4" role="tabpanel" aria-labelledby="custom-tabs-4-tab" style="height:30rem">

                <x-simple-table2-no-limit>

                    <x-slot name="thead">

                        <tr>
                            <th>FECHA</th>
                            <th>NUMERO</th>
                            <th>ESTADO</th>
                            <th>COD. CLIENTE</th>
                            <th>RAZON SOCIAL</th>
                            <th>COND. IVA</th>
                            <th>CUIT</th>
                            <th>NETO</th>
                            <th>IVA 21%</th>
                            <th>TOTAL</th>
                        </tr>

                    </x-slot>

                    <x-slot name="tbody">

                        @foreach ($documentos as $index => $documento)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($documento->FechaEmision)->format('j/n/Y') }}</td>
                                <td>{{ $documento->NumeroCompleto }}</td>
                                <td>{{ $documento->Estado }}</td>
                                <td>{{ $documento->IdCliente }}</td>
                                <td>{{ $documento->RazonSocial }}</td>
                                <td>{{ $documento->condicionIVA->Nombre == 'Responsable inscripto' ? 'RI' : $documento->condicionIVA->Nombre }}</td>
                                <td>{{ $documento->cliente->NroDocumento }}</td>
                                <td>{{ number_format($documento->Neto, 2, '.', '') }}</td>
                                <td>{{ number_format($documento->IVA, 2, '.', '') }}</td>
                                <td>{{ number_format($documento->Total, 2, '.', '') }}</td>
                            </tr>
                        @endforeach
                        <tr class="fw-bold">
                            <td colspan="7" class="text-end"></td>
                            <td>{{ number_format($total_neto, 2, '.', '') }}</td>
                            <td>{{ number_format($total_iva, 2, '.', '') }}</td>
                            <td>{{ number_format($total_total, 2, '.', '') }}</td>
                        </tr>

                    </x-slot>

                </x-simple-table2-no-limit>

            </div>

            <div class="tab-pane fade show" id="custom-tabs-5" role="tabpanel" aria-labelledby="custom-tabs-5-tab" style="height:30rem">

                <x-simple-table2-no-limit>

                    <x-slot name="thead">

                        <tr>
                            <th>CONDICION IVA</th>
                            <th>NO GRAVADO</th>
                            <th>EXENTO</th>
                            <th>NETO</th>
                            <th>IVA</th>
                            <th>TOTAL</th>
                        </tr>

                    </x-slot>

                    <x-slot name="tbody">

                        @foreach (['Cons. Final','Exento','Resp. Inscripto','Resp. Monotributo'] as $tipo)
                            <tr>
                                <td>{{ $tipo }}</td>
                                <td>{{ number_format(0,2,'.','') }}</td>
                                <td>{{ number_format(0,2,'.','') }}</td>
                                <td>{{ number_format($total_neto,2,'.','') }}</td>
                                <td>{{ number_format($total_iva,2,'.','') }}</td>
                                <td>{{ number_format($total_total,2,'.','') }}</td>
                            </tr>
                        @endforeach

                        <tr class="text-bold">
                            <td>TOTALES</td>
                            <td>{{ number_format(0,2,'.','') }}</td>
                            <td>{{ number_format(0,2,'.','') }}</td>
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
        <a class="btn btn-app bg-primary">
            <i class="fas fa-print"></i> Imprimir
        </a>
    </div>

</div>



{{-- 
<div>
<div>
<div>
<x-panel-horizontal-3-no-title>        
    <x-slot name="panel1">Parámetros</x-slot>
    <x-slot name="body1">

    <div class="card">
        <div class="card-header">
            <div class="card-title">Parámetros</div>
        </div>
        <div class="card-body">
            <div class="row">

                <div class="col-md-3">
                    <x-form-input-date-livewire>
                        <x-slot name="label">Fecha Desde</x-slot>
                        <x-slot name="livewire">wire:model.live="fecha_desde"</x-slot>
                        <x-slot name="value">{{ $fecha_desde }}</x-slot>
                        <x-slot name="name"></x-slot>
                        <x-slot name="placeholder"></x-slot>
                        <x-slot name="message"></x-slot>
                        <x-slot name="error"></x-slot>
                    </x-form-input-date-livewire>
                </div>

                <div class="col-md-3">
                    <x-form-input-date-livewire>
                        <x-slot name="label">Fecha Hasta</x-slot>
                        <x-slot name="livewire">wire:model.live="fecha_hasta"</x-slot>
                        <x-slot name="value">{{ $fecha_hasta }}</x-slot>
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
        
    </x-slot>

    <x-slot name="panel2">Puntos de Venta</x-slot>

    <x-slot name="body2">

        <x-data-table-no-plus>
            <x-slot name="table_title">Puntos de Venta</x-slot>
            <x-slot name="export_route">{{ route('programacion.export') }}</x-slot>
            <x-slot name="add_text">Añadir Item</x-slot>

            <x-slot name="head_tr">
                <tr>
                    <th></th>
                    <th>Nombre</th>
                </tr>
            </x-slot>

            <x-slot name="body_tr">
                @foreach ($pto_ventas as $index => $pto_venta)
                    <tr>
                        <td><input type="checkbox" name="" id=""></td>
                        <td>{{ $pto_venta->Nombre }}</td>
                    </tr>
                @endforeach
            </x-slot>

            <x-slot name="foot_tr">
                <tr>
                    <th></th>
                    <th>Nombre</th>
                </tr>
            </x-slot>
        </x-data-table-no-plus>

    </x-slot>

    <x-slot name="panel3">Artículos para Excluir</x-slot>

    <x-slot name="body3">

        <x-data-table-no-plus>
            <x-slot name="table_title">Artículos para Excluir</x-slot>
            <x-slot name="export_route">{{ route('programacion.export') }}</x-slot>
            <x-slot name="add_text">Añadir Item</x-slot>

            <x-slot name="head_tr">
                <tr>
                    <th></th>
                    <th>Código</th>
                    <th>Artículo</th>
                </tr>
            </x-slot>

            <x-slot name="body_tr">
                @foreach ($articulos as $index => $articulo)
                    <tr>
                        <td><input type="checkbox" name="" id=""></td>
                        <td>{{ $articulo->id }}</td>
                        <td>{{ $articulo->DESART }}</td>
                    </tr>
                @endforeach
            </x-slot>

            <x-slot name="foot_tr">
                <tr>
                    <th></th>
                    <th>Código</th>
                    <th>Artículo</th>
                </tr>
            </x-slot>
        </x-data-table-no-plus>

    </x-slot>

</x-panel-horizontal-3-no-title>

<x-panel-horizontal-2-no-title>        
    <x-slot name="panel1">Documentos</x-slot>
    <x-slot name="body1">

        <x-data-table-no-plus>
            <x-slot name="table_title">Documentos</x-slot>
            <x-slot name="export_route">{{ route('programacion.export') }}</x-slot>
            <x-slot name="add_text">Añadir Item</x-slot>

            <x-slot name="head_tr">
                <tr>
                    <th>Fecha</th>
                    <th>Número</th>
                    <th>Estado</th>
                    <th>Cod. Cliente</th>
                    <th>Razón Social</th>
                    <th>Cond. IVA</th>
                    <th>CUIT</th>
                    <th>Neto</th>
                    <th>IVA 21%</th>
                    <th>Total</th>
                </tr>
            </x-slot>

            <x-slot name="body_tr">
                @foreach ($documentos as $index => $documento)
                    <tr>
                        <td>{{ $documento->FechaEmision }}</td>
                        <td>{{ $documento->NumeroCompleto }}</td>
                        <td>{{ $documento->Estado }}</td>
                        <td>{{ $documento->IdCliente }}</td>
                        <td>{{ $documento->RazonSocial }}</td>
                        <td>{{ $documento->condicionIVA->Nombre == 'Responsable inscripto' ? 'RI' : $documento->condicionIVA->Nombre }}</td>
                        <td>{{ $documento->cliente->NroDocumento }}</td>
                        <td>{{ number_format($documento->Neto, 2, '.', '') }}</td>
                        <td>{{ number_format($documento->IVA, 2, '.', '') }}</td>
                        <td>{{ number_format($documento->Total, 2, '.', '') }}</td>
                    </tr>
                @endforeach
                <tr class="fw-bold">
                    <td colspan="7" class="text-end">Totales:</td>
                    <td>{{ number_format($total_neto, 2, '.', '') }}</td>
                    <td>{{ number_format($total_iva, 2, '.', '') }}</td>
                    <td>{{ number_format($total_total, 2, '.', '') }}</td>
                </tr>
            </x-slot>

            <x-slot name="foot_tr">
                <tr>
                    <th>Fecha</th>
                    <th>Número</th>
                    <th>Estado</th>
                    <th>Cod. Cliente</th>
                    <th>Razón Social</th>
                    <th>Cond. IVA</th>
                    <th>CUIT</th>
                    <th>Neto</th>
                    <th>IVA 21%</th>
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
                    <th>No Gravado</th>
                    <th>Exento</th>
                    <th>Neto</th>
                    <th>IVA</th>
                    <th>Total</th>
                </tr>
            </x-slot>

            <x-slot name="body_tr">
                @foreach (['Cons. Final','Exento','Resp. Inscripto','Resp. Monotributo','Totales'] as $tipo)
                    <tr>
                        <td>{{ $tipo }}</td>
                        <td>{{ number_format(0,2,'.','') }}</td>
                        <td>{{ number_format(0,2,'.','') }}</td>
                        <td>{{ number_format($total_neto,2,'.','') }}</td>
                        <td>{{ number_format($total_iva,2,'.','') }}</td>
                        <td>{{ number_format($total_total,2,'.','') }}</td>
                    </tr>
                @endforeach
            </x-slot>

            <x-slot name="foot_tr">
                <tr>
                    <th>Condición IVA</th>
                    <th>No Gravado</th>
                    <th>Exento</th>
                    <th>Neto</th>
                    <th>IVA</th>
                    <th>Total</th>
                </tr>
            </x-slot>
        </x-data-table-no-plus>

    </x-slot>

</x-panel-horizontal-2-no-title> --}}
</div>
