<x-simple-table2>
    <x-slot name="filtros">
        <div class="row">

            <div class="col-2">
                <div class="form-group mb-0">
                    <label for="filtro1" class="font-weight-normal">DESDE FECHA EMISION</label>
                    <input type="date" id="filtro1" name="filtro1" wire:model.live="cliente_desde" class="form-control form-control-sm" placeholder="Buscar...">
                </div>
            </div>

            <div class="col-2">
                <div class="form-group mb-0">
                    <label for="filtro1" class="font-weight-normal">HASTA FECHA</label>
                    <input type="date" id="filtro1" name="filtro1" wire:model.live="cliente_hasta" class="form-control form-control-sm" placeholder="Buscar...">
                </div>
            </div>

            <div class="col-2">
                <div class="form-group mb-0">
                    <label for="filtro1" class="font-weight-normal">ACREDITA DESDE</label>
                    <input type="date" id="filtro1" name="filtro1" wire:model.live="cliente_hasta" class="form-control form-control-sm" placeholder="Buscar...">
                </div>
            </div>
        </div>
      </div>
    </x-slot>
    <x-slot name="thead">
        <tr>
            <th>FECHA</th>
            <th>FECHA VENC.</th>
            <th>BANCO</th>
            <th>NUMERO</th>
            <th>PLAZA</th>
            <th>E-CHECK</th>
            <th>IMPORTE</th>
            <th>ORDEN DE PAGO</th>
            <th>COD. PROVEEDOR</th>
            <th>RAZON SOCIAL</th>
        </tr>
    </x-slot>
    <x-slot name="tbody">

        @php
            $filasFaltantes = max(0, 11 - count($cheques_pago));
        @endphp

        @forelse ($cheques_pago as $cheque_pago)
            <tr>

                <td>{{ \Carbon\Carbon::parse($cheque_pago->FechaEmision)->format('j/n/Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($cheque_pago->FechaAcreditacion)->format('j/n/Y') }}</td>
                <td>{{ $cheque_pago->banco->Nombre }}</td>
                <td>{{ $cheque_pago->Numero }}</td>
                <td>{{ $cheque_pago->Plaza }}</td>
                <td>
                    <input type="checkbox" disabled {{ $cheque_pago->eCheck ? 'checked' : '' }}>
                </td>
                <td>{{ number_format($cheque_pago->pago->Total, 2, '.', '') }}</td>
                <td>{{ $cheque_pago->pago->ordenPago->NumeroCompleto }}</td>
                <td>{{ $cheque_pago->pago->ordenPago->IdProveedor }}</td>
                <td>{{ $cheque_pago->pago->ordenPago->RazonSocial }}</td>
            </tr>
        @empty
            <tr><td colspan="11">No se encontraron resultados.</td></tr>
        @endforelse

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
</x-simple-table2>