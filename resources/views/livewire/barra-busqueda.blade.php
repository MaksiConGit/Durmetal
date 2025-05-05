<div>
    
    <input type="text" wire:model.live="search" placeholder="Buscar..." class="form-control mb-3">

    <x-data-table >
      
        <x-slot name="table_title">Clientes</x-slot>
        <x-slot name="export_route">{{ route('clients.export') }}</x-slot>
        <x-slot name="create_route">{{ route('clients.create') }}</x-slot>
        <x-slot name="add_text">Añadir cliente</x-slot>
        <x-slot name="head_tr">
            <tr>
                <th>Código</th>
                <th>Nombre</th>
                <th>Domicilio</th>
                <th>Localidad</th>
                <th>Provincia</th>
                <th>Teléfono</th>
                <th>Condición IVA</th>
                <th>Tipo de Documento</th>
                <th>N° de Documento</th>
                <th>Activo</th>
                <th>Opciones</th>
            </tr>
        </x-slot>
        <x-slot name="body_tr">
    
            @forelse ($clients as $client)
                <tr>
                    <td>{{ $client->id }}</td>
                    <td>{{ $client->Nombre }}</td>
                    <td>{{ $client->Domicilio }}</td>
                    <td>{{ $client->localidad->Nombre ?? 'Ciudad no asignada' }}</td>
                    <td>{{ $client->localidad->provincia->Nombre ?? 'Provincia no asignada' }}</td>
                    <td>{{ $client->Telefono }}</td>
                    <td>{{ $client->condicionIVA->Nombre }}</td>
                    <td>{{ $client->TipoDocumento }}</td>
                    <td>{{ $client->NroDocumento }}</td>
                    <td>{{ $client->Activo == 1 ? 'Sí' : 'No' }}</td>
                    <td class="text-center align-middle">
                        <div class="d-flex justify-content-center align-items-center gap-3">
                          <a
                            href="{{ route('clients.edit', $client) }}"
                            class="btn btn-link btn-primary p-0"
                            data-bs-toggle="tooltip"
                            title="Editar cliente"
                          >
                            <i class="fa fa-edit fa-lg"></i>
                          </a>
                          <form
                            action="{{ route('clients.destroy', $client) }}"
                            method="POST"
                            onsubmit="return confirm('¿Estás seguro de que quieres eliminar este cliente?')"
                            class="m-0 p-0"
                          >
                            @csrf
                            @method('DELETE')
                            <button
                              type="submit"
                              class="btn btn-link btn-danger p-0"
                              data-bs-toggle="tooltip"
                              title="Eliminar cliente"
                            >
                              <i class="fa fa-times fa-lg"></i>
                            </button>
                          </form>
                        </div>
                      </td>
                      
                </tr>
            @empty
                <tr><td colspan="11">No se encontraron resultados.</td></tr>
            @endforelse
        </x-slot>
        <x-slot name="foot_tr">
            <tr>
                <th>Código</th>
                <th>Nombre</th>
                <th>Domicilio</th>
                <th>Localidad</th>
                <th>Provincia</th>
                <th>Teléfono</th>
                <th>Condición IVA</th>
                <th>Tipo de Documento</th>
                <th>N° de Documento</th>
                <th>Activo</th>
                <th>Opciones</th>
            </tr>
        </x-slot>
    </x-data-table>
 </div>

