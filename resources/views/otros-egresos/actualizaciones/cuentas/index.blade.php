<x-layout>

    <x-slot name="title">Otros Egresos</x-slot>
    <x-slot name="breadcrumbs">
        <li class="nav-home">
            <a href="#"><i class="fas fa-money-bill-wave"></i></a>
            </li>
            <li class="separator"><i class="icon-arrow-right"></i></li>
            <li class="nav-item"><a href="#">Actualizaciones</a></li>
            <li class="separator"><i class="icon-arrow-right"></i></li>
            <li class="nav-item"><a href="#">Cuentas</a></li>
    </x-slot>

    <x-data-table >
      
        <x-slot name="table_title">Cuentas</x-slot>
        <x-slot name="export_route">{{ route('clients.export') }}</x-slot>
        <x-slot name="create_route">{{ route('otros-egresos.actualizaciones.cuentas.create') }}</x-slot>
        <x-slot name="add_text">Añadir Cuenta</x-slot>
        <x-slot name="head_tr">
            <tr>
                <th>Opciones</th>
                <th>Cuenta Padre</th>
                <th>Nombre</th>
                <th>Descripción</th>
            </tr>
        </x-slot>
        <x-slot name="body_tr">

            @forelse ($cuentas_otros_egresos as $padre)
                <tr>
                    <td class="text-start align-middle">
                        <div class="d-flex justify-content-start align-items-center gap-3 ms-2">
                            <a
                                href="{{ route('otros-egresos.actualizaciones.cuentas.edit', $padre) }}"
                                class="btn btn-link btn-primary p-0"
                                data-bs-toggle="tooltip"
                                title="Editar cuenta"
                            >
                                <i class="fa fa-edit fa-lg"></i>
                            </a>
                            <form
                                action="{{ route('otros-egresos.actualizaciones.cuentas.destroy', $padre) }}"
                                method="POST"
                                onsubmit="return confirm('¿Estás seguro de que quieres eliminar esta cuenta?')"
                                class="m-0 p-0"
                            >
                                @csrf
                                @method('DELETE')
                                <button
                                    type="submit"
                                    class="btn btn-link btn-danger p-0"
                                    data-bs-toggle="tooltip"
                                    title="Eliminar cuenta"
                                >
                                    <i class="fa fa-times fa-lg"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                    <td></td>
                    <td>{{ $padre->Nombre }}</td>
                    <td>{{ $padre->Descripcion }}</td>
                </tr>

                @foreach ($padre->hijos as $hijo)
                    <tr>
                        <td class="text-start align-middle">
                            <div class="d-flex justify-content-start align-items-center gap-3 ms-2">
                                <a
                                    href="{{ route('otros-egresos.actualizaciones.cuentas.edit', $hijo) }}"
                                    class="btn btn-link btn-primary p-0"
                                    data-bs-toggle="tooltip"
                                    title="Editar cuenta"
                                >
                                    <i class="fa fa-edit fa-lg"></i>
                                </a>
                                <form
                                    action="{{ route('otros-egresos.actualizaciones.cuentas.destroy', $hijo) }}"
                                    method="POST"
                                    onsubmit="return confirm('¿Estás seguro de que quieres eliminar esta cuenta?')"
                                    class="m-0 p-0"
                                >
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        type="submit"
                                        class="btn btn-link btn-danger p-0"
                                        data-bs-toggle="tooltip"
                                        title="Eliminar cuenta"
                                    >
                                        <i class="fa fa-times fa-lg"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                        <td>{{ $padre->Nombre }}</td>
                        <td>{{ $hijo->Nombre }}</td>
                        <td>{{ $hijo->Descripcion }}</td>
                    </tr>

                @endforeach

            @empty
                <tr><td colspan="11">No se encontraron resultados.</td></tr>
            @endforelse
        </x-slot>
        <x-slot name="foot_tr">
            <tr>
                <th>Opciones</th>
                <th>Cuenta Padre</th>
                <th>Nombre</th>
                <th>Descripción</th>
            </tr>
        </x-slot>
    </x-data-table>

</x-layout>
