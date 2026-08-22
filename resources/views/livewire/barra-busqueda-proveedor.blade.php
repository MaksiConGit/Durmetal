<div>
  <x-layout2-sidebar>
      <x-slot name="title">Proveedores</x-slot>

      <x-slot name="filtros">

          <div class="form-inline mt-5 mr-3 d-flex flex-column align-items-center">

              <div class="form-group mb-3">
                  <a href="{{ route('compras.actualizaciones.proveedores.create') }}" 
                  class="btn btn-app bg-primary">
                      <i class="fas fa-plus"></i> Nuevo
                  </a>
              </div>

              <div class="form-group mb-3">
                  <a href="{{ $selectedId ? route('compras.actualizaciones.proveedores.edit', $selectedId) : '#' }}" 
                  class="btn btn-app bg-primary {{ !$selectedId ? 'disabled' : '' }}">
                      <i class="fas fa-pen"></i> Modificar
                  </a>
              </div>

              <div class="form-group mb-3">
                <button
                    wire:click="eliminarProveedor({{ $selectedId }})"
                    class="btn btn-app bg-primary {{ !$selectedId ? 'disabled' : '' }}"
                    onclick="return confirm('¿Estás seguro de que quieres eliminar este proveedor?')"
                >
                    <i class="fas fa-trash-can"></i> Eliminar
                </button>
              </div>

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
                  <th>CUIT</th>
                  <th>RETENCION IIBB</th>
                  <th>ACTIVO</th>
              </tr>
          </x-slot>
          <x-slot name="tbody">
              @forelse ($proveedores as $proveedor)
                  <tr wire:click="selectClient({{ $proveedor->id }})" 
                      class="{{ $selectedId === $proveedor->id ? 'table-primary' : '' }}" 
                      style="cursor: pointer;">
                      <td>{{ $proveedor->id }}</td>
                      <td>{{ $proveedor->Nombre }}</td>
                      <td>{{ $proveedor->Direccion }}</td>
                      <td>{{ $proveedor->localidad->Nombre ?? 'Ciudad no asignada' }}</td>
                      <td>{{ $proveedor->localidad->provincia->Nombre ?? 'Provincia no asignada' }}</td>
                      <td>{{ $proveedor->Telefono }}</td>
                      <td>{{ $proveedor->condicionIVA->Nombre }}</td>
                      <td>{{ $proveedor->NumeroDocumento }}</td>
                      <td>{{ $proveedor->retencionIIBB->Nombre ?? 'N/A' }}</td>
                      <td class="text-center">
                          <input type="checkbox" {{ $proveedor->Activo == 1 ? 'checked' : '' }} disabled>
                      </td>
                  </tr>
              @empty
                  <tr><td colspan="11">No se encontraron resultados.</td></tr>
              @endforelse
          </x-slot>

      </x-simple-table2>

        @if (session()->has('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

  </x-layout2-sidebar>

</div>