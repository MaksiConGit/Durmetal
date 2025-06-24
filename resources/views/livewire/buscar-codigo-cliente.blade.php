<div class="card-body">
    <div class="row">
        <div class="d-flex flex-wrap gap-2">

            <div class="col-md-2">

                <x-form-input-default-livewire>
                    <x-slot name="label">Cod. Cliente</x-slot>
                    <x-slot name="livewire">wire:model.live="cliente_id"</x-slot>
                    <x-slot name="name">cliente_id</x-slot>
                    <x-slot name="placeholder"></x-slot>
                    <x-slot name="value"></x-slot>
                    <x-slot name="message"></x-slot>
                    <x-slot name="error"></x-slot>
                </x-form-input-default-livewire>

            </div>

            <div class="col-md-4">

                <x-form-input-select-livewire>
                    <x-slot name="label">Nombre</x-slot>
                    <x-slot name="livewire">wire:model.live="cliente_id"</x-slot>
                    <x-slot name="name">IdCliente</x-slot>
                    <x-slot name="option">
                        <option value="">-- Todos los clientes --</option>
                        @foreach ($clientes as $cliente)
                            <option value="{{ $cliente->id }}">{{ $cliente->id }} | {{ $cliente->Nombre }}</option>
                        @endforeach
                    </x-slot>
                    <x-slot name="message"></x-slot>
                    <x-slot name="error"></x-slot>
                </x-form-input-select-livewire>
                
            </div>
            
            <div class="align-self-end">
                <div class="form-group">
                    <a href="" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalToggle">Buscar</a>
                </div>
            </div>

            <x-modal-table>
                <x-slot name="title">Buscar Cliente</x-slot>
                <x-slot name="body">

                    <div class="table-responsive" style="max-height: 60vh; overflow-y: auto;">

                        <x-data-table-no-plus-no-export>

                            <x-slot name="table_title">Clientes</x-slot>
                            <x-slot name="export_route">{{ route('clients.export') }}</x-slot>
                            <x-slot name="create_route">{{ route('clients.create') }}</x-slot>
                            <x-slot name="add_text">Añadir cliente</x-slot>
                            <x-slot name="head_tr">
                                <tr>
                                    <th>Código</th>
                                    <th>Nombre</th>
                                    <th>Tipo de Documento</th>
                                    <th>Número</th>
                                    <th>Domicilio</th>
                                    <th>Localidad</th>
                                    <th>Provincia</th>
                                    <th>Activo</th>
                                </tr>
                            </x-slot>
                            <x-slot name="body_tr">
                        
                                @foreach ($clientes as $client)
                                    <tr style="cursor: pointer;" wire:click="$set('cliente_id', {{ $client->id }})" data-bs-dismiss="modal">
                                        <td>{{ $client->id }}</td>
                                        <td>{{ $client->Nombre }}</td>
                                        <td>{{ $client->TipoDocumento }}</td>
                                        <td>{{ $client->Telefono }}</td>
                                        <td>{{ $client->Domicilio }}</td>
                                        <td>{{ $client->localidad->Nombre ?? 'Ciudad no asignada' }}</td>
                                        <td>{{ $client->localidad->provincia->Nombre ?? 'Provincia no asignada' }}</td>
                                        <td>
                                            <input type="checkbox" name="" id="" disabled {{ $client->Activo == 1 ? 'checked' : '' }}>
                                        </td>
                                    </tr>
                                @endforeach

                            </x-slot>
                            <x-slot name="foot_tr">
                                <tr>
                                    <th>Código</th>
                                    <th>Nombre</th>
                                    <th>Tipo de Documento</th>
                                    <th>Número</th>
                                    <th>Domicilio</th>
                                    <th>Localidad</th>
                                    <th>Provincia</th>
                                    <th>Activo</th>
                                </tr>
                            </x-slot>
                        </x-data-table-no-plus-no-export>

                    </div>

                </x-slot>
                <x-slot name="primary_text">Aceptar</x-slot>
                <x-slot name="secondary_text">Volver</x-slot>
            </x-modal-table>
        
        </div>
    </div>
</div>