<div>

    <x-layout2>
        <x-slot name="title">Listado de saldos de clientes</x-slot>
        
        <x-simple-table2>
            <x-slot name="filtros">
                <div class="row">
                    <div class="col-2">
                        <label>LISTA DESDE</label>
                        <input type="text" class="form-control form-control-sm" wire:model.live="lista_desde" placeholder="Desde letra...">
                    </div>
                    <div class="col-2">
                        <label>LISTA HASTA</label>
                        <input type="text" class="form-control form-control-sm" wire:model.live="lista_hasta" placeholder="Hasta letra...">
                    </div>
                    <div class="col-2">
                        <label>HASTA FECHA</label>
                        <input type="date" class="form-control form-control-sm" wire:model.live="hasta_fecha">
                    </div>
                    <div class="col-2 mt-4">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" wire:model.live="incluir_saldos">
                            <label class="form-check-label">INCLUIR SALDOS EN 0</label>
                        </div>
                    </div>
                </div>

            </div>
            </x-slot>
            <x-slot name="thead">
                <tr>
                    <th></th>
                    <th>CODIGO</th>
                    <th>NOMBRE</th>
                    <th>CUIT</th>
                    <th>FECHA FACTURA PENDIENTE</th>
                    <th>FECHA VENC.</th>
                    <th>SALDO</th>
                </tr>
            </x-slot>
            <x-slot name="tbody">

                @forelse ($clientes as $cliente)
                    <tr wire:click="seleccionarCliente({{ $cliente->id }})" 
                        class="{{ $clienteSeleccionado == $cliente->id ? 'table-primary' : '' }}" style="cursor: pointer;">
                        <td><input type="checkbox" name="cliente_seleccionado" value=""></td>
                        <td>{{ $cliente->id }}</td>
                        <td>{{ $cliente->Nombre }}</td>
                        <td>{{ $cliente->NroDocumento }}</td>
                        <td>{{ $cliente->factura_atrasada_emision ? \Carbon\Carbon::parse($cliente->factura_atrasada_emision)->format('j/n/Y') : '' }}</td>
                        <td class="text-red">{{ $cliente->factura_atrasada_vencimiento ? \Carbon\Carbon::parse($cliente->factura_atrasada_vencimiento)->format('j/n/Y') : '' }}</td>
                        <td>{{ number_format($cliente->saldo, 2, '.', '') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="7">No se encontraron resultados.</td></tr>
                @endforelse

            </x-slot>
        </x-simple-table2>

        <div class="d-flex justify-content-end mr-3">
            <a class="btn btn-app bg-primary" 
            href="{{ $clienteSeleccionado ? route('ventas.resumen-cuenta-corriente', $clienteSeleccionado) : '#' }}">
                <i class="fas fa-share"></i> Resumen Cta Cte
            </a>
            <a class="btn btn-app bg-primary disabled">
                <i class="fas fa-share"></i> Enviar Resumen
            </a>
            <a class="btn btn-app bg-primary" 
            href="{{ $clienteSeleccionado ? route('ventas.ficha-del-cliente-recibo-venta.create', $clienteSeleccionado) : '#' }}">
                <i class="fas fa-plus"></i> Nuevo Recibo
            </a>
            <a class="btn btn-app bg-primary disabled">
                <i class="fas fa-print"></i> Imprimir
            </a>
        </div>

    </x-layout2>
</div>
