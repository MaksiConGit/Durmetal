<x-layout>

    <x-slot name="title">Otros Egresos</x-slot>
    <x-slot name="breadcrumbs">
        <li class="nav-home">
            <a href="#"><i class="fas fa-money-bill-wave"></i></a>
            </li>
            <li class="separator"><i class="icon-arrow-right"></i></li>
            <li class="nav-item"><a href="#">Listado de Otros Egresos entre Fechas</a></li>            
    </x-slot>

    @livewire('listado-entre-fechas')

</x-layout>
