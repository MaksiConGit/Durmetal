<x-layout>
    <x-slot name="title">Producción</x-slot>
    <x-slot name="breadcrumbs">
        <li class="nav-home">
            <a href="#"><i class="fas fa-cogs"></i></a>
        </li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="#">Programación</a></li>
    </x-slot>

    @livewire('filtro-por-checkbox', [
        'tratamientos' => $tratamientos,
        'items_orden_trabajo' => $items_orden_trabajo
    ])
</x-layout>