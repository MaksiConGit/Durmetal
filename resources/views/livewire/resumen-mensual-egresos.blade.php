<x-simple-table2>
    <x-slot name="filtros">
        <div class="row">
            <div class="col-2">
                <div class="form-group mb-0">
                    <label class="font-weight-normal">DESDE FECHA</label>
                    <input type="date" wire:model.live="cliente_desde" class="form-control form-control-sm">
                </div>
            </div>
            <div class="col-2">
                <div class="form-group mb-0">
                    <label class="font-weight-normal">HASTA FECHA</label>
                    <input type="date" wire:model.live="cliente_hasta" class="form-control form-control-sm">
                </div>
            </div>
        </div>
    </x-slot>

    <x-slot name="thead">
        <tr>
            <th>CUENTA</th>
            <th>TIPO</th>
            <th>ENERO</th>
            <th>FEBRERO</th>
            <th>MARZO</th>
            <th>ABRIL</th>
            <th>MAYO</th>
            <th>JUNIO</th>
            <th>JULIO</th>
            <th>AGOSTO</th>
            <th>SEPTIEMBRE</th>
            <th>OCTUBRE</th>
            <th>NOVIEMBRE</th>
            <th>DICIEMBRE</th>
            <th>TOTAL</th>
        </tr>
    </x-slot>

    <x-slot name="tbody">
        @foreach ($cuentas_gastos as $cuenta)
            <tr>
                <td>{{ $cuenta['nombre'] }}</td>
                <td>GASTOS</td>
                @foreach ($cuenta['mensuales'] as $importe)
                    <td>{{ number_format($importe, 2, '.', '') }}</td>
                @endforeach
                <td>{{ number_format($cuenta['total'], 2, '.', '') }}</td>
            </tr>
        @endforeach

        @foreach ($cuentas_otros_egresos as $cuenta)
            <tr>
                <td>{{ $cuenta['nombre'] }}</td>
                <td>OTROS EGRESOS</td>
                @foreach ($cuenta['mensuales'] as $importe)
                    <td>{{ number_format($importe, 2, '.', '') }}</td>
                @endforeach
                <td>{{ number_format($cuenta['total'], 2, '.', '') }}</td>
            </tr>
        @endforeach

        @php
            $totales = array_fill(1, 12, 0);
            $gran_total = 0;

            foreach ($cuentas_gastos as $c) {
                foreach ($c['mensuales'] as $i => $v) $totales[$i] += $v;
                $gran_total += $c['total'];
            }

            foreach ($cuentas_otros_egresos as $c) {
                foreach ($c['mensuales'] as $i => $v) $totales[$i] += $v;
                $gran_total += $c['total'];
            }
        @endphp

        <tr class="text-bold bg-light">
            <td>SUBTOTAL MENSUAL</td>
            <td></td>
            @foreach ($totales as $importe)
                <td>{{ number_format($importe, 2, '.', '') }}</td>
            @endforeach
            <td>{{ number_format($gran_total, 2, '.', '') }}</td>
        </tr>
    </x-slot>
</x-simple-table2>