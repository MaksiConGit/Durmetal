<div>
    <x-layout2-sidebar>
        <x-slot name="title">Factores Premio</x-slot>

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
                        onclick="return confirm('¿Estás seguro que deseas eliminar este material?')"
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
                    <th>VALOR PRED.</th>
                    <th>ACTIVO</th>
                </tr>
            </x-slot>

            <x-slot name="tbody">
                @forelse ($factores_premio as $factor_premio)
                    <tr 
                        style="cursor: pointer;"
                        wire:click="selectItem({{ $factor_premio->id }})"
                        class="{{ $selectedItem == $factor_premio->id ? 'table-primary' : '' }}"
                    >
                        <td>{{ $factor_premio->Nombre }}</td>
                        <td>{{ number_format($factor_premio->ValorPredeterminado, 2, '.', '') }}</td>
                        <td class="text-center">
                            <input type="checkbox" disabled {{ $factor_premio->Activo ? 'checked' : '' }}>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">No hay factores premio registrados</td>
                    </tr>
                @endforelse
            </x-slot>
        </x-simple-table2>
    </x-layout2-sidebar>

  <!-- .modal -->
  <form action="{{ route('factores-premio.store') }}" method="POST">
    @csrf
    <div class="modal fade" id="modal-create">
      <div class="modal-dialog modal-dialog-centered modal-lg">
          <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">
                  NUEVO FACTOR PREMIO
                </h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">

                <div class="row">

                  <div class="col-6">
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

                  <div class="col-6">
                      <div class="form-group mb-0">
                          <label for="ValorPredeterminado" class="font-weight-normal">VALOR PREDETERMINADO</label>
                          <input type="text" id="ValorPredeterminado" name="ValorPredeterminado" value="{{ number_format(old('ValorPredeterminado'), 2, '.', '') }}" class="form-control form-control-sm 
                            @if ($errors->has('ValorPredeterminado'))
                                is-invalid
                            @elseif (old('ValorPredeterminado') && ! $errors->has('ValorPredeterminado'))
                                is-valid
                            @endif">

                            @if ($errors->has('ValorPredeterminado'))
                                <span class="invalid-feedback">{{ $errors->first('ValorPredeterminado') }}</span>
                            @elseif (old('ValorPredeterminado') && ! $errors->has('ValorPredeterminado'))
                                <span class="valid-feedback">Todo correcto</span>
                            @endif
                      </div>
                  </div>

                </div>

                <div class="row mt-3">

                    <input type="hidden" name="Activo" value="0">

                    <div class="col-6">
                        <div class="form-check">
                            <input id="Activo" type="checkbox" name="Activo" value="1" {{ old('Activo') == 1 ? 'checked' : '' }} class="form-check-input
                                @if ($errors->has('Activo'))
                                    is-invalid
                                @elseif (old('Activo') && ! $errors->has('Activo'))
                                    is-valid
                                @endif">

                            <div>
                                <label for="Activo" class="form-check-label">ACTIVO</label>
                            </div>

                            @if ($errors->has('Activo'))
                                <span class="invalid-feedback">{{ $errors->first('Activo') }}</span>
                            @elseif (old('Activo') && ! $errors->has('Activo'))
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
  <form action="{{ route('factores-premio.update', $selectedFactor) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="modal fade" id="modal-edit">
      <div class="modal-dialog modal-dialog-centered modal-lg">
          <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">
                  EDITAR FACTOR PREMIO
                </h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">

                <div class="row">

                  <div class="col-6">
                      <div class="form-group mb-0">
                          <label for="Nombre" class="font-weight-normal">NOMBRE</label>
                          <input type="text" id="Nombre" name="Nombre" value="{{ old('Nombre', $selectedFactor->Nombre) }}" class="form-control form-control-sm 
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

                  <div class="col-6">
                      <div class="form-group mb-0">
                          <label for="ValorPredeterminado" class="font-weight-normal">VALOR PREDETERMINADO</label>
                          <input type="text" id="ValorPredeterminado" name="ValorPredeterminado" value="{{ number_format(old('ValorPredeterminado', $selectedFactor->ValorPredeterminado), 2, '.', '') }}" class="form-control form-control-sm 
                            @if ($errors->has('ValorPredeterminado'))
                                is-invalid
                            @elseif (old('ValorPredeterminado') && ! $errors->has('ValorPredeterminado'))
                                is-valid
                            @endif">

                            @if ($errors->has('ValorPredeterminado'))
                                <span class="invalid-feedback">{{ $errors->first('ValorPredeterminado') }}</span>
                            @elseif (old('ValorPredeterminado') && ! $errors->has('ValorPredeterminado'))
                                <span class="valid-feedback">Todo correcto</span>
                            @endif
                      </div>
                  </div>

                </div>

                <div class="row mt-3">

                    <input type="hidden" name="Activo" value="0">

                    <div class="col-6">
                        <div class="form-check">
                            <input id="Activo" type="checkbox" name="Activo" value="1" {{ old('Activo', $selectedFactor->Activo) == 1 ? 'checked' : '' }} class="form-check-input
                                @if ($errors->has('Activo'))
                                    is-invalid
                                @elseif (old('Activo') && ! $errors->has('Activo'))
                                    is-valid
                                @endif">

                            <div>
                                <label for="Activo" class="form-check-label">ACTIVO</label>
                            </div>

                            @if ($errors->has('Activo'))
                                <span class="invalid-feedback">{{ $errors->first('Activo') }}</span>
                            @elseif (old('Activo') && ! $errors->has('Activo'))
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
