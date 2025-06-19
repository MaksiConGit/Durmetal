<tbody>
    <tr 
        wire:click="toggleExpandido" 
        style="cursor:pointer;"
        aria-expanded="{{ $expandido ? 'true' : 'false' }}"
    >
        <td>{{ $usuario->email }}</td>
        <td>{{ $usuario->name }}</td>
        <td>{{ number_format($usuario->IndiceBasePremio, 2, '.', '') }}</td>
        <td>{{ $this->promedio }}</td>
        <td></td>
    </tr>

    <tr 
        class="expandable-body" 
        style="{{ $expandido ? 'display: table-row;' : 'display: none;' }}"
    >
        <td colspan="12">

            <form action="{{ route('asignar-factores.update', $usuario) }}" method="POST">

                @csrf
                @method('PUT')

                <x-card>

                    <x-slot name="body">

                        <x-data-table-no-plus-no-export>
                            <x-slot name="table_title">Factores de {{ $usuario->name }}</x-slot>

                            <x-slot name="head_tr">
                                <tr>
                                <th></th>
                                <th>Factor</th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th>Valor</th>
                                </tr>
                            </x-slot>

                            <x-slot name="body_tr">

                                @foreach ($factores as $key => $factor)

                                    <input type="hidden" name="IdFactores[{{$key}}]" id="" value="{{$factor->id}}">


                                    <tr>
                                        <td>
                                            <input type="hidden" name="FactorActivo[{{$key}}]" id="" value="0">
                                            <input type="checkbox"
                                                name="FactorActivo[{{$key}}]"
                                                value="1"
                                                wire:key="checkbox-{{ $key }}"
                                                wire:model.live="activos.{{ $key }}"
                                                @checked($activos[$key] ?? false)
                                            >
                                        </td>
                                        <td>{{ $factor->Nombre ?? 'Factor #' . $factor->id }}</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>
                                            <input type="text"
                                                name="ValorFactor[{{$key}}]"
                                                wire:key="input-{{ $key }}"
                                                wire:model.live="valores.{{ $key }}"
                                                value="{{ $valores[$key] ?? '' }}"
                                            >
                                        </td>
                                    </tr>
                                @endforeach

                            </x-slot>

                            <x-slot name="foot_tr">
                                <tr>
                                <th></th>
                                <th>Factor</th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th>Valor</th>
                                </tr>
                            </x-slot>
                        </x-data-table-no-plus-no-export>

                    </x-slot>

                    <x-slot name="buttons">

                        <div class="row mb-3">
                            <div class="col-md-3">
                                <x-form-input-default>
                                    <x-slot name="label">Índice Base</x-slot>
                                    <x-slot name="name">IndiceBasePremio[{{$usuario->id}}]</x-slot>
                                    <x-slot name="placeholder"></x-slot>
                                    <x-slot name="value">{{ number_format($usuario->IndiceBasePremio, 2, '.', '') }}</x-slot>
                                    <x-slot name="message">
                                        @if ($errors->has('IndiceBasePremio'))
                                            {{ $errors->first('IndiceBasePremio') }}
                                        @elseif (old('IndiceBasePremio'))
                                            Todo correcto
                                        @endif
                                    </x-slot>
                                    <x-slot name="error">
                                        @if ($errors->has('IndiceBasePremio'))
                                            is-invalid
                                        @elseif (old('IndiceBasePremio') && ! $errors->has('IndiceBasePremio'))
                                            is-valid
                                        @endif
                                    </x-slot>
                                </x-form-input-default>
                            </div>

                            <div class="col-md-6"></div>

                            <div class="col-md-3 text-end">
                                <x-form-input-disabled>
                                    <x-slot name="label">Promedio</x-slot>
                                    <x-slot name="name"></x-slot>
                                    <x-slot name="placeholder"></x-slot>
                                    <x-slot name="value">{{ number_format($this->promedio, 2, '.', '') }}</x-slot>
                                    <x-slot name="message"></x-slot>
                                    <x-slot name="error"></x-slot>
                                </x-form-input-disabled>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col text-end">
                                <x-form-button>
                                    <x-slot name="text">Aceptar</x-slot>
                                    <x-slot name="color">success</x-slot>
                                </x-form-button>
                                {{-- <x-button>
                                    <x-slot name="text">Cancelar</x-slot>
                                    <x-slot name="color">danger</x-slot>
                                    <x-slot name="href">{{ route('durezas.index') }}</x-slot>
                                </x-button> --}}
                            </div>
                        </div>

                    </x-slot>

                </x-card>

            </form>

            <div class="text-end">
                <strong>Promedio:</strong> {{ $this->promedio }}
            </div>
        </td>
    </tr>
</tbody>