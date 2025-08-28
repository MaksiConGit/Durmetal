<x-simple-table2>
    <x-slot name="filtros">
        <div class="row">

            <div class="col-2">
                <div class="form-group mb-0">
                    <label for="filtro1" class="font-weight-normal">DESDE FECHA EMISION</label>
                    <input type="date" id="filtro1" name="filtro1" wire:model.live="fecha_inicio" class="form-control form-control-sm" placeholder="Buscar...">
                </div>
            </div>

            <div class="col-2">
                <div class="form-group mb-0">
                    <label for="filtro1" class="font-weight-normal">HASTA FECHA</label>
                    <input type="date" id="filtro1" name="filtro1" wire:model.live="fecha_fin" class="form-control form-control-sm" placeholder="Buscar...">
                </div>
            </div>

          <div class="col-4">
            <div class="form-group mb-0">
                <label for="filtro1" class="font-weight-normal">RETENCION</label>
                <select name="" id="" wire:model.live="retencion_id" class="form-control form-control-sm">
                    <option value="1">Todas las retenciones</option>
                    <option value="2">DREI</option>
                    <option value="3">GANANCIAS</option>
                    <option value="4">IIBB</option>
                    <option value="5">IVA</option>
                    <option value="6">SUSS</option>
                </select>
            </div>
          </div>
        </div>
      </div>
    </x-slot>
    <x-slot name="thead">
        <tr>
            <th>FECHA EMISION</th>
            <th>COD. CLIENTE</th>
            <th>RAOZN SOCIAL</th>
            @if($retencion_id == 1 || $retencion_id == 2) <th>DREI</th> @endif
            @if($retencion_id == 1 || $retencion_id == 4) <th>IIBB</th> @endif
            @if($retencion_id == 1 || $retencion_id == 5) <th>IVA</th> @endif
            @if($retencion_id == 1 || $retencion_id == 3) <th>GANANCIAS</th> @endif
            @if($retencion_id == 1 || $retencion_id == 6) <th>SUSS</th> @endif
        </tr>
    </x-slot>
    <x-slot name="tbody">

        @forelse ($recibos_venta as $recibo)
            <tr>
                <td>{{ \Carbon\Carbon::parse($recibo->FechaEmision)->format('j/n/Y') }}</td>
                <td>{{ $recibo->IdCliente }}</td>
                <td>{{ $recibo->RazonSocial }}</td>

                @if($retencion_id == 1 || $retencion_id == 2)
                    <td>{{ number_format($recibo->RetencionDREI, 2, '.', '') }}</td>
                @endif

                @if($retencion_id == 1 || $retencion_id == 3)
                    <td>{{ number_format($recibo->RetencionGanancias, 2, '.', '') }}</td>
                @endif

                @if($retencion_id == 1 || $retencion_id == 4)
                    <td>{{ number_format($recibo->RetencionIIBB, 2, '.', '') }}</td>
                @endif

                @if($retencion_id == 1 || $retencion_id == 5)
                    <td>{{ number_format($recibo->RetencionIVA, 2, '.', '') }}</td>
                @endif

                @if($retencion_id == 1 || $retencion_id == 6)
                    <td>{{ number_format($recibo->RetencionSUSS, 2, '.', '') }}</td>
                @endif
            </tr>
        @empty
            <tr><td colspan="8">No se encontraron resultados.</td></tr>
        @endforelse

    </x-slot>
</x-simple-table2>
