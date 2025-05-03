<x-layout>

  <x-slot name="title">Ventas</x-slot>
  <x-slot name="breadcrumbs">
      <li class="nav-home">
          <a href="#"><i class="fas fa-money-bill-wave"></i></a>
        </li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="#">Clientes</a></li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="#">Ver clientes</a></li>
  </x-slot>

    <x-data-table>
        <x-slot name="table_title">Clientes</x-slot>
        <x-slot name="add_text">Añadir cliente</x-slot>
        <x-slot name="head_tr">
            <tr>
                <th>Código</th>
                <th>Nombre</th>
                <th>Domicilio</th>
                <th>Localidad</th>
                <th>Provincia</th>
                <th>Teléfono</th>
                <th>Condición IVA</th>
                <th>Tipo de Documento</th>
                <th>N° de Documento</th>
                <th>Activo</th>
                <th>Opciones</th>
            </tr>
        </x-slot>
        <x-slot name="body_tr">

            @foreach ($clients as $client)
                <tr>
                    <td>{{ $client->id }}</td>
                    <td>{{ $client->name }}</td>
                    <td>{{ $client->address }}</td>
                    <td>{{ $client->city->name }}</td>
                    <td>{{ $client->city->province->name }}</td>
                    <td>{{ $client->phone }}</td>
                    <td>{{ $client->ivaCondition->name }}</td>
                    <td>{{ $client->documentType->name }}</td>
                    <td>{{ $client->document_number }}</td>
                    <td>{{ $client->is_active == 1 ? 'Sí' : 'No' }}</td>
                    <td class="text-center align-middle">
                        <div class="d-flex justify-content-center align-items-center gap-3">
                          <a
                            href="{{ route('clients.edit', $client) }}"
                            class="btn btn-link btn-primary p-0"
                            data-bs-toggle="tooltip"
                            title="Editar cliente"
                          >
                            <i class="fa fa-edit fa-lg"></i>
                          </a>
                          <form
                            action="{{ route('clients.destroy', $client) }}"
                            method="POST"
                            onsubmit="return confirm('¿Estás seguro de que quieres eliminar este cliente?')"
                            class="m-0 p-0"
                          >
                            @csrf
                            @method('DELETE')
                            <button
                              type="submit"
                              class="btn btn-link btn-danger p-0"
                              data-bs-toggle="tooltip"
                              title="Eliminar cliente"
                            >
                              <i class="fa fa-times fa-lg"></i>
                            </button>
                          </form>
                        </div>
                      </td>
                      
                </tr>
            @endforeach

        </x-slot>
        <x-slot name="foot_tr">
            <tr>
                <th>Código</th>
                <th>Nombre</th>
                <th>Domicilio</th>
                <th>Localidad</th>
                <th>Provincia</th>
                <th>Teléfono</th>
                <th>Condición IVA</th>
                <th>Tipo de Documento</th>
                <th>N° de Documento</th>
                <th>Activo</th>
                <th>Opciones</th>
            </tr>
        </x-slot>
    </x-data-table>
</x-layout>
