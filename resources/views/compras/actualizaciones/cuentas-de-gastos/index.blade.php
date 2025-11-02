{{-- <x-layout>

    <x-slot name="title">Compras</x-slot>
    <x-slot name="breadcrumbs">
        <li class="nav-home">
            <a href="#"><i class="fas fa-money-bill-wave"></i></a>
            </li>
            <li class="separator"><i class="icon-arrow-right"></i></li>
            <li class="nav-item"><a href="#">Actualizaciones</a></li>
            <li class="separator"><i class="icon-arrow-right"></i></li>
            <li class="nav-item"><a href="#">Cuentas de Gastos</a></li>
    </x-slot>

    <x-data-table>
      
        <x-slot name="table_title">Cuentas de Gastos</x-slot>
        <x-slot name="export_route">{{ route('clients.export') }}</x-slot>
        <x-slot name="create_route">{{ route('compras.actualizaciones.cuentas-de-gastos.create') }}</x-slot>
        <x-slot name="add_text">Añadir Cuenta de Gastos</x-slot>
        <x-slot name="head_tr">
            <tr>
                <th>Opciones</th>
                <th>Nombre</th>
                <th>Descripción</th>
            </tr>
        </x-slot>
        <x-slot name="body_tr">
    
            @forelse ($cuentas_de_gastos as $cuenta_de_gastos)
                <tr>
                    <td class="text-center align-middle">
                        <div class="d-flex justify-content-center align-items-center gap-3">
                          <a
                            href="{{ route('compras.actualizaciones.cuentas-de-gastos.edit', $cuenta_de_gastos) }}"
                            class="btn btn-link btn-primary p-0"
                            data-bs-toggle="tooltip"
                            title="Editar cuenta de gastos"
                          >
                            <i class="fa fa-edit fa-lg"></i>
                          </a>
                          <form
                            action="{{ route('compras.actualizaciones.cuentas-de-gastos.destroy', $cuenta_de_gastos) }}"
                            method="POST"
                            onsubmit="return confirm('¿Estás seguro de que quieres eliminar esta cuenta de gastos?')"
                            class="m-0 p-0"
                          >
                            @csrf
                            @method('DELETE')
                            <button
                              type="submit"
                              class="btn btn-link btn-danger p-0"
                              data-bs-toggle="tooltip"
                              title="Eliminar cuenta de gastos"
                            >
                              <i class="fa fa-times fa-lg"></i>
                            </button>
                          </form>
                        </div>
                    </td>
                    <td>{{ $cuenta_de_gastos->Nombre }}</td>
                    <td>{{ $cuenta_de_gastos->Descripcion }}</td>
                </tr>
            @empty
                <tr><td colspan="3">No se encontraron resultados.</td></tr>
            @endforelse
        </x-slot>
        <x-slot name="foot_tr">
            <tr>
                <th>Opciones</th>
                <th>Nombre</th>
                <th>Descripción</th>
            </tr>
        </x-slot>
    </x-data-table>

</x-layout> --}}

<div>
  <x-layout2-sidebar>
      <x-slot name="title">Cuentas de Gastos</x-slot>

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

          <x-slot name="thead">
              <tr>
                  <th>NOMBRE</th>
                  <th>DESCRIPCION</th>
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
