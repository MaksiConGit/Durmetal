<x-layout>
    <x-slot name="title">Ventas</x-slot>
    <x-slot name="breadcrumbs">
        <li class="nav-home">
            <a href="#"><i class="fas fa-dollar-sign"></i></a>
        </li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="#">Ficha del Cliente</a></li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="#">Ver</a></li>
    </x-slot>

    @livewire('listado-i-v-a')
    
    
</x-layout>