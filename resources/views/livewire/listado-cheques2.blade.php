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

        </div>
      </div>
    </x-slot>
    <x-slot name="thead">
        <tr>
            <th>FECHA EMISION</th>
            <th>FECHA VENC.</th>
            <th>BANCO</th>
            <th>NUMERO</th>
            <th>PLAZA</th>
            <th>E-CHECK</th>
            <th>IMPORTE</th>
            <th>RECIBO</th>
            <th>COD. CLIENTE</th>
            <th>RAZON SOCIAL</th>
            <th>DESTINO</th>
        </tr>
    </x-slot>
    <x-slot name="tbody">

        @php
            $filasFaltantes = max(0, 11 - count($cheques_cobro));
        @endphp

        @forelse ($cheques_cobro as $cheque_cobro)
            <tr>
                <td>{{ \Carbon\Carbon::parse($cheque_cobro->FechaEmision)->format('j/n/Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($cheque_cobro->FechaAcreditacion)->format('j/n/Y') }}</td>
                <td>{{ $cheque_cobro->banco->Nombre }}</td>
                <td>{{ $cheque_cobro->Numero }}</td>
                <td>{{ $cheque_cobro->Plaza }}</td>
                <td class="text-center">
                    <input type="checkbox" disabled {{ $cheque_cobro->eCheck ? 'checked' : '' }}>
                </td>
                <td>{{ number_format($cheque_cobro->cobro->Total, 2, '.', '') }}</td>
                <td>{{ $cheque_cobro->cobro->reciboVenta->NumeroCompleto }}</td>
                <td>{{ $cheque_cobro->cobro->reciboVenta->IdCliente }}</td>
                <td>{{ $cheque_cobro->cobro->reciboVenta->RazonSocial }}</td>
                <td>
                    <select wire:model.live="destinosSeleccionados.{{ $cheque_cobro->id }}">
                        @foreach ($destinos_cheque as $destino)
                            <option value="{{ $destino->id }}" {{ $cheque_cobro->IdDestinoCheque == $destino->id ? 'selected' : '' }}>
                                {{ $destino->Nombre }}
                            </option>
                        @endforeach
                    </select>
                </td>
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
                <td>&nbsp;</td>
            </tr>
        @endfor

    </x-slot>
</x-simple-table2>