<x-layout2>
    <x-slot name="title">Listado de saldos de clientes</x-slot>
    
    <x-simple-table2>
        <x-slot name="filtros">
            <div class="row">
                <div class="col-2">
                    <div class="form-group mb-0">
                        <label for="filtro1" class="font-weight-normal">LISTA DESDE</label>
                        <input type="text" id="filtro1" name="filtro1" wire:model.live="cliente_id" class="form-control form-control-sm" placeholder="Buscar...">
                    </div>
                </div>
                <div class="col-2">
                    <div class="form-group mb-0">
                        <label for="filtro1" class="font-weight-normal">LISTA HASTA</label>
                        <input type="text" id="filtro1" name="filtro1" wire:model.live="cliente_id" class="form-control form-control-sm" placeholder="Buscar...">
                    </div>
                </div>
                <div class="col-2">
                    <div class="form-group mb-0">
                        <label for="filtro1" class="font-weight-normal">HASTA FECHA</label>
                        <input type="date" id="filtro1" name="filtro1" wire:model.live="cliente_id" class="form-control form-control-sm" placeholder="Buscar...">
                    </div>
                </div>
                <div class="col-2 mt-4">
                    <div class="form-group mb-0 form-check">
                        <input type="checkbox" id="filtro4" name="filtro4" wire:model.live="incluir_saldos" class="form-check-input">
                        <label for="filtro4" class="form-check-label font-weight-normal">INCLUIR SALDOS EN 0</label>
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
                <tr>
                    <td><input type="checkbox" name="" id=""></td>
                    <td>{{ $cliente->id }}</td>
                    <td>{{ $cliente->Nombre }}</td>
                    <td>{{ $cliente->NroDocumento }}</td>
                    <td>{{ $cliente->factura_atrasada_emision }}</td>
                    <td>{{ $cliente->factura_atrasada_vencimiento }}</td>
                    <td>{{ number_format($cliente->saldo, 2, '.', '') }}</td>
                </tr>
            @empty
                <tr><td colspan="7">No se encontraron resultados.</td></tr>
            @endforelse

        </x-slot>
    </x-simple-table2>

    <div class="d-flex justify-content-end">
        <a class="btn btn-app bg-primary">
            <i class="fas fa-share"></i> Resumen Cta Cte
        </a>

        <a class="btn btn-app bg-primary">
            <i class="fas fa-share"></i> Enviar Resumen
        </a>

        <a class="btn btn-app bg-primary">
            <i class="fas fa-plus"></i> Nuevo Recibo
        </a>

        <a class="btn btn-app bg-primary">
            <i class="fas fa-print"></i> Imprimir
        </a>
    </div>

</x-layout2>