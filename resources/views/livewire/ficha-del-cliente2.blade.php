<div>
<div>
<x-simple-table2>
    <x-slot name="filtros">
        <div class="row">
          <div class="col-2">
            <div class="form-group mb-0">
                <label for="filtro1" class="font-weight-normal">CODIGO</label>
                <input type="text" id="filtro1" name="filtro1" wire:model.live="codigo" class="form-control form-control-sm" placeholder="Buscar...">
            </div>
          </div>
          <div class="col-2">
            <div class="form-group mb-0">
                <label for="filtro1" class="font-weight-normal">NOMBRE</label>
                <input type="text" id="filtro1" name="filtro1" wire:model.live="nombre" class="form-control form-control-sm" placeholder="Buscar...">
            </div>
          </div>
          <div class="col-2">
            <div class="form-group mb-0">
                <label for="filtro1" class="font-weight-normal">N° DOCUMENTO</label>
                <input type="text" id="filtro1" name="filtro1" wire:model.live="documento" class="form-control form-control-sm" placeholder="Buscar...">
            </div>
          </div>
          <div class="col-4">
            <div class="form-group mb-0">
                <label for="filtro1" class="font-weight-normal">FILTROS</label>
                <select name="" id="" wire:model.live="filtro" class="form-control form-control-sm">
                    <option value="">Seleccionar</option>
                    <option value="trabajos_pendientes_nota_envio">CON TRABAJOS PENDIENTES DE NOTA DE ENVIO</option>
                    <option value="notas_pendientes">CON NOTAS DE ENVIO PENDIENTES DE FACTURAR</option>
                    <option value="facturas_pendientes">CON FACTURAS PENDIENTES DE PAGO</option>
                </select>
            </div>
          </div>
        </div>
      </div>
    </x-slot>
    <x-slot name="thead">
        <tr>
            @if($filtro !== null && $filtro !== '')
                <th>Total</th>
            @endif
            <th>Código</th>
            <th>Nombre</th>
            <th>N° Documento</th>
            <th>Domicilio</th>
            <th>Localidad</th>
            <th>Provincia</th>
            <th>Condición IVA</th>
        </tr>
    </x-slot>
    <x-slot name="tbody">
        @forelse ($clientes as $cliente)
            <tr style="cursor: pointer;" 
                onclick="window.location='{{ match($filtro) {
                    'trabajos_pendientes_nota_envio' => route('ventas.ficha-del-cliente-nota-envio.create', $cliente),
                    'notas_pendientes' => route('ventas.ficha-del-cliente-factura-venta.create', $cliente),
                    'facturas_pendientes' => route('ventas.ficha-del-cliente-recibo-venta.create', $cliente),
                    default => route('ventas.ficha-del-cliente.show', $cliente)
                } }}'">
                
                @if($filtro !== null && $filtro !== '')
                    <td>
                        @switch($filtro)
                            @case('notas_pendientes')
                                {{ $cliente->notas_envio_pendientes_count }}
                                @break
                            @case('facturas_pendientes')
                                {{ $cliente->facturas_pendientes_count }}
                                @break
                            @case('trabajos_pendientes_nota_envio')
                                {{ $cliente->ordenes_trabajo_pendientes_count  }}
                                @break
                        @endswitch
                    </td>
                @endif

                <td>{{ $cliente->id }}</td>
                <td>{{ $cliente->Nombre }}</td>
                <td>{{ $cliente->NroDocumento }}</td>
                <td>{{ $cliente->Domicilio }}</td>
                <td>{{ $cliente->localidad->Nombre ?? '-' }}</td>
                <td>{{ $cliente->localidad->provincia->Nombre ?? '-' }}</td>
                <td>{{ $cliente->condicionIVA->Nombre ?? '-' }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="9">No se encontraron resultados.</td>
            </tr>
        @endforelse
    </x-slot>
</x-simple-table2>
