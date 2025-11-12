@if ($filtro == "trabajos_pendientes_nota_envio")
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            $('#modal-create').modal('show');
        });
    </script>
@endif

@livewire('ficha-del-cliente-show2', ['cliente' => $cliente, 'filtro' => $filtro])

<form action="{{ route('ventas.divisas.update', [\App\Models\ConfiguracionGlobal::first(), $cliente]) }}" method="POST">
    @csrf
    @method('PUT')

    <!-- .modal -->
    <div class="modal fade" id="modal-create">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                    PARAMETROS NOTA DE ENVIO
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="row">

                        <input type="hidden" name="Pendientes" value="0">

                        <div class="col-6">
                            <div class="form-check">
                                <input id="Pendientes" type="checkbox" name="Pendientes" value="1" class="form-check-input">
                                <div>
                                    <label for="Pendientes" class="form-check-label">FACTURAR TRABAJOS SIN APROBACION</label>
                                </div>

                            </div>
                        </div>

                    </div>

                </div>

                <div class="modal-footer justify-content-end">

                    <a class="btn btn-sidebar btn-sm bg-orange" data-dismiss="modal" data-toggle="modal" data-target="#modal-divisas-1">
                        <span class="text-white">Aceptar</span>
                        <i class="fas fa-check fa-fw text-white ml-2"></i>
                    </a>

                    <a class="btn btn-sidebar btn-sm bg-orange" data-dismiss="modal">
                        <span class="text-white">Cancelar</span>
                        <i class="fas fa-xmark fa-fw text-white ml-2"></i>
                    </a>

                </div>

            </div>
        </div>
    </div>
    <!-- /.modal -->

    <!-- .modal -->
    <div class="modal fade" id="modal-divisas-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title">DIVISAS</h4>
                <button type="button" class="close" data-dismiss="modal">
                <span>&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-6">
                        <label>USD -> ARS</label>
                        <input type="number" step="0.01" name="USD_ARS" 
                        value="{{ number_format(\App\Models\ConfiguracionGlobal::first()->USD_ARS, 2, '.', '') }}"
                            class="form-control form-control-sm">
                    </div>

                    <input type="hidden" name="IdCliente" value="{{ $cliente->id }}">

                    <div class="col-6">
                        <label>Fecha de actualización</label>
                        <input type="date" readonly 
                            value="{{ \App\Models\ConfiguracionGlobal::first()->FechaActualizacionUSD_ARS }}" 
                            class="form-control form-control-sm">
                        <input type="hidden" name="FechaActualizacionUSD_ARS" 
                            value="{{ \App\Models\ConfiguracionGlobal::first()->FechaActualizacionUSD_ARS }}">
                    </div>
                </div>
            </div>

            <div class="modal-footer justify-content-end">
                <button type="submit" class="btn btn-sidebar btn-sm bg-orange">
                    <span class="text-white">Guardar</span>
                    <i class="fas fa-floppy-disk fa-fw text-white ml-2"></i>
                </button>

                <a href="#" 
                id="cancelar-btn"
                class="btn btn-sidebar btn-sm bg-orange">
                <span class="text-white">Cancelar</span>
                <i class="fas fa-xmark fa-fw text-white ml-2"></i>
                </a>
            </div>

            </div>
        </div>
    </div>
    <!-- /.modal -->
</form>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const cancelarBtn = document.getElementById('cancelar-btn');
        const pendientesInput = document.getElementById('Pendientes');
        const clienteId = "{{ $cliente->id }}";

        cancelarBtn.addEventListener('click', function (e) {
            e.preventDefault();

            const pendientes = pendientesInput.checked ? 1 : 0;

            window.location.href = `/ficha-del-cliente/nota-envio/create/${clienteId}?pendientes=${pendientes}`;
        });
    });
</script>