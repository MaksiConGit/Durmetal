<x-layout>

    <x-slot name="title">Compras</x-slot>
    <x-slot name="breadcrumbs">
        <li class="nav-home">
            <a href="#"><i class="fas fa-money-bill-wave"></i></a>
            </li>
            <li class="separator"><i class="icon-arrow-right"></i></li>
            <li class="nav-item"><a href="#">Actualizaciones</a></li>
            <li class="separator"><i class="icon-arrow-right"></i></li>
            <li class="nav-item"><a href="#">Cuentas de Gastos</a></li>
    </x-slot>

    <x-data-table>
      
        <x-slot name="table_title">Cuentas de Gastos</x-slot>
        <x-slot name="export_route">{{ route('clients.export') }}</x-slot>
        <x-slot name="create_route">{{ route('compras.actualizaciones.cuentas-de-gastos.create') }}</x-slot>
        <x-slot name="add_text">Añadir Cuenta de Gastos</x-slot>
        <x-slot name="head_tr">
            <tr>
                <th>Opciones</th>
                <th>Nombre</th>
                <th>Descripción</th>
            </tr>
        </x-slot>
        <x-slot name="body_tr">
    
            @forelse ($cuentas_de_gastos as $cuenta_de_gastos)
                <tr>
                    <td class="text-center align-middle">
                        <div class="d-flex justify-content-center align-items-center gap-3">
                          <a
                            href="{{ route('compras.actualizaciones.cuentas-de-gastos.edit', $cuenta_de_gastos) }}"
                            class="btn btn-link btn-primary p-0"
                            data-bs-toggle="tooltip"
                            title="Editar cuenta de gastos"
                          >
                            <i class="fa fa-edit fa-lg"></i>
                          </a>
                          <form
                            action="{{ route('compras.actualizaciones.cuentas-de-gastos.destroy', $cuenta_de_gastos) }}"
                            method="POST"
                            onsubmit="return confirm('¿Estás seguro de que quieres eliminar esta cuenta de gastos?')"
                            class="m-0 p-0"
                          >
                            @csrf
                            @method('DELETE')
                            <button
                              type="submit"
                              class="btn btn-link btn-danger p-0"
                              data-bs-toggle="tooltip"
                              title="Eliminar cuenta de gastos"
                            >
                              <i class="fa fa-times fa-lg"></i>
                            </button>
                          </form>
                        </div>
                    </td>
                    <td>{{ $cuenta_de_gastos->Nombre }}</td>
                    <td>{{ $cuenta_de_gastos->Descripcion }}</td>
                </tr>
            @empty
                <tr><td colspan="3">No se encontraron resultados.</td></tr>
            @endforelse
        </x-slot>
        <x-slot name="foot_tr">
            <tr>
                <th>Opciones</th>
                <th>Nombre</th>
                <th>Descripción</th>
            </tr>
        </x-slot>
    </x-data-table>

</x-layout>
