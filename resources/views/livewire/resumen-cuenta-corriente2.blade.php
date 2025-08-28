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
                        <input id="sidebarSearch" wire:model.live="cliente_id"
                            class="form-control form-control-sm bg-white text-dark" 
                            type="search" placeholder="0" aria-label="Search">
                        <div class="input-group-append">
                            <a href="" class="btn btn-sidebar btn-sm bg-orange">
                                <i class="fas fa-search fa-fw text-white"></i>
                            </a>
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
                        <a href="" class="btn btn-sidebar btn-sm bg-orange">
                            <i class="fas fa-ellipsis-h fa-fw text-white"></i>
                        </a>
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

            @if($cliente)
                @php
                    $saldo = $cliente->SaldoSistemaAnterior;
                @endphp

                <tr>
                    <td></td>
                    <td></td>
                    <td>Saldo Anterior</td>
                    <td>{{ number_format($cliente->SaldoSistemaAnterior, 2, '.', '') }}</td>
                    <td></td>
                    <td>{{ number_format($saldo, 2, '.', '') }}</td>
                </tr>

                @foreach ($facturas as $factura)
                    @php
                        $saldo += $factura->Total;
                    @endphp
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($factura->FechaEmision)->format('j/n/Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($factura->FechaVencimiento)->format('j/n/Y') }}</td>
                        <td>{{ $factura->NumeroCompleto }}</td>
                        <x-slot name="debe">{{ number_format($factura->Total, 2, '.', '') }}</x-slot>
                        <x-slot name="haber"></x-slot>
                        <td>{{ number_format($factura->Total, 2, '.', '') }}</td>
                        <td></td>
                        <td>{{ number_format($saldo, 2, '.', '') }}</td>
                    </tr>
                @endforeach

                @foreach ($recibos as $recibo)
                    @php
                        $saldo -= $recibo->Total;
                    @endphp
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($recibo->FechaEmision)->format('j/n/Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($recibo->FechaVencimiento)->format('j/n/Y') }}</td>
                        <td>{{ $recibo->NumeroCompleto }}</td>
                        <td></td>
                        <td>{{ number_format($recibo->Total, 2, '.', '') }}</td>
                        <td>{{ number_format($saldo, 2, '.', '') }}</td>
                    </tr>
                @endforeach

                @foreach ($notas_de_credito as $nota)
                    @php
                        $saldo -= $nota->Total;
                    @endphp
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($nota->FechaEmision)->format('j/n/Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($nota->FechaVencimiento)->format('j/n/Y') }}</td>
                        <td>{{ $nota->NumeroCompleto }}</td>
                        <td></td>
                        <td>{{ number_format($nota->Total, 2, '.', '') }}</td>
                        <td>{{ number_format($saldo, 2, '.', '') }}</td>
                    </tr>
                @endforeach

                <tr>
                    <td></td>
                    <td></td>
                    <td><strong>Total Saldo</strong></td>
                    <td></td>
                    <td></td>
                    <td><strong>{{ number_format($saldo, 2, '.', '') }}</strong></td>
                </tr>
            @endif

        </x-slot>
    </x-simple-table2>


    <div class="d-flex justify-content-end">
        <a class="btn btn-app bg-info">
            <i class="fas fa-print"></i> Imprimir
        </a>

        <a class="btn btn-app bg-info">
            <i class="fas fa-share"></i> Enviar
        </a>
    </div>
</div>
