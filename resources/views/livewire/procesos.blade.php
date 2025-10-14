<div>
    <x-layout2-sidebar>
        <x-slot name="title">Procesos</x-slot>

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
                        onclick="return confirm('¿Estás seguro que deseas eliminar este proceso?')"
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
                    <th>TIPO</th>
                    <th>NUMERAR SIEMPRE</th>
                    <th>PREDETERMINADO</th>
                </tr>
            </x-slot>

            <x-slot name="tbody">
                @forelse ($procesos as $proceso)
                    <tr 
                        style="cursor: pointer;"
                        wire:click="selectItem({{ $proceso->id }})"
                        class="{{ $selectedItem == $proceso->id ? 'table-primary' : '' }}"
                    >
                        <td>{{ $proceso->Nombre }}</td>
                        <td>{{ $proceso->Tipo }}</td>
                        <td><input type="checkbox" name="" id="" disabled {{ $proceso->RequiereNumeracionSiempre == 1 ? 'checked' : '' }}></td>
                        <td><input type="checkbox" name="" id="" disabled {{ $proceso->Predeterminado == 1 ? 'checked' : '' }}></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">No hay procesos registradas</td>
                    </tr>
                @endforelse
            </x-slot>
        </x-simple-table2>
    </x-layout2-sidebar>

  <!-- .modal -->
  <form action="{{ route('procesos.store') }}" method="POST">
    @csrf
    <div class="modal fade" id="modal-create">
      <div class="modal-dialog modal-dialog-centered modal-lg">
          <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">
                  NUEVO PROCESO
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
                            <label for="Tipo" class="font-weight-normal">TIPO</label>
                            <select name="Tipo" id="" class="form-control form-control-sm
                                @if ($errors->has('Tipo'))
                                    is-invalid
                                @elseif (old('Tipo') && ! $errors->has('Tipo'))
                                    is-valid
                                @endif">
                                <option value="PCO" {{"PCO" == old('Tipo') ? 'selected' : ''}}>CONVENCIONAL</option>
                                <option value="PNC" {{"PNC" == old('Tipo') ? 'selected' : ''}}>NO CONVENCIONAL</option>
                                <option value="ENS" {{"ENS" == old('Tipo') ? 'selected' : ''}}>ENSAYO</option>
                            </select>
                            @if ($errors->has('Tipo'))
                                <span class="invalid-feedback">{{ $errors->first('Tipo') }}</span>
                            @elseif (old('Tipo') && ! $errors->has('Tipo'))
                                <span class="valid-feedback">Todo correcto</span>
                            @endif
                        </div>
                    </div>

                </div>

                <div class="row mt-3">

                    <input type="hidden" name="RequiereNumeracionSiempre" value="0">

                    <div class="col-6">
                        <div class="form-check">
                            <input id="RequiereNumeracionSiempre" type="checkbox" name="RequiereNumeracionSiempre" value="1" {{ old('RequiereNumeracionSiempre') == 1 ? 'checked' : '' }} class="form-check-input
                                @if ($errors->has('RequiereNumeracionSiempre'))
                                    is-invalid
                                @elseif (old('RequiereNumeracionSiempre') && ! $errors->has('RequiereNumeracionSiempre'))
                                    is-valid
                                @endif">

                            <div>
                                <label for="RequiereNumeracionSiempre" class="form-check-label">REQUIERE NUMERACION SIEMPRE</label>
                            </div>

                            @if ($errors->has('RequiereNumeracionSiempre'))
                                <span class="invalid-feedback">{{ $errors->first('RequiereNumeracionSiempre') }}</span>
                            @elseif (old('RequiereNumeracionSiempre') && ! $errors->has('RequiereNumeracionSiempre'))
                                <span class="valid-feedback">Todo correcto</span>
                            @endif
                        </div>
                    </div>

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
  <form action="{{ route('procesos.update', $selectedProceso) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="modal fade" id="modal-edit">
      <div class="modal-dialog modal-dialog-centered modal-lg">
          <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">
                  EDITAR PROCESO
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
                          <input type="text" id="Nombre" name="Nombre" value="{{ old('Nombre', $selectedProceso->Nombre) }}" class="form-control form-control-sm 
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
                            <label for="Tipo" class="font-weight-normal">TIPO</label>
                            <select name="Tipo" id="" class="form-control form-control-sm
                                @if ($errors->has('Tipo'))
                                    is-invalid
                                @elseif (old('Tipo') && ! $errors->has('Tipo'))
                                    is-valid
                                @endif">
                                <option value="PCO" {{"PCO" == old('Tipo', $selectedProceso->Tipo) ? 'selected' : ''}} {{$selectedProceso->Tipo == "PCO" ? 'selected' : ''}}>CONVENCIONAL</option>
                                <option value="PNC" {{"PNC" == old('Tipo', $selectedProceso->Tipo) ? 'selected' : ''}} {{$selectedProceso->Tipo == "PNC" ? 'selected' : ''}}>NO CONVENCIONAL</option>
                                <option value="ENS" {{"ENS" == old('Tipo', $selectedProceso->Tipo) ? 'selected' : ''}} {{$selectedProceso->Tipo == "ENS" ? 'selected' : ''}}>ENSAYO</option>
                            </select>
                            @if ($errors->has('Tipo'))
                                <span class="invalid-feedback">{{ $errors->first('Tipo') }}</span>
                            @elseif (old('Tipo') && ! $errors->has('Tipo'))
                                <span class="valid-feedback">Todo correcto</span>
                            @endif
                        </div>
                    </div>

                </div>

                <div class="row mt-3">

                    <input type="hidden" name="RequiereNumeracionSiempre" value="0">

                    <div class="col-6">
                        <div class="form-check">
                            <input id="RequiereNumeracionSiempre" type="checkbox" name="RequiereNumeracionSiempre" value="1" {{ old('RequiereNumeracionSiempre', $selectedProceso->RequiereNumeracionSiempre) == 1 ? 'checked' : '' }} class="form-check-input
                                @if ($errors->has('RequiereNumeracionSiempre'))
                                    is-invalid
                                @elseif (old('RequiereNumeracionSiempre') && ! $errors->has('RequiereNumeracionSiempre'))
                                    is-valid
                                @endif">

                            <div>
                                <label for="RequiereNumeracionSiempre" class="form-check-label">REQUIERE NUMERACION SIEMPRE</label>
                            </div>

                            @if ($errors->has('RequiereNumeracionSiempre'))
                                <span class="invalid-feedback">{{ $errors->first('RequiereNumeracionSiempre') }}</span>
                            @elseif (old('RequiereNumeracionSiempre') && ! $errors->has('RequiereNumeracionSiempre'))
                                <span class="valid-feedback">Todo correcto</span>
                            @endif
                        </div>
                    </div>

                    <input type="hidden" name="Predeterminado" value="0">

                    <div class="col-6">
                        <div class="form-check">
                            <input id="Predeterminado" type="checkbox" name="Predeterminado" value="1" {{ old('Predeterminado', $selectedProceso->Predeterminado) == 1 ? 'checked' : '' }} class="form-check-input
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
