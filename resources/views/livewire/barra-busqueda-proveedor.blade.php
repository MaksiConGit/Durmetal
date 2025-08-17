<div>

    <input type="text" wire:model.live="search" placeholder="Buscar..." class="form-control mb-3">

    <x-data-table>
      
        <x-slot name="table_title">Proveedores</x-slot>
        <x-slot name="export_route">{{ route('clients.export') }}</x-slot>
        <x-slot name="create_route">{{ route('compras.actualizaciones.proveedores.create') }}</x-slot>
        <x-slot name="add_text">Añadir proveedor</x-slot>
        <x-slot name="head_tr">
            <tr>
                <th>Opciones</th>
                <th>Código</th>
                <th>Nombre</th>
                <th>Domicilio</th>
                <th>Localidad</th>
                <th>Provincia</th>
                <th>Teléfono</th>
                <th>Condición IVA</th>
                <th>CUIT</th>
                <th>Retención IIBB</th>
                <th>Activo</th>
            </tr>
        </x-slot>
        <x-slot name="body_tr">
    
            @forelse ($proveedores as $proveedor)
                <tr>
                    <td class="text-center align-middle">
                        <div class="d-flex justify-content-center align-items-center gap-3">
                          <a
                            href="{{ route('compras.actualizaciones.proveedores.edit', $proveedor) }}"
                            class="btn btn-link btn-primary p-0"
                            data-bs-toggle="tooltip"
                            title="Editar proveedor"
                          >
                            <i class="fa fa-edit fa-lg"></i>
                          </a>
                          <form
                            action="{{ route('compras.actualizaciones.proveedores.destroy', $proveedor) }}"
                            method="POST"
                            onsubmit="return confirm('¿Estás seguro de que quieres eliminar este proveedor?')"
                            class="m-0 p-0"
                          >
                            @csrf
                            @method('DELETE')
                            <button
                              type="submit"
                              class="btn btn-link btn-danger p-0"
                              data-bs-toggle="tooltip"
                              title="Eliminar proveedor"
                            >
                              <i class="fa fa-times fa-lg"></i>
                            </button>
                          </form>
                        </div>
                    </td>
                    <td>{{ $proveedor->id }}</td>
                    <td>{{ $proveedor->Nombre }}</td>
                    <td>{{ $proveedor->Direccion }}</td>
                    <td>{{ $proveedor->localidad->Nombre ?? 'Ciudad no asignada' }}</td>
                    <td>{{ $proveedor->localidad->provincia->Nombre ?? 'Provincia no asignada' }}</td>
                    <td>{{ $proveedor->Telefono }}</td>
                    <td>{{ $proveedor->condicionIVA->Nombre }}</td>
                    <td>{{ $proveedor->NumeroDocumento }}</td>
                    <td>{{ $proveedor->retencionIIBB->Nombre ?? 'N/A' }}</td>
                    <td><input type="checkbox" disabled {{ $proveedor->Activo == 1 ? 'checked' : '' }}></td>
                </tr>
            @empty
                <tr><td colspan="11">No se encontraron resultados.</td></tr>
            @endforelse
        </x-slot>
        <x-slot name="foot_tr">
            <tr>
                <th>Opciones</th>
                <th>Código</th>
                <th>Nombre</th>
                <th>Domicilio</th>
                <th>Localidad</th>
                <th>Provincia</th>
                <th>Teléfono</th>
                <th>Condición IVA</th>
                <th>CUIT</th>
                <th>Retención IIBB</th>
                <th>Activo</th>
            </tr>
        </x-slot>
    </x-data-table>
</div>
