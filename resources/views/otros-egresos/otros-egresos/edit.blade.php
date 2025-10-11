{{-- <x-layout>
    <x-slot name="title">Producción</x-slot>
    <x-slot name="breadcrumbs">
        <li class="nav-home">
            <a href="#"><i class="fas fa-money-bill-wave"></i></a>
        </li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="#">Otros Egresos</a></li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="#">Editar otro egreso</a></li>
    </x-slot>

    <x-form>
        <x-slot name="title">Durmetal</x-slot>
        <x-slot name="card_title">Editar otro egreso</x-slot>
        <x-slot name="action">{{ route('otros-egresos.otros-egresos.update', $movimiento_cuenta_gastos) }}</x-slot>
        <x-slot name="method">@method('PUT')</x-slot>

        <x-slot name="inputs">

            <div class="col-md-8 mb-3">
            
                <x-form-input-select>
                    <x-slot name="label">Cuenta</x-slot>
                    <x-slot name="name">IdCuentaOtrosEgresos</x-slot>
                    <x-slot name="option">
                        @foreach ($cuentas_otros_egresos as $padre)
                            <option value="{{ $padre->id }}"
                                {{ old('IdCuentaOtrosEgresos', $movimiento_cuenta_gastos->IdCuentaOtrosEgresos) == $padre->id ? 'selected' : '' }}>
                                {{ $padre->Nombre }}
                            </option>
                            @foreach ($padre->hijos as $hijo)
                                <option value="{{ $hijo->id }}"
                                    {{ old('IdCuentaOtrosEgresos', $movimiento_cuenta_gastos->IdCuentaOtrosEgresos) == $hijo->id ? 'selected' : '' }}>
                                    {{$padre->Nombre}} — {{ $hijo->Nombre }}
                                </option>
                            @endforeach
                        @endforeach
                    </x-slot>
                    <x-slot name="message">
                        @error('IdCuentaOtrosEgresos')
                            {{$message}}
                        @enderror
                    </x-slot>
                    <x-slot name="error">
                        @if ($errors->has('IdCuentaOtrosEgresos'))
                            is-invalid
                        @elseif (old('IdCuentaOtrosEgresos') && ! $errors->has('IdCuentaOtrosEgresos'))
                            is-valid
                        @endif
                    </x-slot>
                </x-form-input-select>

            </div>

            <div class="col-md-8 mb-3">

                <x-form-input-date>
                    <x-slot name="label">Fecha Devengado</x-slot>
                    <x-slot name="name">Fecha</x-slot>
                    <x-slot name="placeholder"></x-slot>
                    <x-slot name="value">{{ old('Fecha', $movimiento_cuenta_gastos->Fecha)}}</x-slot>
                    <x-slot name="message">
                        @error('Fecha')
                            {{$message}}
                        @enderror
                    </x-slot>
                    <x-slot name="error">
                        @if ($errors->has('Fecha'))
                            is-invalid
                        @elseif (old('Fecha') && ! $errors->has('Fecha'))
                            is-valid
                        @endif
                    </x-slot>
                </x-form-input-date>

            </div>

            <div class="col-md-8 mb-3">

                <x-form-input-date>
                    <x-slot name="label">Fecha de Pago</x-slot>
                    <x-slot name="name">FechaPago</x-slot>
                    <x-slot name="placeholder"></x-slot>
                    <x-slot name="value">{{ old('FechaPago', $movimiento_cuenta_gastos->FechaPago) }}</x-slot>
                    <x-slot name="message">
                        @error('FechaPago')
                            {{$message}}
                        @enderror
                    </x-slot>
                    <x-slot name="error">
                        @if ($errors->has('FechaPago'))
                            is-invalid
                        @elseif (old('FechaPago') && ! $errors->has('FechaPago'))
                            is-valid
                        @endif
                    </x-slot>
                </x-form-input-date>

            </div>

            <div class="col-md-8 mb-3">

                <x-form-input-default>
                    <x-slot name="label">Descripción</x-slot>
                    <x-slot name="name">Descripcion</x-slot>
                    <x-slot name="placeholder"></x-slot>
                    <x-slot name="value">{{old('Descripcion', $movimiento_cuenta_gastos->Descripcion)}}</x-slot>
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

            </div>

            <div class="col-md-8 mb-3">

                <x-form-input-default>
                    <x-slot name="label">Importe</x-slot>
                    <x-slot name="name">Importe</x-slot>
                    <x-slot name="placeholder">0.00</x-slot>
                    <x-slot name="value">{{number_format(old('Importe', $movimiento_cuenta_gastos->Importe), 2, '.', '')}}</x-slot>
                    <x-slot name="message">
                        @error('Importe')
                            {{$message}}
                        @enderror
                    </x-slot>
                    <x-slot name="error">
                        @if ($errors->has('Importe'))
                            is-invalid
                        @elseif (old('Importe') && ! $errors->has('Importe'))
                            is-valid
                        @endif
                    </x-slot>
                </x-form-input-default>

            </div>

        </x-slot>
        <x-slot name="buttons">

            <div class="d-flex justify-content-end gap-2">
                <x-form-button>
                    <x-slot name="text">Guardar</x-slot>
                    <x-slot name="color">success</x-slot>
                </x-form-button>
                <x-button>
                    <x-slot name="text">Cancelar</x-slot>
                    <x-slot name="color">danger</x-slot>
                    <x-slot name="href">{{ route('otros-egresos.otros-egresos.index') }}</x-slot>
                </x-button>
            </div>

        </x-slot>
    </x-form>

</x-layout> --}}


