<x-layout2>
    <x-slot name="title">Programación de la Producción</x-slot>

    <form action="{{ route('programacion.update', $programacion) }}" method="POST">
        @csrf
        @method('PUT')
        
        <x-simple-table2>
            <x-slot name="thead">
                <tr>
                    <th>DESCRIPCION</th>
                    <th>PROGRAMACION</th>
                    <th>N° PROG.</th>
                    <th>CANTIDAD</th>
                    <th>RP</th>
                    <th>APTO</th>
                    <th>FECHA CARGA</th>
                    <th>FECHA DESCARGA</th>
                    <th>EJEC. POR</th>
                    <th>TEMPERATURA</th>
                    <th>MEDIO ENF.</th>
                    <th>DMIN</th>
                    <th>DMAX</th>
                </tr>
            </x-slot>
            <x-slot name="tbody">

                <tr>
                    <input type="hidden" name="ItemOrdenTrabajoId" value="{{ $item->id }}">
                    <td>{{ $item->Descripcion }}</td>
                    <td>
                        <span class="bg-danger px-1">H{{ $programacion->NumeroHorno }}</span> 
                        <span class="bg-primary px-1">{{ $programacion->tipoProgramacion->Nombre }}</span>
                    </td>
                    <td>{{ $programacion->NumeroProgramacion }}</td>
                    <td><input type="text" name="Cantidad" value="{{ number_format($programacion->Cantidad, 3, '.', '') }}"></td>
                    <td>
                        <input type="hidden" name="Reproceso" value="0">
                        <input type="checkbox" name="Reproceso" id="Reproceso" value="1" {{ $programacion->Reproceso == '1' ? 'checked' : '' }}>
                    </td>
                    <td>
                        @if ($programacion->Apto == 'SI')
                            Apto
                        @elseif ($programacion->Apto == 'NO')
                            No Apto
                        @endif
                    </td>
                    <td>{{ $programacion->FechaCarga }}</td>
                    <td>{{ $programacion->FechaDescarga }}</td>
                    <td>{{ $programacion->ejecutadoPorOperador->name }}</td>
                    <td>{{ $programacion->Temperatura }}</td>
                    <td>{{ $programacion->medioEnfriamiento->Nombre }}</td>
                    <td>{{ $programacion->DurezaMinima }}</td>
                    <td>{{ $programacion->DurezaMaxima }}</td>
                </tr>
                
                @php
                    $filasFaltantes = max(0, 9);
                @endphp

                @for ($i = 0; $i < $filasFaltantes; $i++)
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                @endfor

            </x-slot>
        </x-simple-table2>

        <div class="row mt-3">
            <div class="col-3">
                <h5 class="text-bold">PROGRAMACION</h5>
            </div>
        </div>

        <div class="row">
            <div class="col-3">
                <div class="form-group mb-0">
                    <select name="" id="" class="form-control form-control-sm" disabled>
                        @foreach ($tipos_programacion as $tipo_programacion)
                            <option value="">{{$programacion->tipoProgramacion->Nombre}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-3">
                <h5 class="text-bold">CARGA</h5>
            </div>
        </div>

        <div class="row">
            <div class="col-3">
                <div class="form-group mb-0">
                    <label for="filtro1" class="font-weight-normal">FECHA CARGA</label>
                    <input type="datetime-local" id="filtro1" name="FechaCarga" class="form-control form-control-sm" value="{{ old('FechaCarga', $programacion->FechaCarga) }}">
                </div>
            </div>
            <div class="col-3">
                <div class="form-group mb-0">
                    <label for="filtro2" class="font-weight-normal">FECHA DESCARGA</label>
                    <input type="datetime-local" id="filtro2" name="FechaDescarga" class="form-control form-control-sm" value="{{ old('FechaDescarga', $programacion->FechaDescarga) }}">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group mb-0">
                    <label for="filtro3" class="font-weight-normal">EJEC. POR OPERADOR</label>
                    <select name="EjecutadoPorOperador" id="filtro3" class="form-control form-control-sm">
                        @foreach ($usuarios as $usuario)
                            <option value="{{$usuario->id}}" {{$usuario->id == old('EjecutadoPorOperador', $programacion->EjecutadoPorOperador) ? 'selected' : ''}}>{{$usuario->name}}</option>                            
                        @endforeach
                    </select>
                </div>
            </div>

        </div>

        <div class="row mt-3">

            <div class="col-6">

                <label class="font-weight-normal">HORNO</label>

                <div class="d-flex justify-content-between align-items-center mb-4 mt-2">
                    <div class="custom-control custom-radio">
                        <input class="custom-control-input" type="radio" id="customRadio1" name="NumeroHorno" value="1" {{ $programacion->NumeroHorno == 1 ? 'checked' : '' }}>
                        <label for="customRadio1" class="custom-control-label font-weight-normal">H1</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input class="custom-control-input" type="radio" id="customRadio2" name="NumeroHorno" value="2" {{ $programacion->NumeroHorno == 2 ? 'checked' : '' }}>
                        <label for="customRadio2" class="custom-control-label font-weight-normal">H2</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input class="custom-control-input" type="radio" id="customRadio3" name="NumeroHorno" value="3" {{ $programacion->NumeroHorno == 3 ? 'checked' : '' }}>
                        <label for="customRadio3" class="custom-control-label font-weight-normal">H3</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input class="custom-control-input" type="radio" id="customRadio4" name="NumeroHorno" value="4" {{ $programacion->NumeroHorno == 4 ? 'checked' : '' }}>
                        <label for="customRadio4" class="custom-control-label font-weight-normal">H4</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input class="custom-control-input" type="radio" id="customRadio5" name="NumeroHorno" value="5" {{ $programacion->NumeroHorno == 5 ? 'checked' : '' }}>
                        <label for="customRadio5" class="custom-control-label font-weight-normal">H5</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input class="custom-control-input" type="radio" id="customRadio6" name="NumeroHorno" value="6" {{ $programacion->NumeroHorno == 6 ? 'checked' : '' }}>
                        <label for="customRadio6" class="custom-control-label font-weight-normal">H6</label>
                    </div>
                </div>

            </div>

            <div class="col-3">
                <div class="form-group mb-0">
                    <label for="filtro4" class="font-weight-normal">TEMPERATURA</label>
                    <input type="text" id="filtro4" name="Temperatura" class="form-control form-control-sm" value="{{ old('Temperatura', $programacion->Temperatura) }}">
                </div>
            </div>
            <div class="col-3">
                <div class="form-group mb-0">
                    <label for="filtro5" class="font-weight-normal">MEDIO ENFRIAMIENTO</label>
                    <select name="IdMedioEnfriamiento" id="filtro5" class="form-control form-control-sm">
                        @foreach ($medios_enfriamiento as $medio_enfriamiento)
                            <option value="{{ $medio_enfriamiento->id }}" {{$medio_enfriamiento->id == old('IdMedioEnfriamiento', $programacion->IdMedioEnfriamiento) ? 'selected' : ''}}>{{$medio_enfriamiento->Nombre}}</option>                            
                        @endforeach
                    </select>
                </div>
            </div>

        </div>

        <div class="d-flex justify-content-between mt-3">
            <a class="btn btn-app bg-primary" href="{{ route('programacion.index') }}">
                <i class="fas fa-arrow-left"></i> Atrás
            </a>

            <button class="btn btn-app bg-primary">
                <i class="fas fa-floppy-disk"></i> Guardar
            </button>
        </div>

    </form>

</x-layout2>



{{-- <x-layout>
    <x-slot name="title">Producción</x-slot>
    <x-slot name="breadcrumbs">
        <li class="nav-home">
            <a href="#"><i class="fas fa-cogs"></i></a>
        </li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="#">Programación</a></li>
    </x-slot>

    <x-form>
        <x-slot name="card_title">Programar</x-slot>
        <x-slot name="action">{{ route('programacion.update', $programacion) }}</x-slot>
        <x-slot name="method">@method('PUT')</x-slot>
        <x-slot name="inputs">

            <x-data-table-no-plus>
                <x-slot name="table_title">Trabajos Seleccionados</x-slot>
                <x-slot name="export_route"></x-slot>
                <x-slot name="add_text">Añadir Item</x-slot>

                <x-slot name="head_tr">
                    <tr>
                        <th>Descripción</th>
                        <th>Programacion</th>
                        <th>N° Prog.</th>
                        <th>Cantidad.</th>
                        <th>RP</th>
                        <th>Apto</th>
                        <th>Fecha Carga</th>
                        <th>Fecha Descarga</th>
                        <th>Ejec. Por</th>
                        <th>Temperatura</th>
                        <th>Medio Enf.</th>
                        <th>DMIN</th>
                        <th>DMAX</th>
                    </tr>
                </x-slot>

                <x-slot name="body_tr">

                    <tbody>

                        <tr>
                            <input type="hidden" name="ItemOrdenTrabajoId" value="{{ $item->id }}">
                            <td>{{ $item->Descripcion }}</td>
                            <td>H{{ $programacion->NumeroHorno }} | {{ $programacion->tipoProgramacion->Nombre }}</td>
                            <td>{{ $programacion->NumeroProgramacion }}</td>
                            <td><input type="text" name="Cantidad" value="{{ number_format($programacion->Cantidad, 3, '.', '') }}"></td>
                            <td>
                                <input type="hidden" name="Reproceso" value="0">
                                <input type="checkbox" name="Reproceso" id="Reproceso" value="1" {{ $programacion->Reproceso == '1' ? 'checked' : '' }}>
                            </td>
                            <td>
                                @if ($programacion->Apto == 'SI')
                                    Apto
                                @elseif ($programacion->Apto == 'NO')
                                    No Apto
                                @endif
                            </td>
                            <td>{{ $programacion->FechaCarga }}</td>
                            <td>{{ $programacion->FechaDescarga }}</td>
                            <td>{{ $programacion->ejecutadoPorOperador->name }}</td>
                            <td>{{ $programacion->Temperatura }}</td>
                            <td>{{ $programacion->medioEnfriamiento->Nombre }}</td>
                            <td>{{ $programacion->DurezaMinima }}</td>
                            <td>{{ $programacion->DurezaMaxima }}</td>
                        </tr>

                    </tbody>

                </x-slot>

                <x-slot name="foot_tr">
                    <tr>
                        <th>Descripción</th>
                        <th>Programacion</th>
                        <th>N° Prog.</th>
                        <th>Cantidad.</th>
                        <th>RP</th>
                        <th>Apto</th>
                        <th>Fecha Carga</th>
                        <th>Fecha Descarga</th>
                        <th>Ejec. Por</th>
                        <th>Temperatura</th>
                        <th>Medio Enf.</th>
                        <th>DMIX</th>
                        <th>DMAX</th>
                    </tr>
                </x-slot>
            </x-data-table-no-plus>

            <div class="col-md-12 mb-3">

                <div class="row">

                    <div class="col-md-6">

                        <x-form-input-select>
                            <x-slot name="label">Programación</x-slot>
                            <x-slot name="name">IdTipoProgramacion</x-slot>
                            <x-slot name="option">
                                @foreach ($tipos_programacion as $tipo_programacion)
                                    <option value="{{$tipo_programacion->id}}"
                                        {{$tipo_programacion->id == old('IdTipoProgramacion', $programacion->tipoProgramacion->id) ? 'selected' : ''}}>
                                            {{$tipo_programacion->Nombre}}
                                    </option>
                                @endforeach
                            </x-slot>
                            <x-slot name="message">
                                @if ($errors->has('IdTipoProgramacion'))
                                    {{ $errors->first('IdTipoProgramacion') }}
                                @elseif (old('IdTipoProgramacion'))
                                    Todo correcto
                                @endif
                            </x-slot>
                            <x-slot name="error">
                                @if ($errors->has('IdTipoProgramacion'))
                                    is-invalid
                                @elseif (old('IdTipoProgramacion') && ! $errors->has('IdTipoProgramacion'))
                                    is-valid
                                @endif
                            </x-slot>
                        </x-form-input-select>

                    </div>

                </div>

                <div class="row">

                    <div class="col-md-3">
                        <x-form-input-datetime-local>
                            <x-slot name="label">Fecha Carga</x-slot>
                            <x-slot name="name">FechaCarga</x-slot>
                            <x-slot name="value">{{ old('FechaCarga', $programacion->FechaCarga) }}</x-slot>
                            <x-slot name="message">
                                @if ($errors->has('FechaCarga'))
                                    {{ $errors->first('FechaCarga') }}
                                @elseif (old('FechaCarga'))
                                    Todo correcto
                                @endif
                            </x-slot>
                            <x-slot name="error">
                                @if ($errors->has('FechaCarga'))
                                    is-invalid
                                @elseif (old('FechaCarga') && ! $errors->has('FechaCarga'))
                                    is-valid
                                @endif
                            </x-slot>
                        </x-form-input-datetime-local>
                    </div>

                    <div class="col-md-3">
                        <x-form-input-datetime-local>
                            <x-slot name="label">Fecha Descarga</x-slot>
                            <x-slot name="name">FechaDescarga</x-slot>
                            <x-slot name="value">{{ old('FechaDescarga', $programacion->FechaDescarga) }}</x-slot>
                            <x-slot name="message">
                                @if ($errors->has('FechaDescarga'))
                                    {{ $errors->first('FechaDescarga') }}
                                @elseif (old('FechaDescarga'))
                                    Todo correcto
                                @endif
                            </x-slot>
                            <x-slot name="error">
                                @if ($errors->has('FechaDescarga'))
                                    is-invalid
                                @elseif (old('FechaDescarga') && ! $errors->has('FechaDescarga'))
                                    is-valid
                                @endif
                            </x-slot>
                        </x-form-input-date-datetime-local>
                    </div>

                    <div class="col-md-6">
                        <x-form-input-select>
                            <x-slot name="label">Ejec. Por Operador</x-slot>
                            <x-slot name="name">EjecutadoPorOperador</x-slot>
                            <x-slot name="option">
                                @foreach ($usuarios as $usuario)
                                    <option value="{{$usuario->id}}"
                                        {{$usuario->id == old('EjecutadoPorOperador', $programacion->ejecutadoPorOperador->id) ? 'selected' : ''}}>
                                            {{$usuario->name}}</option>                            
                                @endforeach
                            </x-slot>
                            <x-slot name="message">
                                @if ($errors->has('EjecutadoPorOperador'))
                                    {{ $errors->first('EjecutadoPorOperador') }}
                                @elseif (old('EjecutadoPorOperador'))
                                    Todo correcto
                                @endif
                            </x-slot>
                            <x-slot name="error">
                                @if ($errors->has('EjecutadoPorOperador'))
                                    is-invalid
                                @elseif (old('EjecutadoPorOperador') && ! $errors->has('EjecutadoPorOperador'))
                                    is-valid
                                @endif
                            </x-slot>
                        </x-form-input-select>
                    </div>
                </div>

                <div class="row">

                    <div class="col-md-6">
                        <x-form-input-radio>
                            <x-slot name="label">Horno</x-slot>
                            <x-slot name="inputs">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="NumeroHorno" id="horno1" value="1" {{$programacion->NumeroHorno == 1 ? 'checked' : ''}}/>
                                    <label class="form-check-label" for="horno1">H1</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="NumeroHorno" id="horno2" value="2" {{$programacion->NumeroHorno == 2 ? 'checked' : ''}}/>
                                    <label class="form-check-label" for="horno2">H2</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="NumeroHorno" id="horno3" value="3" {{$programacion->NumeroHorno == 3 ? 'checked' : ''}}/>
                                    <label class="form-check-label" for="horno3">H3</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="NumeroHorno" id="horno4" value="4" {{$programacion->NumeroHorno == 4 ? 'checked' : ''}}/>
                                    <label class="form-check-label" for="horno4">H4</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="NumeroHorno" id="horno5" value="5" {{$programacion->NumeroHorno == 5 ? 'checked' : ''}}/>
                                    <label class="form-check-label" for="horno5">H5</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="NumeroHorno" id="horno6" value="6" {{$programacion->NumeroHorno == 6 ? 'checked' : ''}}/>
                                    <label class="form-check-label" for="horno6">H6</label>
                                </div>
                            </x-slot>
                        </x-form-input-radio>
                    </div>

                    <div class="col-md-3">
                        <x-form-input-default>
                            <x-slot name="label">Temperatura</x-slot>
                            <x-slot name="name">Temperatura</x-slot>
                            <x-slot name="placeholder"></x-slot>
                            <x-slot name="value">{{ old('Temperatura', $programacion->Temperatura) }}</x-slot>
                            <x-slot name="message">
                                @if ($errors->has('Temperatura'))
                                    {{ $errors->first('Temperatura') }}
                                @elseif (old('Temperatura'))
                                    Todo correcto
                                @endif
                            </x-slot>
                            <x-slot name="error">
                                @if ($errors->has('Temperatura'))
                                    is-invalid
                                @elseif (old('Temperatura') && ! $errors->has('Temperatura'))
                                    is-valid
                                @endif
                            </x-slot>
                        </x-form-input-default>
                    </div>

                    <div class="col-md-3">
                        <x-form-input-select>
                            <x-slot name="label">Medio Enfriamiento</x-slot>
                            <x-slot name="name">IdMedioEnfriamiento</x-slot>
                            <x-slot name="option">
                                @foreach ($medios_enfriamiento as $medio_enfriamiento)
                                    <option value="{{ $medio_enfriamiento->id }}"
                                        {{$medio_enfriamiento->id == old('IdMedioEnfriamiento', $programacion->medioEnfriamiento->id) ? 'selected' : ''}}>
                                        {{$medio_enfriamiento->Nombre}}
                                    </option>                            
                                @endforeach
                            </x-slot>
                            <x-slot name="message">
                                @if ($errors->has('IdMedioEnfriamiento'))
                                    {{ $errors->first('IdMedioEnfriamiento') }}
                                @elseif (old('IdMedioEnfriamiento'))
                                    Todo correcto
                                @endif
                            </x-slot>
                            <x-slot name="error">
                                @if ($errors->has('IdMedioEnfriamiento'))
                                    is-invalid
                                @elseif (old('IdMedioEnfriamiento') && ! $errors->has('IdMedioEnfriamiento'))
                                    is-valid
                                @endif
                            </x-slot>
                        </x-form-input-select>
                    </div>

                </div>

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
                <x-slot name="href">{{ route('programacion.index') }}</x-slot>
            </x-button>
        </x-slot>
    </x-form>

</x-layout> --}}