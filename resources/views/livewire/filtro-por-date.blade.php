<div>
    <x-form>
        <x-slot name="card_title">Cargas</x-slot>
        <x-slot name="action"></x-slot>
        <x-slot name="method"></x-slot>
        <x-slot name="inputs">

            <x-data-table-no-plus>
                <x-slot name="table_title">
                    <div class="d-flex gap-3 align-items-end">
                        <x-form-input-date-livewire>
                            <x-slot name="label">Desde Fecha Carga</x-slot>
                            <x-slot name="name">FechaCarga</x-slot>
                            <x-slot name="value">{{ old('FechaCarga') }}</x-slot>
                            <x-slot name="message"></x-slot>
                            <x-slot name="error"></x-slot>
                            <x-slot name="livewire">wire:model.live="FechaCarga"</x-slot>
                        </x-form-input-date-livewire>

                        <x-form-input-date-livewire>
                            <x-slot name="label">Hasta Fecha Descarga</x-slot>
                            <x-slot name="name">FechaDescarga</x-slot>
                            <x-slot name="value">{{ old('FechaDescarga') }}</x-slot>
                            <x-slot name="message"></x-slot>
                            <x-slot name="error"></x-slot>
                            <x-slot name="livewire">wire:model.live="FechaDescarga"</x-slot>
                        </x-form-input-date-livewire>
                    </div>
                </x-slot>

                <x-slot name="export_route">{{ route('programacion.export') }}</x-slot>
                <x-slot name="add_text">Añadir Item</x-slot>

                <x-slot name="head_tr">
                    <tr>
                        <th></th>
                        <th>Fecha Carga</th>
                        <th>Fecha Descarga</th>
                        <th>N° Horno</th>
                        <th>Temperatura</th>
                        <th>ENF.</th>
                        <th>Ejec. Por</th>
                        <th>Opciones</th>
                    </tr>
                </x-slot>

                <x-slot name="body_tr">
                    @forelse ($programaciones as $index => $programacion)
                        <tr>
                            <td>
                            <a href="{{ route('cargas.show', $programacion->programacion_ids) }}">Ver</a>
                            </td>
                            <td>{{ $programacion->FechaCarga }}</td>
                            <td>{{ $programacion->FechaDescarga }}</td>
                            <td>{{ $programacion->NumeroHorno }}</td>
                            <td>{{ $programacion->Temperatura }}</td>
                            <td>{{ $programacion->medioEnfriamiento->Nombre }}</td>
                            <td>{{ $programacion->ejecutadoPorOperador->name }}</td>
                            <td class="text-center align-middle">
                                <div class="d-flex justify-content-center align-items-center gap-3">
                                <a
                                    href="{{ route('cargas.edit', $programacion->programacion_ids) }}"
                                    class="btn btn-link btn-primary p-0"
                                    data-bs-toggle="tooltip"
                                    title="Editar carga"
                                >
                                    <i class="fa fa-edit fa-lg"></i>
                                </a>
                                <form
                                    action="{{ route('cargas.destroy', $programacion->programacion_ids) }}"
                                    method="POST"
                                    onsubmit="return confirm('¿Estás seguro de que quieres eliminar esta carga?')"
                                    class="m-0 p-0"
                                >
                                    @csrf
                                    @method('DELETE')
                                    <button
                                    type="submit"
                                    class="btn btn-link btn-danger p-0"
                                    data-bs-toggle="tooltip"
                                    title="Eliminar carga"
                                    >
                                    <i class="fa fa-times fa-lg"></i>
                                    </button>
                                </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="12">No se encontraron resultados.</td></tr>
                    @endforelse
                </x-slot>

                <x-slot name="foot_tr">
                    <tr>
                        <th></th>
                        <th>Fecha Carga</th>
                        <th>Fecha Descarga</th>
                        <th>N° Horno</th>
                        <th>Temperatura</th>
                        <th>ENF.</th>
                        <th>Ejec. Por</th>
                        <th>Opciones</th>
                    </tr>
                </x-slot>
            </x-data-table-no-plus>
        </x-slot>
        <x-slot name="buttons">
            <x-button>
                <x-slot name="text">Volver</x-slot>
                <x-slot name="color">danger</x-slot>
                <x-slot name="href">{{ route('index') }}</x-slot>
            </x-button>
        </x-slot>
    </x-form>
</div>