<x-layout2>
    <x-slot name="title">MODIFICANDO GASTO</x-slot>

    <form action="{{ route('otros-egresos.otros-egresos.update', $movimiento_cuenta_gastos) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">

            <div class="col-2"></div>
            <div class="col-4 mb-3">
                <div class="form-group mb-0">
                    <label for="IdCuentaOtrosEgresos" class="font-weight-normal">CUENTA</label>
                    <select name="IdCuentaOtrosEgresos" id="" class="form-control form-control-sm">
                        @foreach ($cuentas_otros_egresos as $padre)
                            <option value="{{ $padre->id }}"
                                {{ old('IdCuentaOtrosEgresos', $movimiento_cuenta_gastos->IdCuentaOtrosEgresos) == $padre->id ? 'selected' : '' }}>
                                {{ $padre->Nombre }}
                            </option>
                            @foreach ($padre->hijos as $hijo)
                                <option value="{{ $hijo->id }}"
                                    {{ old('IdCuentaOtrosEgresos', $movimiento_cuenta_gastos->IdCuentaOtrosEgresos) == $hijo->id ? 'selected' : '' }}>
                                    {{$padre->Nombre}} — {{ $hijo->Nombre }}
                                </option>
                            @endforeach
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-4 mb-3">
                <div class="form-group mb-0">
                    <label for="Fecha" class="font-weight-normal">FECHA DEVENGADO</label>
                    <input type="date" id="Fecha" name="Fecha" class="form-control form-control-sm" value="{{ old('Fecha', $movimiento_cuenta_gastos->Fecha)}}">
                </div>
            </div>
            <div class="col-2 mb-3"></div>


            <div class="col-2 mb-3"></div>
            <div class="col-4 mb-3">
                <div class="form-group mb-0">
                    <label for="FechaPago" class="font-weight-normal">FECHA PAGO</label>
                    <input type="date" id="FechaPago" name="FechaPago" class="form-control form-control-sm" value="{{ old('FechaPago', $movimiento_cuenta_gastos->FechaPago) }}">
                </div>
            </div>
            <div class="col-4 mb-3">
                <div class="form-group mb-0">
                    <label for="Descripcion" class="font-weight-normal">DESCRIPCION</label>
                    <input type="text" id="Descripcion" name="Descripcion" class="form-control form-control-sm" value="{{old('Descripcion', $movimiento_cuenta_gastos->Descripcion)}}">
                </div>
            </div>
            <div class="col-2 mb-3"></div>

            <div class="col-2 mb-3"></div>
            <div class="col-4 mb-3">
                <div class="form-group mb-0">
                    <label for="Importe" class="font-weight-normal">IMPORTE</label>
                    <input type="text" id="Importe" name="Importe" class="form-control form-control-sm" value="{{number_format(old('Importe', $movimiento_cuenta_gastos->Importe), 2, '.', '')}}">
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-2"></div>
            <div class="col-8">
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-app bg-primary">
                        <i class="fas fa-floppy-disk"></i> Guardar
                    </button>

                    <a class="btn btn-app bg-primary" href="{{ route('otros-egresos.otros-egresos.index') }}">
                        <i class="fas fa-ban"></i> Cancelar
                    </a>
                </div>
            </div>
            <div class="col-2"></div>
        </div>

    </form>

</x-layout2>