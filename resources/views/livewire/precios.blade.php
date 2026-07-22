<div>
    <x-layout2>

        <x-slot name="title">TRATAMIENTO: "{{ $tratamiento->Nombre }}"</x-slot>

        <x-panel-horizontal2>

            <x-slot name="pestañas">

                <li class="nav-item">
                    <a class="nav-link {{ $activeTab === 'custom-tabs-1' ? 'active' : '' }}" wire:click.prevent="setActiveTab('custom-tabs-1')" id="custom-tabs-1-tab" data-toggle="pill" href="#custom-tabs-1" role="tab" aria-controls="custom-tabs-1" aria-selected="true">General</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $activeTab === 'custom-tabs-2' ? 'active' : '' }}" wire:click.prevent="setActiveTab('custom-tabs-2')" id="custom-tabs-2-tab" data-toggle="pill" href="#custom-tabs-2" role="tab" aria-controls="custom-tabs-2" aria-selected="true">Precios</a>
                </li>
                
            </x-slot>

            <x-slot name="ventanas">

                <div class="tab-pane fade show {{ $activeTab === 'custom-tabs-1' ? 'active' : '' }}" id="custom-tabs-1" role="tabpanel" aria-labelledby="custom-tabs-1-tab" style="height:30rem">
                    
                    <form action="{{ route('ventas.precios.update.tratamiento', $tratamiento)}}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">

                            <div class="col-2"></div>

                            <div class="col-4 mb-3">
                                <div class="form-group mb-0">
                                    <label for="Nombre" class="font-weight-normal">NOMBRE</label>
                                    <input type="text" id="Nombre" name="Nombre" class="form-control form-control-sm" value="{{old('Nombre', $tratamiento->Nombre)}}">
                                </div>
                            </div>

                            <div class="col-4 mb-3">
                                <div class="form-group mb-0">
                                    <label for="Descripcion" class="font-weight-normal">DESCRIPCION</label>
                                    <input type="text" id="Descripcion" name="Descripcion" class="form-control form-control-sm" value="{{old('Descripcion', $tratamiento->Descripcion)}}">
                                </div>
                            </div>

                            <div class="col-2 mb-3"></div>

                            <div class="col-2 mb-3"></div>

                            <div class="col-4 mb-3">
                                <div class="custom-control custom-checkbox">
                                    <input type="hidden" name="Predeterminado" value="0">
                                    <input class="custom-control-input" type="checkbox" id="Predeterminado" name="Predeterminado" value="1" {{ $tratamiento->Predeterminado == 1 ? 'checked' : '' }}>
                                    <label for="Predeterminado" class="custom-control-label">PREDETERMINADO</label>
                                </div>
                            </div>

                            <div class="col-2 mb-3"></div>

                            <div class="justify-content-end mt-5">
                                <button type="submit" class="btn btn-sidebar btn-sm bg-orange">
                                <span class="text-white">Guardar</span>
                                <i class="fas fa-floppy-disk fa-fw text-white ml-2"></i>
                                </button>

                                <button type="button" class="btn btn-sidebar btn-sm bg-orange" data-dismiss="modal">
                                <span class="text-white">Cancelar</span>
                                <i class="fas fa-xmark fa-fw text-white ml-2"></i>
                                </button>
                            </div>

                        </div>

                    </form>

                </div>

                <div class="tab-pane fade show {{ $activeTab === 'custom-tabs-2' ? 'active' : '' }}" id="custom-tabs-2" role="tabpanel" aria-labelledby="custom-tabs-2-tab"  style="height:30rem">

                        <div class="d-flex" style="height: 100%;">

                            <div class="d-flex flex-column align-items-start mt-5 ml-5" style="width: 180px;">

                                <div class="form-group mb-3">
                                    <a class="btn btn-app bg-primary {{ $this->haySeleccionados == true ? 'disabled' : '' }}" data-toggle="modal" data-target="#modal-create">
                                        <i class="fas fa-plus"></i> Nuevo
                                    </a>
                                </div>

                                <div class="form-group mb-3">
                                    <a 
                                        data-toggle="modal" data-target="#modal-edit"
                                        class="btn btn-app bg-primary {{ $this->haySeleccionados == true ? 'disabled' : '' }}"
                                    >
                                        <i class="fas fa-pen"></i> Modificar
                                    </a>
                                </div>

                                <div class="form-group mb-3">
                                    <button
                                        type="button"
                                        class="btn btn-app bg-primary {{ $this->haySeleccionados == true ? 'disabled' : '' }}"
                                        wire:click="deleteItem({{ $selectedItem }})"
                                        wire:loading.attr="disabled"
                                        onclick="return confirm('¿Estás seguro que deseas eliminar este tratamiento?')"
                                    >
                                        <i class="fas fa-trash-can"></i> Eliminar
                                    </button>
                                </div>

                                <div class="form-group mb-3">
                                    <a class="btn btn-app bg-primary" href="{{ route('ventas.precios.index') }}">
                                        <i class="fas fa-x"></i> Cerrar
                                    </a>
                                </div>

                            </div>

                            <!-- .modal -->
                            <form action="{{ route('ventas.precios.store', $selectedCodigo)}}" method="POST">
                                @csrf
                                    <div class="modal fade" id="modal-create" wire:ignore.self>
                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">
                                                NUEVO CODIGO DE COMPLEJIDAD
                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">

                                                <div class="row">

                                                    <div class="col-1"></div>

                                                    <input type="hidden" name="IdTratamiento" value="{{ $tratamiento->id }}">

                                                    <div class="col-2">
                                                        <div class="form-group mb-0">
                                                            <label for="CC" class="font-weight-normal">CC</label>
                                                            <input type="number" id="CC" name="CC" value="{{ old('CC') }}" class="form-control form-control-sm">
                                                        </div>
                                                    </div>

                                                    <div class="col-2">
                                                        <div class="form-group mb-0">
                                                            <label for="Precio" class="font-weight-normal">PRECIO</label>
                                                            <input type="number"
                                                                id="Precio"
                                                                name="Precio"
                                                                wire:model.live="createPrecio"
                                                                class="form-control form-control-sm">
                                                        </div>
                                                    </div>

                                                    <div class="col-2">
                                                        <div class="form-group mb-0">
                                                            <label for="Divisa" class="font-weight-normal">DIVISA</label>
                                                            <select name="Divisa" id="Divisa" class="form-control form-control-sm">
                                                                <option value="ARS" {{ old('Divisa') == 'ARS' ? 'selected' : '' }}>ARS</option>
                                                                <option value="USD" {{ old('Divisa') == 'USD' ? 'selected' : '' }}>USD</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-2">
                                                        <div class="form-group mb-0">
                                                            <label for="PorcentajeCoeficiente" class="font-weight-normal">% COEFICIENTE</label>
                                                            <input type="number"
                                                                id="PorcentajeCoeficiente"
                                                                name="PorcentajeCoeficiente"
                                                                wire:model.live="createPorcentaje"
                                                                class="form-control form-control-sm">
                                                        </div>
                                                    </div>

                                                    <div class="col-2">
                                                        <div class="form-group mb-0">
                                                            <label for="Coeficiente" class="font-weight-normal">COEFICIENTE</label>
                                                            <input type="number"
                                                                id="Coeficiente"
                                                                name="Coeficiente"
                                                                wire:model="createCoeficiente"
                                                                class="form-control form-control-sm" readonly>
                                                        </div>
                                                    </div>

                                                    <div class="col-1"></div>

                                                </div>

                                                <div class="row mt-3">

                                                    <div class="col-1"></div>

                                                    <div class="col-10">
                                                        <div class="form-group mb-0">
                                                            <label for="Descripcion" class="font-weight-normal">DESCRIPCION</label>
                                                            <input type="text" id="Descripcion" name="Descripcion" value="{{ old('Descripcion') }}" class="form-control form-control-sm">
                                                        </div>
                                                    </div>

                                                    <div class="col-1"></div>

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
                            <form action="{{ route('ventas.precios.update', $selectedCodigo)}}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal fade" id="modal-edit" wire:ignore.self>
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">
                                                MODIFICANDO CODIGO DE COMPLEJIDAD: "{{ old('CC', $selectedCodigo->CC) }}"
                                            </h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">

                                            <div class="row">

                                                <div class="col-1"></div>

                                                <input type="hidden" name="IdCodigoComplejidad" value="{{ old('IdCodigoComplejidad', $selectedCodigo->id) }}">

                                                <input type="hidden" name="IdTratamiento" value="{{ $tratamiento->id }}">

                                                <div class="col-2">
                                                    <div class="form-group mb-0">
                                                        <label for="CC" class="font-weight-normal">CC</label>
                                                        <input type="number" id="CC" name="CC" value="{{ old('CC', $selectedCodigo->CC) }}" class="form-control form-control-sm">
                                                    </div>
                                                </div>

                                                <div class="col-2">
                                                    <div class="form-group mb-0">
                                                        <label for="Precio" class="font-weight-normal">PRECIO</label>
                                                        <input type="text" 
                                                                id="Precio" 
                                                                name="Precio"
                                                                wire:model.live="editPrecio"
                                                                class="form-control form-control-sm">
                                                    </div>
                                                </div>

                                                <div class="col-2">
                                                    <div class="form-group mb-0">
                                                        <label for="Divisa" class="font-weight-normal">DIVISA</label>
                                                        <select name="Divisa" id="Divisa" class="form-control form-control-sm">
                                                            <option value="ARS" {{ old('Divisa', $selectedCodigo->Divisa) == 'ARS' ? 'selected' : '' }}>ARS</option>
                                                            <option value="USD" {{ old('Divisa', $selectedCodigo->Divisa) == 'USD' ? 'selected' : '' }}>USD</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-2">
                                                    <div class="form-group mb-0">
                                                        <label for="PorcentajeCoeficiente" class="font-weight-normal">% COEFICIENTE</label>
                                                        <input type="number" 
                                                            id="PorcentajeCoeficiente" 
                                                            name="PorcentajeCoeficiente"
                                                            wire:model.live="editPorcentaje"
                                                            class="form-control form-control-sm">
                                                    </div>
                                                </div>

                                                <div class="col-2">
                                                    <div class="form-group mb-0">
                                                        <label for="Coeficiente" class="font-weight-normal">COEFICIENTE</label>
                                                        <input type="number" 
                                                            id="Coeficiente" 
                                                            name="Coeficiente"
                                                            wire:model="editCoeficiente"
                                                            class="form-control form-control-sm" readonly>
                                                    </div>
                                                </div>

                                                <div class="col-1"></div>

                                            </div>

                                            <div class="row mt-3">

                                                <div class="col-1"></div>

                                                <div class="col-10">
                                                    <div class="form-group mb-0">
                                                        <label for="Descripcion" class="font-weight-normal">DESCRIPCION</label>
                                                        <input type="text" id="Descripcion" name="Descripcion" value="{{ old('Descripcion', $selectedCodigo->Descripcion) }}" class="form-control form-control-sm">
                                                    </div>
                                                </div>

                                                <div class="col-1"></div>

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

                            <div class="flex-grow-1">

                                <div class="mb-2">
                                    <div class="icheck-primary d-inline">
                                        <input type="checkbox" id="checkAll" wire:click="seleccionarTodo" checked onclick="return false;">
                                        <label for="checkAll" title="Seleccionar todos"></label>
                                    </div>

                                    <div class="icheck-primary d-inline">
                                        <input type="checkbox" id="uncheckAll" wire:click="deseleccionarTodo" onclick="return false;">
                                        <label for="uncheckAll" title="Deseleccionar todos"></label>
                                    </div>
                                </div>

                            <form action="{{ route('ventas.precios.update.precio', $selectedCodigo)}}" method="POST">
                                @csrf
                                @method('PUT')

                                <x-simple-table2>

                                    <x-slot name="thead">

                                        <tr>
                                            <th></th>
                                            <th>CC</th>
                                            <th>DESCRIPCION</th>
                                            <th>PRECIO</th>
                                            <th>DIVISA</th>

                                            @if($this->haySeleccionados)
                                                <th>PRECIO NUEVO</th>
                                                <th>DIFERENCIA</th>
                                                <th>% COEFICIENTE</th>
                                                <th>COEFICIENTE</th>
                                                <th>COEF. NUEVO</th>
                                            @else
                                                <th>% COEFICIENTE</th>
                                                <th>COEFICIENTE</th>
                                            @endif
                                        </tr>

                                    </x-slot>

                                    <x-slot name="tbody">
                                        @foreach ($codigos_complejidad as $codigo_complejidad)
                                            @php $id = $codigo_complejidad->id; @endphp

                                            <tr 
                                                style="cursor: pointer;"
                                                wire:click="selectItem({{ $codigo_complejidad->id }})"
                                                class="{{ $selectedItem == $codigo_complejidad->id ? 'table-primary' : '' }}"
                                            >
                                                <td>
                                                    <input 
                                                        type="checkbox"
                                                        wire:click.stop
                                                        wire:model.live="seleccionados.{{ $id }}"
                                                    >
                                                </td>
                                                <td>{{ $codigo_complejidad->CC }}</td>
                                                <td style="min-width: 300px; max-width: 300px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                                    {{ $codigo_complejidad->Descripcion }}
                                                </td>
                                                <td>{{ number_format($codigo_complejidad->Precio, 2, ',', '.') }}</td>
                                                <td>{{ $codigo_complejidad->Divisa }}</td>

                                                @if($this->haySeleccionados)
                                                    <td><strong>{{ number_format($precio_nuevo[$id] ?? 0, 2, ',', '.') }}</strong></td>
                                                    <td><strong>{{ number_format($diferencia[$id] ?? 0, 2, ',', '.') }}</strong></td>
                                                    <td>{{ number_format($codigo_complejidad->PorcentajeCoeficiente, 2, ',', '.') }}</td>
                                                    <td>{{ number_format($codigo_complejidad->Coeficiente, 2, ',', '.') }}</td>
                                                    <td><strong>{{ number_format($coef_nuevo[$id] ?? 0, 2, ',', '.') }}</strong></td>
                                                @else
                                                    <td>{{ number_format($codigo_complejidad->PorcentajeCoeficiente, 2, ',', '.') }}</td>
                                                    <td>{{ number_format($codigo_complejidad->Coeficiente, 2, ',', '.') }}</td>
                                                @endif
                                                
                                            </tr>

                                            <input type="hidden" name="IdTratamiento" value="{{ $tratamiento->id }}">

                                            @if (!empty($seleccionados[$id]) && $seleccionados[$id])
                                                <input type="hidden" name="items[{{ $id }}][IdCodigoComplejidad]" value="{{ $id }}">
                                                <input type="hidden" name="items[{{ $id }}][Precio]" value="{{ $precio_nuevo[$id] ?? 0 }}">
                                                <input type="hidden" name="items[{{ $id }}][Coeficiente]" value="{{ $coef_nuevo[$id] ?? 0 }}">
                                            @endif
                                        @endforeach

                                    </x-slot>

                                </x-simple-table2>

                                <div class="row align-items-center">

                                    <div class="col-4 mb-3">
                                        <div class="d-flex align-items-center">
                                            <label for="Multiplicador" class="mb-0 mr-2 font-weight-normal" style="white-space: nowrap;">Coeficiente act. precios:</label>
                                            <input type="text" id="Multiplicador" wire:model.live="Multiplicador" class="form-control form-control-sm" style="width: 80px;" >

                                        </div>
                                    </div>

                                    <div class="col-4 mb-3">
                                        <div class="d-flex align-items-center">
                                            <label for="Redondeo" class="mb-0 mr-2 font-weight-normal" style="white-space: nowrap;">Redondeo a múltiplo de:</label>
                                            <input type="text" id="Redondeo" wire:model.live="Redondeo" class="form-control form-control-sm" style="width: 80px;">
                                        </div>
                                    </div>

                                    <div class="col-4 mb-3 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-sidebar btn-sm bg-orange mr-2">
                                            <span class="text-white">Guardar</span>
                                            <i class="fas fa-floppy-disk fa-fw text-white ml-1"></i>
                                        </button>

                                        <button type="button" wire:click="deseleccionarTodo" class="btn btn-sidebar btn-sm bg-orange">
                                            <span class="text-white">Cancelar</span>
                                            <i class="fas fa-xmark fa-fw text-white ml-1"></i>
                                        </button>
                                    </div>

                                </div>

                            </form>

                        </div>

                    </div>

                </div>


            </x-slot>

        </x-panel-horizontal2>

    </x-layout2>

    @if ($errors->any() && session('modal') == 'create')
        <script>$('#modal-create').modal('show');</script>
    @endif

    @if ($errors->any() && session('modal') == 'edit')
        <script>$('#modal-edit').modal('show');</script>
    @endif
    
    @push('scripts')
        <script>
            document.addEventListener('livewire:navigated', () => {
                const all = document.getElementById('checkAll');
                const none = document.getElementById('uncheckAll');
                if (all) all.checked = false;
                if (none) none.checked = false;
            });

            // También cuando se hace click (por si Livewire no recarga)
            document.addEventListener('livewire:load', () => {
                const resetCheckboxes = () => {
                    const all = document.getElementById('checkAll');
                    const none = document.getElementById('uncheckAll');
                    if (all) all.checked = false;
                    if (none) none.checked = false;
                };
                window.Livewire.hook('morph.updated', resetCheckboxes);
            });
        </script>
    @endpush
    
</div>

