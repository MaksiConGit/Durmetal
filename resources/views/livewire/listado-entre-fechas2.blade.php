{{-- <div>
    <div class="card">
        <div class="card-header">
            <div class="card-title">Filtros</div>
        </div>

        <div class="card-body">
            <div class="row">

        <div class="col-md-3">
            <x-form-input-date-livewire>
                <x-slot name="label">Desde Fecha</x-slot>
                <x-slot name="livewire">wire:model.live="cliente_desde"</x-slot>
                <x-slot name="name">cliente_desde</x-slot>
                <x-slot name="message"></x-slot>
                <x-slot name="value"></x-slot>
                <x-slot name="error"></x-slot>
            </x-form-input-date-livewire>
        </div>

        <div class="col-md-3">
            <x-form-input-date-livewire>
                <x-slot name="label">Hasta Fecha</x-slot>
                <x-slot name="livewire">wire:model.live="cliente_hasta"</x-slot>
                <x-slot name="name">cliente_hasta</x-slot>
                <x-slot name="message"></x-slot>
                <x-slot name="value"></x-slot>
                <x-slot name="error"></x-slot>
            </x-form-input-date-livewire>
        </div>

    </div>

    <x-data-table-no-plus>
      
        <x-slot name="table_title">Otros Egresos entre Fechas</x-slot>
        <x-slot name="export_route">{{ route('clients.export') }}</x-slot>
        <x-slot name="create_route">{{ route('otros-egresos.otros-egresos.create') }}</x-slot>
        <x-slot name="add_text">Añadir Otro Egreso</x-slot>
        <x-slot name="head_tr">
            <tr>
                <th>Cuenta</th>
                <th>Subcuentas</th>
                <th>Detalle Subcuentas</th>
                <th>Importe</th>
            </tr>
        </x-slot>
        <x-slot name="body_tr">
            @php
                $totall = 0;   
            @endphp
    
            @forelse ($cuentas_otros_egresos as $padre)
                <tr>
                    @php
                        $totall += $padre->total_movimientos;
                    @endphp
                    <td>{{ $padre->Nombre }}</td>
                    <td></td>
                    <td></td>
                    <td>{{ number_format($padre->total_movimientos, 2, '.', '') }}</td>
                </tr>

                @foreach ($padre->hijos as $hijo)
                    @php
                        $totall += $hijo->total_movimientos;
                    @endphp
                    <tr>
                        <td></td>
                        <td>{{ $hijo->Nombre }}</td>
                        <td>{{ number_format($hijo->total_movimientos, 2, '.', '') }}</td>
                        <td></td>
                    </tr>

                @endforeach
            @empty
                <tr><td colspan="4">No se encontraron resultados.</td></tr>
            @endforelse

            <tr>
                <td>Total del Periodo</td>
                <td></td>
                <td></td>
                <td>{{ number_format($totall, 2, '.', '') }}</td>
            </tr>
        </x-slot>
        <x-slot name="foot_tr">
            <tr>
                <th>Cuenta</th>
                <th>Subcuentas</th>
                <th>Detalle Subcuentas</th>
                <th>Importe</th>
            </tr>
        </x-slot>
    </x-data-table-no-plus>
</div> --}}

<div>
<div>
    <x-simple-table2>
        <x-slot name="filtros">
            <div class="row">

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
                <th>CUENTA</th>
                <th>SUBCUENTAS</th>
                <th>DETALLE SUBCUENTAS</th>
                <th>IMPORTE</th>
            </tr>
        </x-slot>
        <x-slot name="tbody">



            @php
                $totall = 0;   
            @endphp
    
            @forelse ($cuentas_otros_egresos as $padre)
                <tr>
                    @php
                        $totall += $padre->total_movimientos;
                    @endphp
                    <td>{{ $padre->Nombre }}</td>
                    <td></td>
                    <td></td>
                    <td><strong>{{ number_format($padre->total_movimientos, 2, '.', '') }}</strong></td>
                </tr>

                @foreach ($padre->hijos as $hijo)
                    @php
                        $totall += $hijo->total_movimientos;
                    @endphp
                    <tr>
                        <td></td>
                        <td>{{ $hijo->Nombre }}</td>
                        <td>{{ number_format($hijo->total_movimientos, 2, '.', '') }}</td>
                        <td></td>
                    </tr>

                @endforeach
            @empty
                <tr><td colspan="4">No se encontraron resultados.</td></tr>
            @endforelse

            <tr>
                <td>Total del Periodo</td>
                <td></td>
                <td></td>
                <td><strong>{{ number_format($totall, 2, '.', '') }}</strong></td>
            </tr>




            {{-- @if($cliente)

                @php 
                    $saldo = $cliente->SaldoSistemaAnterior; 
                    $minFilas = 9;
                @endphp

                <tr>
                    <td></td>
                    <td></td>
                    <td>Saldo Anterior</td>
                    <td>{{ number_format($saldo, 2, '.', '') }}</td>
                    <td></td>
                    <td>{{ number_format($saldo, 2, '.', '') }}</td>
                </tr>

                @foreach ($documentos as $item)
                    @php
                        $doc = $item['documento'];
                        if ($item['tipo'] === 'factura') {
                            $saldo += $doc->Total;
                            $debe = number_format($doc->Total, 2, '.', '');
                            $haber = '';
                        } else {
                            $saldo -= $doc->Total;
                            $debe = '';
                            $haber = number_format($doc->Total, 2, '.', '');
                        }
                    @endphp
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($doc->FechaEmision)->format('j/n/Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($doc->FechaVencimiento)->format('j/n/Y') }}</td>
                        <td>{{ $doc->NumeroCompleto ?? '' }}</td>
                        <td>{{ $debe }}</td>
                        <td>{{ $haber }}</td>
                        <td>{{ number_format($saldo, 2, '.', '') }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="5"><strong>Total Saldo</strong></td>
                    <td><strong>{{ number_format($saldo, 2, '.', '') }}</strong></td>
                </tr>
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
            @endif --}}

        </x-slot>

    </x-simple-table2>

    <div class="d-flex justify-content-end mt-3">
        <a class="btn btn-app bg-info disabled">
            <i class="fas fa-print"></i> Imprimir
        </a>
    </div>

    <!-- .modal -->
    {{-- <div class="modal fade" id="modal-periodos" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title">
                    PERIODOS
                </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <x-simple-table2>

                        <x-slot name="tbody">
                            
                            @forelse ($periodos as $periodo)
                                <tr wire:click.prevent="seleccionarPeriodo({{ $periodo->id }})"
                                    style="cursor:pointer;"
                                    class="{{ $periodo_id == $periodo->id ? 'table-primary' : '' }}">
                                    <td>{{ $periodo->Nombre }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="1">No se encontraron resultados.</td></tr>
                            @endforelse

                        </x-slot>
                    </x-simple-table2>

                </div>

                <div class="modal-footer justify-content-end">

                    <button class="btn btn-sidebar btn-sm bg-orange" data-dismiss="modal">
                        <span class="text-white">Aceptar</span>
                        <i class="fas fa-check fa-fw text-white ml-2"></i>
                    </button>

                    <button class="btn btn-sidebar btn-sm bg-orange" 
                            data-dismiss="modal" 
                            wire:click="cancelarPeriodo">
                        <span class="text-white">Cancelar</span>
                        <i class="fas fa-xmark fa-fw text-white ml-2"></i>
                    </button>

                </div>

            </div>
        </div>
    </div> --}}
    <!-- /.modal -->
</div>
