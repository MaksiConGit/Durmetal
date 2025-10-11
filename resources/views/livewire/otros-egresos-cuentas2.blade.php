<div>
  <x-layout2-sidebar>
      <x-slot name="title">CUENTAS OTROS EGRESOS</x-slot>

      <x-slot name="filtros">

          <div class="form-inline mt-5 mr-3 d-flex flex-column align-items-center">

              <div class="form-group mb-3">
                  <a href="{{ route('otros-egresos.actualizaciones.cuentas.create') }}" 
                  class="btn btn-app bg-primary">
                      <i class="fas fa-plus"></i> Nuevo
                  </a>
              </div>

              <div class="form-group mb-3">
                  <a href="{{ $selectedId ? route('otros-egresos.actualizaciones.cuentas.edit', $selectedId) : '#' }}" 
                  class="btn btn-app bg-primary {{ !$selectedId ? 'disabled' : '' }}">
                      <i class="fas fa-pen"></i> Modificar
                  </a>
              </div>

              <div class="form-group mb-3">
                  <form
                      action="{{ $selectedId ? route('otros-egresos.actualizaciones.cuentas.destroy', $selectedId) : '#' }}"
                      method="POST"
                      onsubmit="return confirm('¿Estás seguro de que quieres eliminar esta cuenta?')"
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
              </div>

          </div>

      </x-slot>

      <x-simple-table2>

          {{-- <x-slot name="filtros">

            <div class="row">

                <div class="col-2">
                    <label>FECHA DESDE: </label>
                    <input type="date" class="form-control form-control-sm" wire:model.live="cliente_desde">
                </div>

                <div class="col-2">
                    <label>HASTA FECHA: </label>
                    <input type="date" class="form-control form-control-sm" wire:model.live="cliente_hasta">
                </div>

            </div>

          </x-slot> --}}

          <x-slot name="thead">
              <tr>
                  <th>CUENTA PADRE</th>
                  <th>NOMBRE</th>
                  <th>DESCRIPCION</th>
              </tr>
          </x-slot>
          <x-slot name="tbody">


            @forelse ($cuentas_otros_egresos as $padre)
                <tr wire:click="selectClient({{ $padre->id }})" 
                      class="{{ $selectedId === $padre->id ? 'table-primary' : '' }}" 
                      style="cursor: pointer;">
                    <td></td>
                    <td>{{ $padre->Nombre }}</td>
                    <td>{{ $padre->Descripcion }}</td>
                </tr>

                @foreach ($padre->hijos as $hijo)
                <tr wire:click="selectClient({{ $hijo->id }})" 
                      class="{{ $selectedId === $hijo->id ? 'table-primary' : '' }}" 
                      style="cursor: pointer;">
                        <td>{{ $padre->Nombre }}</td>
                        <td>{{ $hijo->Nombre }}</td>
                        <td>{{ $hijo->Descripcion }}</td>
                    </tr>

                @endforeach

            @empty
                <tr><td colspan="11">No se encontraron resultados.</td></tr>
            @endforelse






          </x-slot>

      </x-simple-table2>

  </x-layout2-sidebar>

</div>