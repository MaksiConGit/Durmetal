<div>
    <x-layout2-sidebar>
        <x-slot name="title">Tratamientos</x-slot>

        <x-slot name="filtros">
            <div class="form-inline mt-5 mr-3 d-flex flex-column align-items-center">

                <div class="form-group mb-3">
                    <a class="btn btn-app bg-primary" href="{{ route('ventas.precios.create', $selectedTratamiento) }}">
                        <i class="fas fa-list"></i> Precios
                    </a>
                </div>
            </div>

        </x-slot>

        <x-simple-table2>
            <x-slot name="thead">
                <tr>
                    <th>NOMBRE</th>
                </tr>
            </x-slot>

            <x-slot name="tbody">
                @forelse ($tratamientos as $tratamiento)
                    <tr 
                        style="cursor: pointer;"
                        wire:click="selectItem({{ $tratamiento->id }})"
                        class="{{ $selectedItem == $tratamiento->id ? 'table-primary' : '' }}"
                    >
                        <td>{{ $tratamiento->Nombre }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="1" class="text-center">No hay tratamientos registradas</td>
                    </tr>
                @endforelse
            </x-slot>
        </x-simple-table2>
    </x-layout2-sidebar>

</div>
