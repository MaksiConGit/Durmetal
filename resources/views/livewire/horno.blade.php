<div>
    <x-slot name="title">
        Hornos
    </x-slot>

    <div class="row" wire:poll.10s>

        @for($i = 1; $i <= 6; $i++)

            @php
                $lista   = $programacionesPorHorno[$i] ?? collect();
                $indice  = $indiceActivo[$i] ?? 0;
                $prog    = $lista[$indice] ?? null;
                $total   = $lista->count();
            @endphp

            <div class="col-12 col-md-6 col-lg-4">

                @if($prog)
                    {{-- HORNO CON PROGRAMACIÓN --}}
                    <div class="card card-outline card-orange horno-card position-relative">

                        <div class="card-header border-0">
                            <div class="d-flex align-items-center w-100">
                                <span class="horno-title">H{{ $i }}</span>

                                <span class="horno-temp ml-auto">
                                    {{ $prog->medioEnfriamiento->Nombre }}
                                    {{ $prog->Temperatura }}°
                                </span>
                            </div>
                        </div>

                        <div class="px-3">
                            <div class="progress horno-progress">
                                @php $porcentaje = $this->progreso($prog); @endphp
                                <div class="progress-bar bg-success"
                                     style="width: {{ $porcentaje }}%">
                                </div>
                            </div>
                        </div>

                        <div class="d-flex align-items-center px-3 horno-fechas">
                            <span class="horno-fecha">
                                {{ \Carbon\Carbon::parse($prog->FechaCarga)->format('d/m/Y H:i') }}
                            </span>

                            <a class="horno-arrow mx-auto"
                               wire:click="cambiarProgramacion({{ $i }})"
                               style="cursor:pointer">
                                <i class="fas fa-arrow-right"></i>
                            </a>

                            <span class="horno-fecha">
                                {{ \Carbon\Carbon::parse($prog->FechaDescarga)->format('d/m/Y H:i') }}
                            </span>
                        </div>

                        @if($total > 1)
                            <div class="text-center text-muted small">
                                {{ $indice + 1 }} / {{ $total }}
                            </div>
                        @endif

                        <div class="card-body pt-2">
                            <table class="table table-sm table-borderless horno-table">
                                <thead>
                                    <tr>
                                        <th>CLI</th>
                                        <th>OTI</th>
                                        <th>DESCRIPCIÓN</th>
                                        <th>MAT</th>
                                        <th>PROG</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr wire:click="abrirOrden({{ $prog->itemOrdenTrabajo->ordenTrabajo->Numero }})"
                                        style="cursor:pointer;">
                                        
                                        <td>{{ $prog->itemOrdenTrabajo->ordenTrabajo->cliente->id }}</td>

                                        <td>
                                            {{ $prog->itemOrdenTrabajo->ordenTrabajo->Numero }}
                                            / {{ $prog->itemOrdenTrabajo->ItemNumero }}
                                        </td>

                                        <td>{{ $prog->itemOrdenTrabajo->Descripcion }}</td>

                                        <td>{{ $prog->itemOrdenTrabajo->material->Nombre }}</td>

                                        <td>{{ $prog->tipoProgramacion->Nombre }}</td>

                                    </tr>
                                </tbody>
                            </table>

                            <div class="horno-separador"></div>
                        </div>
                        <div class="horno-overlay d-none">
                            <div class="horno-spinner"></div>
                        </div>

                        {{-- BOTÓN REFRESH --}}
                        <button type="button"
                                class="btn btn-sm btn-light horno-refresh"
                                onclick="recargarHorno(this)">
                            <i class="fas fa-sync-alt"></i>
                        </button>

                    </div>

                @else
                    {{-- HORNO VACÍO --}}
                    <div class="card card-outline card-orange horno-card horno-empty position-relative">
                        <div class="card-header border-0">
                            <span class="horno-title">H{{ $i }}</span>
                        </div>

                        <div class="horno-placeholder">
                            <div class="horno-square"></div>
                        </div>
                        <div class="horno-overlay d-none">
                            <div class="horno-spinner"></div>
                        </div>
                        {{-- BOTÓN REFRESH --}}
                        <button type="button"
                                class="btn btn-sm btn-light horno-refresh"
                                onclick="recargarHorno(this)">
                            <i class="fas fa-sync-alt"></i>
                        </button>
                    </div>
                @endif

            </div>

        @endfor

    </div>
</div>
