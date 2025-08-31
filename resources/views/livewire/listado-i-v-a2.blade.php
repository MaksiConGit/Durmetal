<div>

    <x-panel-horizontal2>

        <x-slot name="pestañas">

            <li class="nav-item">
                <a class="nav-link {{ $activeTabParametros === 'custom-tabs-1' ? 'active' : '' }}" wire:click.prevent="setActiveTabParametros('custom-tabs-1')" id="custom-tabs-1-tab" data-toggle="pill" href="#custom-tabs-1" role="tab" aria-controls="custom-tabs-1" aria-selected="true">PARAMETROS</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $activeTabParametros === 'custom-tabs-2' ? 'active' : '' }}" wire:click.prevent="setActiveTabParametros('custom-tabs-2')" id="custom-tabs-2-tab" data-toggle="pill" href="#custom-tabs-2" role="tab" aria-controls="custom-tabs-2" aria-selected="true">PUNTOS DE VENTA</a>
            </li>
            <li class="nav-item {{ $activeTabParametros === 'custom-tabs-3' ? 'active' : '' }}" wire:click.prevent="setActiveTabParametros('custom-tabs-3')">
                <a class="nav-link" id="custom-tabs-3-tab" data-toggle="pill" href="#custom-tabs-3" role="tab" aria-controls="custom-tabs-3" aria-selected="true">ARTICULOS PARA EXCLUIR</a>
            </li>

        </x-slot>

        <x-slot name="ventanas">

            <div class="tab-pane fade show {{ $activeTabParametros === 'custom-tabs-1' ? 'active' : '' }}" id="custom-tabs-1" role="tabpanel" aria-labelledby="custom-tabs-1-tab" style="height:6rem">

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


            <div class="tab-pane fade show {{ $activeTabParametros === 'custom-tabs-2' ? 'active' : '' }}" id="custom-tabs-2" role="tabpanel" aria-labelledby="custom-tabs-2-tab" style="height:6rem">

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
                                <td>
                                    <input type="checkbox"
                                        value="{{ $pto_venta->Numero }}"
                                        wire:model.live="puntos_venta_seleccionados">
                                </td>
                                <td>{{ $pto_venta->Nombre }}</td>
                                <td></td>
                            </tr>
                        @endforeach

                    </x-slot>

                </x-simple-table2-no-limit>

            </div>

            <div class="tab-pane fade show {{ $activeTabParametros === 'custom-tabs-3' ? 'active' : '' }}" id="custom-tabs-3" role="tabpanel" aria-labelledby="custom-tabs-3-tab" style="height:6rem">

                <div style="max-height: 100%; overflow-y: auto; overflow-x: hidden;">

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
                                    <td><input type="checkbox" name="" id="" disabled></td>
                                    <td>{{ $articulo->id }}</td>
                                    <td>{{ $articulo->DESART }}</td>
                                </tr>
                            @endforeach

                        </x-slot>

                    </x-simple-table2-no-limit>

                </div>

            </div>

        </x-slot>

    </x-panel-horizontal2>
    

    <x-panel-horizontal2>

        <x-slot name="pestañas">

            <li class="nav-item">
                <a class="nav-link {{ $activeTabDocumentos === 'custom-tabs-4' ? 'active' : '' }}" wire:click.prevent="setActiveTabDocumentos('custom-tabs-4')" id="custom-tabs-4-tab" data-toggle="pill" href="#custom-tabs-4" role="tab" aria-controls="custom-tabs-4" aria-selected="true">DOCUMENTOS</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $activeTabDocumentos === 'custom-tabs-5' ? 'active' : '' }}" wire:click.prevent="setActiveTabDocumentos('custom-tabs-5')" id="custom-tabs-5-tab" data-toggle="pill" href="#custom-tabs-5" role="tab" aria-controls="custom-tabs-5" aria-selected="true">CONDICION IVA</a>
            </li>
            
        </x-slot>

        <x-slot name="ventanas">

            <div class="tab-pane fade show {{ $activeTabDocumentos === 'custom-tabs-4' ? 'active' : '' }}" id="custom-tabs-4" role="tabpanel" aria-labelledby="custom-tabs-4-tab" style="height:30rem">

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

                        @php
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
                        @endfor

                    </x-slot>

                </x-simple-table2-no-limit>

            </div>

            <div class="tab-pane fade show {{ $activeTabDocumentos === 'custom-tabs-5' ? 'active' : '' }}" id="custom-tabs-5" role="tabpanel" aria-labelledby="custom-tabs-5-tab" style="height:30rem">

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