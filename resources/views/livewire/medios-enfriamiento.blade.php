<div>
    <x-layout2-sidebar>
        <x-slot name="title">Medios de Enfriamiento</x-slot>

        <x-slot name="filtros">
            <div class="form-inline mt-5 mr-3 d-flex flex-column align-items-center">

                <div class="form-group mb-3">
                    <a class="btn btn-app bg-primary" data-toggle="modal" data-target="#modal-create">
                        <i class="fas fa-plus"></i> Nuevo
                    </a>
                </div>

                <div class="form-group mb-3">
                    <a 
                        data-toggle="modal" data-target="#modal-edit"
                        class="btn btn-app bg-primary {{ !$selectedItem ? 'disabled' : '' }}"
                    >
                        <i class="fas fa-pen"></i> Modificar
                    </a>
                </div>

                <div class="form-group mb-3">
                    <button
                        type="button"
                        class="btn btn-app bg-primary {{ !$selectedItem ? 'disabled' : '' }}"
                        wire:click="deleteItem({{ $selectedItem }})"
                        wire:loading.attr="disabled"
                        onclick="return confirm('¿Estás seguro que deseas eliminar este medio de enfriamiento?')"
                    >
                        <i class="fas fa-trash-can"></i> Eliminar
                    </button>
                </div>
                                
            </div>

        </x-slot>

        <x-simple-table2>
            <x-slot name="thead">
                <tr>
                    <th>NOMBRE</th>
                    <th>PREDETERMINADO</th>
                </tr>
            </x-slot>

            <x-slot name="tbody">
                @forelse ($medios_enfriamiento as $medio_enfriamiento)
                    <tr 
                        style="cursor: pointer;"
                        wire:click="selectItem({{ $medio_enfriamiento->id }})"
                        class="{{ $selectedItem == $medio_enfriamiento->id ? 'table-primary' : '' }}"
                    >
                        <td>{{ $medio_enfriamiento->Nombre }}</td>
                        <td class="text-center">
                            <input type="checkbox" disabled {{ $medio_enfriamiento->Predeterminado ? 'checked' : '' }}>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">No hay medios de enfriamiento registradas</td>
                    </tr>
                @endforelse
            </x-slot>
        </x-simple-table2>
    </x-layout2-sidebar>

  <!-- .modal -->
  <form action="{{ route('medios-enfriamiento.store') }}" method="POST">
    @csrf
    <div class="modal fade" id="modal-create">
      <div class="modal-dialog modal-dialog-centered modal-lg">
          <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">
                  NUEVO MEDIO ENFRIAMIENTO
                </h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">

                <div class="row">

                  <div class="col-12">
                      <div class="form-group mb-0">
                          <label for="Nombre" class="font-weight-normal">NOMBRE</label>
                          <input type="text" id="Nombre" name="Nombre" value="{{ old('Nombre') }}" class="form-control form-control-sm 
                            @if ($errors->has('Nombre'))
                                is-invalid
                            @elseif (old('Nombre') && ! $errors->has('Nombre'))
                                is-valid
                            @endif">

                            @if ($errors->has('Nombre'))
                                <span class="invalid-feedback">{{ $errors->first('Nombre') }}</span>
                            @elseif (old('Nombre') && ! $errors->has('Nombre'))
                                <span class="valid-feedback">Todo correcto</span>
                            @endif
                      </div>
                  </div>

                </div>

                <div class="row mt-3">

                    <input type="hidden" name="Predeterminado" value="0">

                    <div class="col-6">
                        <div class="form-check">
                            <input id="Predeterminado" type="checkbox" name="Predeterminado" value="1" {{ old('Predeterminado') == 1 ? 'checked' : '' }} class="form-check-input
                                @if ($errors->has('Predeterminado'))
                                    is-invalid
                                @elseif (old('Predeterminado') && ! $errors->has('Predeterminado'))
                                    is-valid
                                @endif">

                            <div>
                                <label for="Predeterminado" class="form-check-label">PREDETERMINADO</label>
                            </div>

                            @if ($errors->has('Predeterminado'))
                                <span class="invalid-feedback">{{ $errors->first('Predeterminado') }}</span>
                            @elseif (old('Predeterminado') && ! $errors->has('Predeterminado'))
                                <span class="valid-feedback">Todo correcto</span>
                            @endif
                        </div>
                    </div>

                </div>

              </div>

              <div class="modal-footer justify-content-end">

                  <button type="submit" class="btn btn-sidebar btn-sm bg-orange">
                      <span class="text-white">Guardar</span>
                      <i class="fas fa-floppy-disk fa-fw text-white ml-2"></i>
                  </button>

                  <button class="btn btn-sidebar btn-sm bg-orange" data-dismiss="modal">
                      <span class="text-white">Cancelar</span>
                      <i class="fas fa-xmark fa-fw text-white ml-2"></i>
                  </button>

              </div>

          </div>
      </div>
    </div>

  </form>
  <!-- /.modal -->

  <!-- .modal -->
  <form action="{{ route('medios-enfriamiento.update', $selectedMedio) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="modal fade" id="modal-edit">
      <div class="modal-dialog modal-dialog-centered modal-lg">
          <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">
                  EDITAR MEDIO DE ENFRIAMIENTO
                </h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">

                <div class="row">

                  <div class="col-12">
                      <div class="form-group mb-0">
                          <label for="Nombre" class="font-weight-normal">NOMBRE</label>
                          <input type="text" id="Nombre" name="Nombre" value="{{ old('Nombre', $selectedMedio->Nombre) }}" class="form-control form-control-sm 
                            @if ($errors->has('Nombre'))
                                is-invalid
                            @elseif (old('Nombre') && ! $errors->has('Nombre'))
                                is-valid
                            @endif">

                            @if ($errors->has('Nombre'))
                                <span class="invalid-feedback">{{ $errors->first('Nombre') }}</span>
                            @elseif (old('Nombre') && ! $errors->has('Nombre'))
                                <span class="valid-feedback">Todo correcto</span>
                            @endif
                      </div>
                  </div>

                </div>

                <div class="row mt-3">

                    <input type="hidden" name="Predeterminado" value="0">

                    <div class="col-6">
                        <div class="form-check">
                            <input id="Predeterminado" type="checkbox" name="Predeterminado" value="1" {{ old('Predeterminado', $selectedMedio->Predeterminado) == 1 ? 'checked' : '' }} class="form-check-input
                                @if ($errors->has('Predeterminado'))
                                    is-invalid
                                @elseif (old('Predeterminado') && ! $errors->has('Predeterminado'))
                                    is-valid
                                @endif">

                            <div>
                                <label for="Predeterminado" class="form-check-label">PREDETERMINADO</label>
                            </div>

                            @if ($errors->has('Predeterminado'))
                                <span class="invalid-feedback">{{ $errors->first('Predeterminado') }}</span>
                            @elseif (old('Predeterminado') && ! $errors->has('Predeterminado'))
                                <span class="valid-feedback">Todo correcto</span>
                            @endif
                        </div>
                    </div>

                </div>

              </div>

              <div class="modal-footer justify-content-end">

                  <button type="submit" class="btn btn-sidebar btn-sm bg-orange">
                      <span class="text-white">Guardar</span>
                      <i class="fas fa-floppy-disk fa-fw text-white ml-2"></i>
                  </button>

                  <button class="btn btn-sidebar btn-sm bg-orange" data-dismiss="modal">
                      <span class="text-white">Cancelar</span>
                      <i class="fas fa-xmark fa-fw text-white ml-2"></i>
                  </button>

              </div>

          </div>
      </div>
    </div>

  </form>
  <!-- /.modal -->
    @if ($errors->any() && session('modal') == 'create')
        <script>$('#modal-create').modal('show');</script>
    @endif

    @if ($errors->any() && session('modal') == 'edit')
        <script>$('#modal-edit').modal('show');</script>
    @endif

</div>
