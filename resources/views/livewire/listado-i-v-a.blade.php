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
                {{-- Fila de totales dinámicos --}}
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

</x-panel-horizontal-2-no-title>
</div>
