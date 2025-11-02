{{-- <x-layout>

    <x-slot name="title">Compras</x-slot>
    <x-slot name="breadcrumbs">
        <li class="nav-home">
            <a href="#"><i class="fas fa-money-bill-wave"></i></a>
            </li>
            <li class="separator"><i class="icon-arrow-right"></i></li>
            <li class="nav-item"><a href="#">Actualizaciones</a></li>
            <li class="separator"><i class="icon-arrow-right"></i></li>
            <li class="nav-item"><a href="#">Proveedores</a></li>
    </x-slot>

    @livewire('barra-busqueda-proveedor')

</x-layout> --}}


<div>
  <x-layout2-sidebar>
      <x-slot name="title">Proveedores</x-slot>

      <x-slot name="filtros">

          <div class="form-inline mt-5 mr-3 d-flex flex-column align-items-center">

              {{-- <div class="form-group mb-3">
                  <a href="{{ route('clients.create') }}" 
                  class="btn btn-app bg-primary">
                      <i class="fas fa-plus"></i> Nuevo
                  </a>
              </div>

              <div class="form-group mb-3">
                  <a href="{{ $selectedId ? route('clients.edit', $selectedId) : '#' }}" 
                  class="btn btn-app bg-primary {{ !$selectedId ? 'disabled' : '' }}">
                      <i class="fas fa-pen"></i> Modificar
                  </a>
              </div>

              <div class="form-group mb-3">
                  <form
                      action="{{ $selectedId ? route('clients.destroy', $selectedId) : '#' }}"
                      method="POST"
                      onsubmit="return confirm('¿Estás seguro de que quieres eliminar este cliente?')"
                      class="m-0 p-0"
                  >
                      @csrf
                      @method('DELETE')
                      <button
                          type="submit"
                          class="btn btn-app bg-primary {{ !$selectedId ? 'disabled' : '' }}"
                          data-bs-toggle="tooltip"
                          title="Eliminar programación"
                      >
                      <i class="fas fa-trash-can"></i> Eliminar
                      </button>
                  </form>
              </div> --}}

          </div>

      </x-slot>

      <x-simple-table2>

          <x-slot name="filtros">

            <div class="row">

                <div class="col-4">
                    <div class="form-group mb-0">
                        <label for="filtro1" class="font-weight-normal">CODIGO | NOMBRE | N° DOCUMENTO</label>
                        <input type="text" id="filtro1" name="filtro1" wire:model.live="search" class="form-control form-control-sm filtro-input" placeholder="Buscar...">
                    </div>
                </div>

            </div>

          </x-slot>

          <x-slot name="thead">
              <tr>
                  <th>CODIGO</th>
                  <th>NOMBRE</th>
                  <th>DOMICILIO</th>
                  <th>LOCALIDAD</th>
                  <th>PROVINCIA</th>
                  <th>TELEFONO</th>
                  <th>CONDICION IVA</th>
                  <th>RETENCION IIBB</th>
                  <th>ACTIVO</th>
              </tr>
          </x-slot>
          <x-slot name="tbody">
              {{-- @forelse ($clients as $client)
                  <tr wire:click="selectClient({{ $client->id }})" 
                      class="{{ $selectedId === $client->id ? 'table-primary' : '' }}" 
                      style="cursor: pointer;">
                      <td>{{ $client->id }}</td>
                      <td>{{ $client->Nombre }}</td>
                      <td>{{ $client->Domicilio }}</td>
                      <td>{{ $client->localidad->Nombre ?? 'Ciudad no asignada' }}</td>
                      <td>{{ $client->localidad->provincia->Nombre ?? 'Provincia no asignada' }}</td>
                      <td>{{ $client->Telefono }}</td>
                      <td>{{ $client->condicionIVA->Nombre }}</td>
                      <td>{{ $client->TipoDocumento }}</td>
                      <td>{{ $client->NroDocumento }}</td>
                      <td class="text-center">
                          <input type="checkbox" {{ $client->Activo == 1 ? 'checked' : '' }} disabled>
                      </td>
                  </tr>
              @empty
                  <tr><td colspan="11">No se encontraron resultados.</td></tr>
              @endforelse --}}
          </x-slot>

      </x-simple-table2>

  </x-layout2-sidebar>

</div>