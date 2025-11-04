<div>
<div>
    <x-simple-table2>
        <x-slot name="filtros">
            <div class="row">
                <div class="col-2">
                    <div class="form-group mb-0">
                        <label for="filtro1" class="font-weight-normal">CODIGO</label>
                    </div>
                    <div class="input-group">
                        <input id="sidebarSearch" wire:model.live="proveedor_id"
                            class="form-control form-control-sm bg-white text-dark" 
                            type="search" placeholder="0" aria-label="Search">
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

                <div class="col-2">
                    <div class="form-group mb-0">
                        <label for="filtro1" class="font-weight-normal">DESDE FECHA</label>
                        <input type="date" id="filtro1" name="filtro1" wire:model.live="cliente_desde" class="form-control form-control-sm" placeholder="Buscar...">
                    </div>
                </div>

                <div class="col-2">
                    <div class="form-group mb-0">
                        <label for="filtro1" class="font-weight-normal">HASTA FECHA</label>
                        <input type="date" id="filtro1" name="filtro1" wire:model.live="cliente_hasta" class="form-control form-control-sm" placeholder="Buscar...">
                    </div>
                </div>

                <div class="col-2 d-flex align-items-end">
                    <div class="input-group-append">
                        <button type="button" 
                                class="btn btn-sidebar btn-sm bg-orange" 
                                data-toggle="modal" 
                                data-target="#modal-periodos">
                            <i class="fas fa-ellipsis-h fa-fw text-white"></i>
                        </button>
                    </div>
                </div>

            </div>
            </div>
        </x-slot>
        <x-slot name="thead">
            <tr>
                <th>FECHA</th>
                <th>FECHA VENC.</th>
                <th>CONCEPTOS</th>
                <th>DEBE</th>
                <th>HABER</th>
                <th>SALDO</th>
            </tr>
        </x-slot>

        <x-slot name="tbody">

            @if ($proveedor)
                @php 
                    $saldo = $proveedor->SaldoSistemaAnterior ?? 0; 
                    $minFilas = 9;
                @endphp

                {{-- Saldo anterior --}}
                <tr>
                    <td></td>
                    <td></td>
                    <td>Saldo Anterior</td>
                    <td>{{ number_format($saldo, 2, '.', '') }}</td>
                    <td></td>
                    <td>{{ number_format($saldo, 2, '.', '') }}</td>
                </tr>

                {{-- Movimientos --}}
                @foreach ($documentos as $item)
                    @php
                        $doc = $item['documento'];
                        $tipo = $item['tipo'];

                        if ($tipo === 'factura') {
                            $saldo += $doc->Total;
                            $debe = number_format($doc->Total, 2, '.', '');
                            $haber = '';
                        } elseif ($tipo === 'pago' || $tipo === 'nota') {
                            $saldo -= $doc->Total;
                            $debe = '';
                            $haber = number_format($doc->Total, 2, '.', '');
                        } else {
                            $debe = $haber = '';
                        }
                    @endphp
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($doc->FechaEmision)->format('d/m/Y') }}</td>
                        <td>{{ $doc->FechaVencimiento ? \Carbon\Carbon::parse($doc->FechaVencimiento)->format('d/m/Y') : '' }}</td>
                        <td>{{ $doc->NumeroCompleto ?? ($tipo === 'pago' ? 'Pago #' . $doc->id : '') }}</td>
                        <td>{{ $debe }}</td>
                        <td>{{ $haber }}</td>
                        <td>{{ number_format($saldo, 2, '.', '') }}</td>
                    </tr>
                @endforeach

                {{-- Total --}}
                <tr>
                    <td colspan="5"><strong>Total Saldo</strong></td>
                    <td><strong>{{ number_format($saldo, 2, '.', '') }}</strong></td>
                </tr>

                {{-- Relleno para mantener altura --}}
                @php
                    $filasActuales = count($documentos) + 1;
                    $filasFaltantes = max(0, $minFilas - $filasActuales);
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

            @else
                {{-- Sin proveedor seleccionado --}}
                <tr>
                    <td></td>
                    <td></td>
                    <td>Saldo Anterior</td>
                    <td>{{ number_format(0, 2, '.', '') }}</td>
                    <td></td>
                    <td>{{ number_format(0, 2, '.', '') }}</td>
                </tr>
                <tr>
                    <td colspan="5"><strong>Total Saldo</strong></td>
                    <td><strong>{{ number_format(0, 2, '.', '') }}</strong></td>
                </tr>
                @for ($i = 0; $i < 9; $i++)
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                @endfor
            @endif

        </x-slot>

    </x-simple-table2>

    <div class="d-flex justify-content-end mt-3">
        <a class="btn btn-app bg-info disabled">
            <i class="fas fa-print"></i> Imprimir
        </a>

        <a class="btn btn-app bg-info disabled">
            <i class="fas fa-share"></i> Enviar
        </a>
    </div>

     <!-- .modal -->
    <div class="modal fade" id="modal-cliente" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title">
                    BUSCAR PROVEEDOR
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
                                <th>CUIT</th>
                                <th>DOMICILIO</th>
                                <th>LOCALIDAD</th>
                                <th>PROVINCIA</th>
                                <th>ACTIVO</th>
                            </tr>
                        </x-slot>
                        <x-slot name="tbody">
                            
                            @forelse ($proveedores as $proveedor)
                                <tr wire:click.prevent="seleccionarCliente({{ $proveedor->id }})"
                                    style="cursor:pointer;"
                                    class="{{ $proveedor_id == $proveedor->id ? 'table-primary' : '' }}">
                                    <td>{{ $proveedor->id }}</td>
                                    <td>{{ $proveedor->Nombre }}</td>
                                    <td>{{ $proveedor->NumeroDocumento }}</td>
                                    <td>{{ $proveedor->Direccion }}</td>
                                    <td>{{ $proveedor->Localidad }}</td>
                                    <td>{{ $proveedor->Provincia }}</td>
                                    <td><input type="checkbox" name="" id="" disabled {{ $proveedor->Activo == 1 ? 'checked' : '' }}></td>
                                </tr>
                            @empty
                                <tr><td colspan="8">No se encontraron resultados.</td></tr>
                            @endforelse
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
</div>
