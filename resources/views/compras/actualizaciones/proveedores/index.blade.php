@livewire('barra-busqueda-proveedor')



{{-- <div>
  <x-layout2-sidebar>
      <x-slot name="title">Proveedores</x-slot>

      <x-slot name="filtros">

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
              @forelse ($proveedores as $proveedor)
                  <tr wire:click="selectClient({{ $proveedor->id }})" 
                      class="{{ $selectedId === $proveedor->id ? 'table-primary' : '' }}" 
                      style="cursor: pointer;">
                      <td>{{ $proveedor->id }}</td>
                      <td>{{ $proveedor->Nombre }}</td>
                      <td>{{ $proveedor->Domicilio }}</td>
                      <td>{{ $proveedor->localidad->Nombre ?? 'Ciudad no asignada' }}</td>
                      <td>{{ $proveedor->localidad->provincia->Nombre ?? 'Provincia no asignada' }}</td>
                      <td>{{ $proveedor->Telefono }}</td>
                      <td>{{ $proveedor->condicionIVA->Nombre }}</td>
                      <td>{{ $proveedor->TipoDocumento }}</td>
                      <td>{{ $proveedor->NroDocumento }}</td>
                      <td class="text-center">
                          <input type="checkbox" {{ $proveedor->Activo == 1 ? 'checked' : '' }} disabled>
                      </td>
                  </tr>
              @empty
                  <tr><td colspan="11">No se encontraron resultados.</td></tr>
              @endforelse
          </x-slot>

      </x-simple-table2>

  </x-layout2-sidebar>

</div> --}}