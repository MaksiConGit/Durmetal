<x-layout>
    <x-slot name="title">Producción</x-slot>
    <x-slot name="breadcrumbs">
        <li class="nav-home">
            <a href="#"><i class="fas fa-cogs"></i></a>
        </li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="#">Ingreso de materiales</a></li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="#">Editar Item de Orden de Trabajo</a></li>
    </x-slot>

    <x-form>
        <x-slot name="card_title">Añadir Item de Orden de Trabajo</x-slot>
        <x-slot name="action">{{ route('item-orden-trabajo.update',  $item_orden_trabajo->id) }}</x-slot>
        <x-slot name="method">@method('PUT')</x-slot>

        <x-slot name="inputs">

            <div class="col-md-4 mb-3">

              <input type="hidden" name="IdOrdenTrabajo" value="{{$item_orden_trabajo->IdOrdenTrabajo}}">

                <x-form-input-default>
                    <x-slot name="label">Item Nro</x-slot>
                    <x-slot name="name">id</x-slot>
                    <x-slot name="placeholder"></x-slot>
                    <x-slot name="value">{{old('id', $item_orden_trabajo->id)}}</x-slot>
                    <x-slot name="message">
                        @error('id')
                            {{$message}}
                        @enderror
                    </x-slot>
                    <x-slot name="error">
                        @if ($errors->has('id'))
                            is-invalid
                        @elseif (old('id') && ! $errors->has('id'))
                            is-valid
                        @endif
                    </x-slot>
                </x-form-input-default>
                            
                <x-form-input-default>
                    <x-slot name="label">Cantidad</x-slot>
                    <x-slot name="name">Cantidad</x-slot>
                    <x-slot name="placeholder"></x-slot>
                    <x-slot name="value">{{old('Cantidad', $item_orden_trabajo->Cantidad)}}</x-slot>
                    <x-slot name="message">
                        @error('Cantidad')
                            {{$message}}
                        @enderror
                    </x-slot>
                    <x-slot name="error">
                      @if ($errors->has('Cantidad'))
                          is-invalid
                      @elseif(old('Cantidad') !== null && ! $errors->has('Cantidad'))
                          is-valid
                      @endif
                    </x-slot>
                </x-form-input-default>

                <x-form-input-select>
                    <x-slot name="label">Dureza</x-slot>
                    <x-slot name="name">IdDureza</x-slot>
                    <x-slot name="option">
                      @foreach ($durezas as $dureza)
                        <option value="{{$dureza->id}}" {{$item_orden_trabajo->dureza->id == $dureza->id ? 'selected' : ''}} >{{$dureza->Nombre}}</option>
                      @endforeach
                    </x-slot>
                    <x-slot name="message">
                        @error('IdDureza')
                            {{$message}}
                        @enderror
                    </x-slot>
                    <x-slot name="error">
                        @if ($errors->has('IdDureza'))
                            is-invalid
                        @elseif (old('IdDureza') && ! $errors->has('IdDureza'))
                            is-valid
                        @endif
                    </x-slot>
                </x-form-input-select>

                <x-form-input-select>
                    <x-slot name="label">Material</x-slot>
                    <x-slot name="name">IdMaterial</x-slot>
                    <x-slot name="option">
                      @foreach ($materiales as $material)
                        <option value="{{$material->id}}" {{$item_orden_trabajo->material->id == $material->id ? 'selected' : ''}} >{{$material->Nombre}}</option>
                      @endforeach
                    </x-slot>
                    <x-slot name="message">
                        @error('IdMaterial')
                            {{$message}}
                        @enderror
                    </x-slot>
                    <x-slot name="error">
                        @if ($errors->has('IdMaterial'))
                            is-invalid
                        @elseif (old('IdMaterial') && ! $errors->has('IdMaterial'))
                            is-valid
                        @endif
                    </x-slot>
                </x-form-input-select>
            </div>

            <div class="col-md-4 mb-3">
                <x-form-input-default>
                    <x-slot name="label">Descripción</x-slot>
                    <x-slot name="name">Descripcion</x-slot>
                    <x-slot name="placeholder"></x-slot>
                    <x-slot name="value">{{old('Descripcion', $item_orden_trabajo->Descripcion)}}</x-slot>
                    <x-slot name="message">
                        @error('Descripcion')
                            {{$message}}
                        @enderror
                    </x-slot>
                    <x-slot name="error">
                        @if ($errors->has('Descripcion'))
                            is-invalid
                        @elseif (old('Descripcion') && ! $errors->has('Descripcion'))
                            is-valid
                        @endif
                    </x-slot>
                </x-form-input-default>

                <x-form-input-default>
                    <x-slot name="label">Peso</x-slot>
                    <x-slot name="name">Peso</x-slot>
                    <x-slot name="placeholder"></x-slot>
                    <x-slot name="value">{{old('Peso', $item_orden_trabajo->Peso)}}</x-slot>
                    <x-slot name="message">
                        @error('Peso')
                            {{$message}}
                        @enderror
                    </x-slot>
                    <x-slot name="error">
                        @if ($errors->has('Peso'))
                            is-invalid
                        @elseif (old('Peso') && ! $errors->has('Peso'))
                            is-valid
                        @endif
                    </x-slot>
                </x-form-input-default>

                <x-form-input-default>
                    <x-slot name="label">DSMIN</x-slot>
                    <x-slot name="name">DurezaSolicitadaMinima</x-slot>
                    <x-slot name="placeholder"></x-slot>
                    <x-slot name="value">{{old('DurezaSolicitadaMinima', $item_orden_trabajo->DurezaSolicitadaMinima)}}</x-slot>
                    <x-slot name="message">
                        @error('DurezaSolicitadaMinima')
                            {{$message}}
                        @enderror
                    </x-slot>
                    <x-slot name="error">
                        @if ($errors->has('DurezaSolicitadaMinima'))
                            is-invalid
                        @elseif (old('DurezaSolicitadaMinima') && ! $errors->has('DurezaSolicitadaMinima'))
                            is-valid
                        @endif
                    </x-slot>
                </x-form-input-default>

                <x-form-input-select>
                    <x-slot name="label">CC</x-slot>
                    <x-slot name="name"></x-slot>
                    <x-slot name="option">
                    </x-slot>
                    <x-slot name="message">
                        @error('')
                            {{$message}}
                        @enderror
                    </x-slot>
                    <x-slot name="error">
                        @if ($errors->has(''))
                            is-invalid
                        @elseif (old('') && ! $errors->has(''))
                            is-valid
                        @endif
                    </x-slot>
                </x-form-input-select>
            </div>

            <div class="col-md-4 mb-3">
              <x-form-input-default>
                  <x-slot name="label">Nro Plano</x-slot>
                  <x-slot name="name"></x-slot>
                  <x-slot name="placeholder"></x-slot>
                  <x-slot name="value"></x-slot>
                  <x-slot name="message">
                      @error('')
                          {{$message}}
                      @enderror
                  </x-slot>
                  <x-slot name="error">
                      @if ($errors->has(''))
                          is-invalid
                      @elseif (old('') && ! $errors->has(''))
                          is-valid
                      @endif
                  </x-slot>
              </x-form-input-default>

              <x-form-input-select>
                <x-slot name="label">Tratamiento</x-slot>
                <x-slot name="name">IdTratamiento</x-slot>
                <x-slot name="option">
                  @foreach ($tratamientos as $tratamiento)
                    <option value="{{$tratamiento->id}}" {{$item_orden_trabajo->tratamiento->id == $tratamiento->id ? 'selected' : ''}} >{{$tratamiento->Nombre}}</option>
                  @endforeach
                </x-slot>
                <x-slot name="message">
                    @error('IdTratamiento')
                        {{$message}}
                    @enderror
                </x-slot>
                <x-slot name="error">
                    @if ($errors->has('IdTratamiento'))
                        is-invalid
                    @elseif (old('IdTratamiento') && ! $errors->has('IdTratamiento'))
                        is-valid
                    @endif
                </x-slot>
              </x-form-input-select>
                          
              <x-form-input-default>
                  <x-slot name="label">DSMAX</x-slot>
                  <x-slot name="name">DurezaSolicitadaMaxima</x-slot>
                  <x-slot name="placeholder"></x-slot>
                  <x-slot name="value">{{old('DurezaSolicitadaMaxima', $item_orden_trabajo->DurezaSolicitadaMaxima)}}</x-slot>
                  <x-slot name="message">
                      @error('DurezaSolicitadaMaxima')
                          {{$message}}
                      @enderror
                  </x-slot>
                  <x-slot name="error">
                      @if ($errors->has('DurezaSolicitadaMaxima'))
                          is-invalid
                      @elseif (old('DurezaSolicitadaMaxima') && ! $errors->has('DurezaSolicitadaMaxima'))
                          is-valid
                      @endif
                  </x-slot>
              </x-form-input-default>

              <x-form-input-select>
                  <x-slot name="label">Estado</x-slot>
                  <x-slot name="name">Estado</x-slot>
                  <x-slot name="option">
                      <option value="PENDIENTE" {{$item_orden_trabajo->Estado == 'PENDIENTE' ? 'selected' : ''}} >Pendiente</option>
                      <option value="APROBADO" {{$item_orden_trabajo->Estado == 'APROBADO' ? 'selected' : ''}}>Aprobado</option>
                      <option value="NO APTO" {{$item_orden_trabajo->Estado == 'NO APTO' ? 'selected' : ''}} >No Apto</option>
                  </x-slot>
                  <x-slot name="message">
                      @error('Estado')
                          {{$message}}
                      @enderror
                  </x-slot>
                  <x-slot name="error">
                      @if ($errors->has('Estado'))
                          is-invalid
                      @elseif (old('Estado') && ! $errors->has('Estado'))
                          is-valid
                      @endif
                  </x-slot>
              </x-form-input-select>
            </div>
        </x-slot>
        <x-slot name="buttons">
            <x-form-button>
                <x-slot name="text">Añadir</x-slot>
                <x-slot name="color">success</x-slot>
            </x-form-button>
            <x-button>
                <x-slot name="text">Volver</x-slot>
                <x-slot name="color">danger</x-slot>
                <x-slot name="href">{{ route('orden-trabajo.edit', $item_orden_trabajo->IdOrdenTrabajo) }}</x-slot>
            </x-button>
        </x-slot>
    </x-form>
</x-layout>