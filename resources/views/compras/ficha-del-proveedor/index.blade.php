{{-- <x-layout>
    <x-slot name="title">Compras</x-slot>
    <x-slot name="breadcrumbs">
        <li class="nav-home">
            <a href="#"><i class="fas fa-money-bill-wave"></i></a>
        </li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="#">Ficha del Proveedor</a></li>
    </x-slot>

    <div class="card">
        <div class="card-header">
            <div class="card-title">Filtros</div>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="d-flex flex-wrap gap-2">

                    <div class="col-md-1">

                        <x-form-input-default-livewire>
                            <x-slot name="label">Código</x-slot>
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
                            <x-slot name="name">cliente_id</x-slot>
                            <x-slot name="option">
                                <option value="">-- Todos los proveedores --</option>
                                @foreach ($proveedores as $proveedor)
                                    <option value="{{ $proveedor->id }}">{{ $proveedor->id }} | {{ $proveedor->Nombre }}</option>
                                @endforeach
                            </x-slot>
                            <x-slot name="message"></x-slot>
                            <x-slot name="error"></x-slot>
                        </x-form-input-select-livewire>
                        
                    </div>

                    <div class="col-md-4">

                        <x-form-input-default-livewire>
                            <x-slot name="label">N° Documento</x-slot>
                            <x-slot name="livewire">wire:model.live="cliente_id"</x-slot>
                            <x-slot name="name">cliente_id</x-slot>
                            <x-slot name="placeholder"></x-slot>
                            <x-slot name="value"></x-slot>
                            <x-slot name="message"></x-slot>
                            <x-slot name="error"></x-slot>
                        </x-form-input-default-livewire>

                    </div>
                    
                    <div class="align-self-end">
                        <div class="form-group">
                            <a href="" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalToggle">Buscar</a>
                        </div>
                    </div>

                    <x-modal-table>
                        <x-slot name="title">Buscar Proveedor</x-slot>
                        <x-slot name="body">

                            <div class="table-responsive" style="max-height: 60vh; overflow-y: auto;">

                                <x-data-table-no-plus-no-export>
        
                                    <x-slot name="table_title">Proveedores</x-slot>
                                    <x-slot name="export_route">{{ route('clients.export') }}</x-slot>
                                    <x-slot name="create_route">{{ route('compras.actualizaciones.proveedores.create') }}</x-slot>
                                    <x-slot name="add_text">Añadir proveedor</x-slot>
                                    <x-slot name="head_tr">
                                        <tr>
                                            <th>Código</th>
                                            <th>Nombre</th>
                                            <th>CUIT</th>
                                            <th>Domicilio</th>
                                            <th>Localidad</th>
                                            <th>Provincia</th>
                                            <th>Activo</th>
                                        </tr>
                                    </x-slot>
                                    <x-slot name="body_tr">
                                
                                        @foreach ($proveedores as $proveedor)
                                            <tr style="cursor: pointer;" wire:click="$set('cliente_id', {{ $proveedor->id }})" data-bs-dismiss="modal">
                                                <td>{{ $proveedor->id }}</td>
                                                <td>{{ $proveedor->Nombre }}</td>
                                                <td>{{ $proveedor->NumeroDocumento }}</td>
                                                <td>{{ $proveedor->Direccion }}</td>
                                                <td>{{ $proveedor->localidad->Nombre ?? 'Ciudad no asignada' }}</td>
                                                <td>{{ $proveedor->localidad->provincia->Nombre ?? 'Provincia no asignada' }}</td>
                                                <td>
                                                    <input type="checkbox" name="" id="" disabled {{ $proveedor->Activo == 1 ? 'checked' : '' }}>
                                                </td>
                                            </tr>
                                        @endforeach

                                    </x-slot>
                                    <x-slot name="foot_tr">
                                        <tr>
                                            <th>Código</th>
                                            <th>Nombre</th>
                                            <th>CUIT</th>
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
    </div>

    <x-card>
        <x-slot name="body">

            <x-data-table>
            
                <x-slot name="table_title">Ficha del Proveedor</x-slot>
                <x-slot name="export_route">{{ route('clients.export') }}</x-slot>
                <x-slot name="create_route">{{ route('compras.actualizaciones.proveedores.create') }}</x-slot>
                <x-slot name="add_text">Añadir proveedor</x-slot>
                <x-slot name="head_tr">
                    <tr>
                        <th></th>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>N° Documento</th>
                        <th>Domicilio</th>
                        <th>Localidad</th>
                        <th>Provincia</th>
                        <th>Condición IVA</th>
                    </tr>
                </x-slot>
                <x-slot name="body_tr">
            
                    @forelse ($proveedores as $proveedor)
                        <tr>
                            <td><a href="{{ route('compras.ficha-del-proveedor.show', $proveedor) }}">Ver</a></td>
                            <td>{{ $proveedor->id }}</td>
                            <td>{{ $proveedor->Nombre }}</td>
                            <td>{{ $proveedor->NumeroDocumento }}</td>
                            <td>{{ $proveedor->Direccion }}</td>
                            <td>{{ $proveedor->localidad->Nombre }}</td>
                            <td>{{ $proveedor->localidad->provincia->Nombre }}</td>
                            <td>{{ $proveedor->condicionIVA->Nombre }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="11">No se encontraron resultados.</td></tr>
                    @endforelse
                </x-slot>
                <x-slot name="foot_tr">
                    <tr>
                        <th></th>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>N° Documento</th>
                        <th>Domicilio</th>
                        <th>Localidad</th>
                        <th>Provincia</th>
                        <th>Condición IVA</th>
                    </tr>
                </x-slot>
            </x-data-table>
        </x-slot>

        <x-slot name="buttons">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex gap-2">
                    <x-button>
                        <x-slot name="text">Volver</x-slot>
                        <x-slot name="color">danger</x-slot>
                        <x-slot name="href">{{ route('index') }}</x-slot>
                    </x-button>
                </div>
            </div>
        </x-slot>

    </x-card>

</x-layout> --}}


<x-layout2>
    <x-slot name="title">Ficha del proveedor</x-slot>
    
    @livewire('ficha-del-proveedor2')

</x-layout2>