<x-layout>

    <x-slot name="title">Produccion</x-slot>
    <x-slot name="breadcrumbs">
        <li class="nav-home">
            <a href="#"><i class="fas fa-money-bill-wave"></i></a>
            </li>
            <li class="separator"><i class="icon-arrow-right"></i></li>
            <li class="nav-item"><a href="#">Actualizaciones</a></li>
            <li class="separator"><i class="icon-arrow-right"></i></li>
            <li class="nav-item"><a href="#">Tratamientos</a></li>
            <li class="separator"><i class="icon-arrow-right"></i></li>
            <li class="nav-item"><a href="#">Añadir tratamientos</a></li>
    </x-slot>

    <x-panel-horizontal>
        <x-slot name="title">Tratamiento: "{{$tratamiento->Nombre}}"</x-slot>
        <x-slot name="panel1">General</x-slot>
        <x-slot name="body1">

            <x-form>
                <x-slot name="card_title">Editar tratamiento</x-slot>
                <x-slot name="action">{{ route('tratamientos.update', $tratamiento) }}</x-slot>
                <x-slot name="method">@method('PUT')</x-slot>

                <x-slot name="inputs">

                    <div class="col-md-6 mb-3">
                        <x-form-input-default>
                            <x-slot name="label">Nombre</x-slot>
                            <x-slot name="name">Nombre</x-slot>
                            <x-slot name="placeholder"></x-slot>
                            <x-slot name="value">{{old('Nombre', $tratamiento->Nombre)}}</x-slot>
                            <x-slot name="message">
                                @if ($errors->has('Nombre'))
                                    {{ $errors->first('Nombre') }}
                                @elseif (old('Nombre'))
                                    Todo correcto
                                @endif
                            </x-slot>
                        <x-slot name="error">
                            @if ($errors->has('Nombre'))
                                is-invalid
                            @elseif (old('Nombre') && ! $errors->has('Nombre'))
                                is-valid
                            @endif
                        </x-slot>
                        </x-form-input-default>

                        <input type="hidden" name="Predeterminado" value="0">
                        <x-form-input-checkbox>
                            <x-slot name="label">Predeterminado</x-slot>
                            <x-slot name="name">Predeterminado</x-slot>
                            <x-slot name="value">1</x-slot>
                            <x-slot name="color">black</x-slot>
                            <x-slot name="checked">
                                {{ old('Predeterminado', $tratamiento->Predeterminado) == 1 ? 'checked' : '' }}
                            </x-slot>
                        </x-form-input-checkbox>
                    </div>

                    <div class="col-md-6 mb-3">
                        <x-form-input-default>
                            <x-slot name="label">Descripcion</x-slot>
                            <x-slot name="name">Descripcion</x-slot>
                            <x-slot name="placeholder"></x-slot>
                            <x-slot name="value">{{old('Descripcion', $tratamiento->Descripcion)}}</x-slot>
                            <x-slot name="message">
                                @if ($errors->has('Descripcion'))
                                    {{ $errors->first('Descripcion') }}
                                @elseif (old('Descripcion'))
                                    Todo correcto
                                @endif
                            </x-slot>
                        <x-slot name="error">
                            @if ($errors->has('Descripcion'))
                                is-invalid
                            @elseif (old('Descripcion') && ! $errors->has('Descripcion'))
                                is-valid
                            @endif
                        </x-slot>
                        </x-form-input-default>
                        
                        <input type="hidden" name="Archivado" value="0">
                        <x-form-input-checkbox>
                            <x-slot name="label">Archivado</x-slot>
                            <x-slot name="name">Archivado</x-slot>
                            <x-slot name="value">1</x-slot>
                            <x-slot name="color">black</x-slot>
                            <x-slot name="checked">
                                {{ old('Archivado', $tratamiento->Archivado) == 1 ? 'checked' : '' }}
                            </x-slot>
                        </x-form-input-checkbox>
                    </div>

                </x-slot>
                <x-slot name="buttons">
                    <x-form-button>
                        <x-slot name="text">Guardar</x-slot>
                        <x-slot name="color">success</x-slot>
                    </x-form-button>
                    <x-button>
                        <x-slot name="text">Cancelar</x-slot>
                        <x-slot name="color">danger</x-slot>
                        <x-slot name="href">{{ route('tratamientos.index') }}</x-slot>
                    </x-button>
                </x-slot>
            </x-form>

        </x-slot>
        <x-slot name="panel2">Precios</x-slot>
        <x-slot name="body2">

            <x-data-table>

                <x-slot name="table_title">Códigos de Complejidad</x-slot>
                <x-slot name="export_route">{{ route('clients.export') }}</x-slot>
                <x-slot name="create_route">{{ route('precios.create', $tratamiento) }}</x-slot>
                <x-slot name="add_text">Añadir Código de Complejidad</x-slot>
                <x-slot name="head_tr">
                    <tr>
                        <th></th>
                        <th>CC</th>
                        <th>Descripción</th>
                        <th>Precio</th>
                        <th>Divisa</th>
                        <th>% Coeficiente</th>
                        <th>Coeficiente</th>
                        <th>Opciones</th>
                    </tr>
                </x-slot>
                <x-slot name="body_tr">
            
                    @forelse ($precios as $precio)
                        <tr>
                            <td>
                                <input type="checkbox" name="" id="" wire:model.live="selectedItemIds" value="{{ $precio->id }}">
                            </td>
                            <td>{{ $precio->CC }}</td>
                            <td>{{ $precio->Descripcion }}</td>
                            <td>{{ $precio->Precio }}</td>
                            <td>{{ $precio->Divisa }}</td>
                            <td>{{ $precio->PorcentajeCoeficiente }}</td>
                            <td>{{ $precio->Coeficiente }}</td>
                            <td class="text-start align-middle">
                                <div class="d-flex justify-content-start align-items-center gap-3 ms-2">
                                    <a
                                        href="{{ route('precios.edit', $precio) }}"
                                        class="btn btn-link btn-primary p-0"
                                        data-bs-toggle="tooltip"
                                        title="Editar precio"
                                    >
                                        <i class="fa fa-edit fa-lg"></i>
                                    </a>
                                    <form
                                        action="{{ route('precios.destroy', ['tratamiento' => $tratamiento, 'precio' => $precio]) }}"
                                        method="POST"
                                        onsubmit="return confirm('¿Estás seguro de que quieres eliminar esta precio?')"
                                        class="m-0 p-0"
                                    >
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            type="submit"
                                            class="btn btn-link btn-danger p-0"
                                            data-bs-toggle="tooltip"
                                            title="Eliminar precio"
                                        >
                                            <i class="fa fa-times fa-lg"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>

                            
                        </tr>
                    @empty
                        <tr><td colspan="11">No se encontraron resultados.</td></tr>
                    @endforelse
                </x-slot>
                <x-slot name="foot_tr">
                    <tr>
                        <th></th>
                        <th>CC</th>
                        <th>Descripción</th>
                        <th>Precio</th>
                        <th>Divisa</th>
                        <th>% Coeficiente</th>
                        <th>Coeficiente</th>
                        <th>Opciones</th>
                    </tr>
                </x-slot>

            </x-data-table>

        </x-slot>
    </x-panel-horizontal>

</x-layout>