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
    </tr>

    <tr 
        class="expandable-body" 
        style="{{ $expandido ? 'display: table-row;' : 'display: none;' }}"
    >
        <td colspan="15">

            <form action="{{ route('asignar-factores.update', $usuario) }}" method="POST">

                @csrf
                @method('PUT')

                <div class="p-0">
                    <table class="table table-sm table-bordered mb-0">
                        <thead>
                        <tr class="bg-dark text-white">
                            <th></th>
                            <th>FACTOR</th>
                            <th>VALOR</th>
                        </tr>
                        </thead>
                        <tbody>

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



                        </tbody>
                    </table>
                </div>
                       
                <div class="row p-3">
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

                <div class="d-flex justify-content-end p-3">
                    <button type="submit" class="btn btn-sidebar btn-sm bg-orange">
                        <span class="text-white">Aceptar</span>
                        <i class="fas fa-check fa-fw text-white ml-2"></i>
                    </button>

                    <a 
                        class="btn btn-sidebar btn-sm bg-orange ml-2"
                        wire:click="cerrar"
                    >
                        <span class="text-white">Cancelar</span>
                        <i class="fas fa-xmark fa-fw text-white ml-2"></i>
                    </a>
                </div>

            </form>
        </td>
    </tr>

</tbody>