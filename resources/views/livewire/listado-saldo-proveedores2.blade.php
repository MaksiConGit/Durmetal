<div>

    <x-layout2>
        <x-slot name="title">Listado de saldos de proveedores</x-slot>
        
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
                            <input id="saldo0" type="checkbox" class="form-check-input" wire:model.live="incluir_saldos">
                            <label for="saldo0" class="form-check-label">INCLUIR SALDOS EN 0</label>
                        </div>
                    </div>
                </div>

            </div>
            </x-slot>
            <x-slot name="thead">
                <tr>
                    <th>CODIGO</th>
                    <th>NOMBRE</th>
                    <th>CUIT</th>
                    <th>CUENTA GASTOS</th>
                    <th>FECHA FACTURA PENDIENTE</th>
                    <th>FECHA VENC.</th>
                    <th>SALDO</th>
                </tr>
            </x-slot>
            <x-slot name="tbody">

                @forelse ($proveedores as $proveedor)
                    <tr wire:click="seleccionarCliente({{ $proveedor->id }})" 
                        class="{{ $clienteSeleccionado == $proveedor->id ? 'table-primary' : '' }}" style="cursor: pointer;">
                        <td>{{ $proveedor->id }}</td>
                        <td>{{ $proveedor->Nombre }}</td>
                        <td>{{ $proveedor->NumeroDocumento }}</td>
                        <td>{{ $proveedor->cuentaGastos->Nombre }}</td>
                        <td>{{ $proveedor->factura_atrasada_emision ? \Carbon\Carbon::parse($proveedor->factura_atrasada_emision)->format('j/n/Y') : '' }}</td>
                        <td class="text-red">{{ $proveedor->factura_atrasada_vencimiento ? \Carbon\Carbon::parse($proveedor->factura_atrasada_vencimiento)->format('j/n/Y') : '' }}</td>
                        <td>{{ number_format($proveedor->saldo, 2, '.', '') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="7">No se encontraron resultados.</td></tr>
                @endforelse

            </x-slot>
        </x-simple-table2>

        <div class="d-flex justify-content-end mr-3">
            <a class="btn btn-app bg-primary" 
            href="{{ route('compras.resumen-cuenta-corriente.index', ['proveedor_id' => $proveedor->id]) }}">
                <i class="fas fa-share"></i> Resumen Cta Cte
            </a>
            <a class="btn btn-app bg-primary disabled">
                <i class="fas fa-plus"></i> Nueva OP
            </a>
            <a class="btn btn-app bg-primary disabled">
                <i class="fas fa-print"></i> Imprimir
            </a>
        </div>

    </x-layout2>
</div>