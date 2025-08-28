<x-layout2-sidebar>

    <x-slot name="title">Valorizar trabajos</x-slot>

    <x-slot name="filtros">

        <div class="form-inline mt-5">

            <div class="form-group w-100 mb-3">
                
                <label for="sidebarSearch" class="form-label text-muted small">
                    COD. CLIENTE
                </label>
                
                <div class="input-group" data-widget="sidebar-search">
                    <input id="sidebarSearch" 
                        class="form-control form-control-sm bg-white text-dark" 
                        type="search" placeholder="0" aria-label="Search">
                    <div class="input-group-append">
                    <button class="btn btn-sidebar btn-sm bg-orange">
                        <i class="fas fa-search fa-fw text-white"></i>
                    </button>
                    </div>
                </div>
                
            </div>

            <div class="form-group w-100 mb-3">
                
                <div class="input-group" data-widget="sidebar-search">
                    <input id="sidebarSearch" 
                        class="form-control form-control-sm bg-white text-dark" 
                        type="search" aria-label="Search" disabled>
                </div>
                
            </div>

            <div class="form-group w-100 mb-3">

                <label for="sidebarSearch" class="form-label text-muted small">
                    OTI
                </label>

                <div class="input-group" data-widget="sidebar-search">

                    <input id="sidebarSearch" 
                        class="form-control form-control-sm bg-white text-dark" 
                        type="search" aria-label="Search">

                    <div class="input-group-append ml-2">

                    <input id="sidebarSearch" 
                        class="form-control form-control-sm bg-white text-dark" 
                        type="search" aria-label="Search">

                    </div>

                </div>
                
            </div>

            <div class="form-group w-100 mb-3">
                <button class="btn btn-sidebar btn-sm bg-orange w-100">
                    <span class="text-white">Buscar</span>
                    <i class="fas fa-search fa-fw text-white"></i>
                </button>
            </div>

        </div>

    </x-slot>

    @livewire('valorizar-trabajos2')

</x-layout2-sidebar>