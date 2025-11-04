    <x-simple-table2>
        <x-slot name="filtros">
            <div class="row">
            <div class="col-2">
                <div class="form-group mb-0">
                    <label for="filtro1" class="font-weight-normal">CODIGO</label>
                    <input type="text" id="filtro1" name="filtro1" wire:model.live="codigo" class="form-control form-control-sm">
                </div>
            </div>
            <div class="col-2">
                <div class="form-group mb-0">
                    <label for="filtro1" class="font-weight-normal">NOMBRE</label>
                    <input type="text" id="filtro1" name="filtro1" wire:model.live="nombre" class="form-control form-control-sm">
                </div>
            </div>
            <div class="col-2">
                <div class="form-group mb-0">
                    <label for="filtro1" class="font-weight-normal">N° DOCUMENTO</label>
                    <input type="text" id="filtro1" name="filtro1" wire:model.live="documento" class="form-control form-control-sm">
                </div>
            </div>
            </div>
        </div>
        </x-slot>
        <x-slot name="thead">
            <tr>
                <th>CODIGO</th>
                <th>NOMBRE</th>
                <th>N° DOCUMENTO</th>
                <th>DOMICILIO</th>
                <th>LOCALIDAD</th>
                <th>PROVINCIA</th>
                <th>CONDICION IVA</th>
            </tr>
        </x-slot>
        <x-slot name="tbody">
            @forelse ($proveedores as $proveedor)
                <tr style="cursor: pointer;"
                    onclick="window.location='{{ route('compras.ficha-del-proveedor.show', $proveedor) }}'">
                    <td>{{ $proveedor->id }}</td>
                    <td>{{ $proveedor->Nombre }}</td>
                    <td>{{ $proveedor->NumeroDocumento }}</td>
                    <td>{{ $proveedor->Direccion }}</td>
                    <td>{{ $proveedor->Localidad }}</td>
                    <td>{{ $proveedor->Provincia }}</td>
                    <td>{{ $proveedor->condicionIVA->Nombre ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="9">No se encontraron resultados.</td>
                </tr>
            @endforelse
        </x-slot>
    </x-simple-table2>