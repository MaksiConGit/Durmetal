<div>
    <x-form>
        <x-slot name="card_title">Cargas</x-slot>
        <x-slot name="action"></x-slot>
        <x-slot name="method"></x-slot>
        <x-slot name="inputs">

            <x-data-table-no-plus>
                <x-slot name="table_title"></x-slot>
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