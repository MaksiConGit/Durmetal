<x-layout2>

    <x-slot name="title">Orden de Trabajo</x-slot>

    <x-simple-table2>

        <x-slot name="filtros">

            <div class="row mb-2 align-items-end">

                <div class="col-2">
                    <div class="form-group mb-1">
                        <label for="PuntoVenta" class="form-label mb-1" style="font-size: 0.8rem;">PUNTO DE VENTA</label>
                        <select name="PuntoVenta" id="PuntoVenta" class="form-control form-control-sm py-0">
                            @foreach ($pto_ventas as $pto_venta)
                                <option value="{{ $pto_venta->id }}" {{$pto_venta->id == $orden_trabajo->PuntoVenta ? 'selected' : ''}}>
                                    {{ $pto_venta->Nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-2">
                    <div class="form-group mb-1">
                        <label for="Numero" class="form-label mb-1" style="font-size: 0.8rem;">NUMERO</label>
                        <input type="text" id="Numero"
                            value="{{ $orden_trabajo->Numero }}"
                            class="form-control form-control-sm py-0" disabled>
                    </div>
                </div>

                <div class="col-2 d-flex flex-column justify-content-end">
                    <div class="bg-info text-white d-flex justify-content-center align-items-center mx-auto" 
                        style="width: 3rem; height: 3rem; font-weight: bold;">
                        OT
                    </div>
                </div>

                <div class="col-2">
                    <div class="form-group mb-1">
                        <label for="FechaEmision" class="form-label mb-1" style="font-size: 0.8rem;">FECHA</label>
                        <input type="date" id="FechaEmision" name="FechaEmision"
                            value="{{ $orden_trabajo->FechaEmision }}"
                            class="form-control form-control-sm py-0">
                    </div>
                </div>

            </div>

            <div class="row mb-2 align-items-end">

                <div class="col-2">
                    <div class="form-group mb-1">
                        <label for="filtro1" class="form-label mb-1" style="font-size: 0.8rem;">CODIGO CLIENTE</label>
                        <input value="{{ $orden_trabajo->IdCliente }}" class="form-control form-control-sm py-0" disabled>
                    </div>
                </div>

                <div class="col-2">
                    <div class="form-group mb-1">
                        <label for="Numero" class="form-label mb-1" style="font-size: 0.8rem;">NOMBRE</label>
                        <input type="text" id="Numero" name="Numero"
                            value="{{ $orden_trabajo->RazonSocial }}"
                            class="form-control form-control-sm py-0" disabled>
                    </div>
                </div>

            </div>
                
            </div>

        </x-slot>

        <x-slot name="thead"></x-slot>

        <x-slot name="tbody">
            <div class="d-flex justify-content-center py-5">

<a href="#"
   onclick="mostrarMenuImpresion(event, {{ $orden_trabajo->id }})"
   class="position-relative text-center mx-5"
   style="cursor: pointer; text-decoration: none; color: inherit;">

    <div style="
        position: absolute;
        top: -10px;
        left: -10px;
        background: #007bff;
        color: white;
        padding: 6px 10px;
        border-radius: 50%;
        font-size: 1.2rem;
        font-weight: bold;
        min-width: 40px;
        text-align: center;
    ">
        {{ $orden_trabajo->CantidadImpresiones }}
    </div>

    <img src="{{ asset('AdminLTE-3.2.0/dist/img/impresora.png') }}" style="width: 90px;">
    <div class="mt-2" style="font-size: 1rem;">Enviar a impresora</div>
</a>

<a href="#"
   onclick="mostrarMenuCorreo(event)"
   class="position-relative text-center mx-5"
   style="cursor: pointer; text-decoration: none; color: inherit;">

    <div style="
        position: absolute;
        top: -10px;
        left: -10px;
        background: #dc3545;
        color: white;
        padding: 6px 10px;
        border-radius: 50%;
        font-size: 1.2rem;
        font-weight: bold;
        min-width: 40px;
        text-align: center;
    ">
        {{ $orden_trabajo->CantidadEnviosPorCorreo }}
    </div>

    <img src="{{ asset('AdminLTE-3.2.0/dist/img/correo.png') }}" style="width: 90px;">
    <div class="mt-2" style="font-size: 1rem;">Enviar por correo</div>

</a>

            </div>

        </x-slot>

    </x-simple-table2>

    <!-- .modal -->
    <div class="modal fade" id="modal-email" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title text-bold">
                    ENVIAR POR EMAIL
                </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                <div class="row">

                    <x-simple-table2>

                        <x-slot name="thead">
                            <tr>
                                <th></th>
                                <th>EMAIL</th>
                            </tr>
                        </x-slot>
                        <x-slot name="tbody">
                            @forelse ($orden_trabajo->cliente->emails as $email)
                                <tr>
                                    <td>
                                    <input type="checkbox"
                                        name="emails[]"
                                        value="{{ $email->id }}"
                                        checked>
                                    </td>
                                    <td>{{ $email->Email }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="2">No se encontraron resultados.</td></tr>
                            @endforelse

                        </x-slot>
                    </x-simple-table2>
                    </div>
                    </div>

                </div>

                </div>

                <div class="modal-footer justify-content-end">

<a class="btn btn-sidebar btn-sm bg-orange"
href="#"
onclick="

const ids = Array.from(
    document.querySelectorAll('#modal-email input[name=&quot;emails[]&quot;]:checked')
).map(e => e.value);

const qs = new URLSearchParams({
    Emails: ids.join(',')
});

const baseUrl = rutasCorreo[tipoCorreoSeleccionado];
const separator = baseUrl.includes('?') ? '&' : '?';
const url = baseUrl + separator + qs.toString();

window.location.href = url;

$('#modal-email').modal('hide');

setTimeout(() => location.reload(), 500);

">
    <span class="text-white">Aceptar</span>
    <i class="fas fa-check fa-fw text-white ml-2"></i>
</a>

                    <button class="btn btn-sidebar btn-sm bg-orange" data-dismiss="modal">
                        <span class="text-white">Cerrar</span>
                        <i class="fas fa-xmark fa-fw text-white ml-2"></i>
                    </button>

                </div>
                </div>
                </div>

    </div>
    <!-- /.modal -->

    <div class="container-fluid px-4 py-3">
        <div class="row">
            <div class="col-12 d-flex justify-content-end">
                <a class="btn btn-sm btn-primary" href="{{ route('orden-trabajo.edit', $orden_trabajo) }}">
                    <i class="bi bi-x-circle"></i> Salir
                </a>
            </div>
        </div>
    </div>
<div id="menu-impresion" class="menu-desplegable" style="
    display:none;
    position:fixed;   /* 🔥 CAMBIO ACÁ */
    background:white;
    border:1px solid #ccc;
    border-radius:8px;
    box-shadow:0 4px 10px rgba(0,0,0,0.15);
    padding:8px;
    z-index:9999;
    min-width:180px;
">

    <div class="opcion" onclick="seleccionarOpcion('orden')">Orden de trabajo</div>
    <div class="opcion" onclick="seleccionarOpcion('historial')">Historial de trabajos</div>
    <div class="opcion" onclick="seleccionarOpcion('tarjetas')">Tarjetas de materiales</div>

</div>

<div id="menu-correo" class="menu-desplegable" style="
    display:none;
    position:fixed;
    background:white;
    border:1px solid #ccc;
    border-radius:8px;
    box-shadow:0 4px 10px rgba(0,0,0,0.15);
    padding:8px;
    z-index:9999;
    min-width:180px;
">

    <div class="opcion" onclick="seleccionarCorreo('orden')">Orden de trabajo</div>
    <div class="opcion" onclick="seleccionarCorreo('historial')">Historial de trabajos</div>

</div>

<style>
.menu-desplegable {
    display:none;
    position:fixed;
    background:white;
    border:1px solid #ccc;
    border-radius:8px;
    box-shadow:0 4px 10px rgba(0,0,0,0.15);
    padding:8px;
    z-index:9999;
    min-width:180px;
}

.menu-desplegable .opcion{
    padding:8px 15px;
    cursor:pointer;
    border-radius:6px;
}

.menu-desplegable .opcion:hover{
    background:#f2f2f2;
}
</style>

<script>

const rutasImpresion = {
    orden: "{{ route('orden-trabajo.ordenPDF', $orden_trabajo) }}",
    historial: "{{ route('orden-trabajo.historialPDF', $orden_trabajo) }}",
    tarjetas: "{{ route('orden-trabajo.tarjetasPDF', $orden_trabajo) }}"
};

const rutasCorreo = {
    orden: "{{ route('orden-trabajo.ordenMail', $orden_trabajo) }}",
    historial: "{{ route('orden-trabajo.historialMail', $orden_trabajo) }}",
};

</script>

<script>
let tipoCorreoSeleccionado = null;
const menuImpresion = document.getElementById("menu-impresion");
const menuCorreo = document.getElementById("menu-correo");

function cerrarTodos() {
    menuImpresion.style.display = "none";
    menuCorreo.style.display = "none";
}

// 🔵 ABRIR IMPRESIÓN
function mostrarMenuImpresion(event) {

    event.preventDefault();
    event.stopPropagation();

    cerrarTodos(); // 🔥 cierra el otro

    menuImpresion.style.display = "block";
    menuImpresion.style.left = event.pageX + "px";
    menuImpresion.style.top = event.pageY + "px";
}

// 🔵 ABRIR CORREO
function mostrarMenuCorreo(event) {

    event.preventDefault();
    event.stopPropagation();

    cerrarTodos(); // 🔥 cierra el otro

    menuCorreo.style.display = "block";
    menuCorreo.style.left = event.pageX + "px";
    menuCorreo.style.top = event.pageY + "px";
}

// 🟢 SELECCIONAR IMPRESIÓN
function seleccionarOpcion(tipo) {

    cerrarTodos();

    const url = rutasImpresion[tipo];
    window.open(url, "_blank");

    setTimeout(() => location.reload(), 500);
}

// 🟢 SELECCIONAR CORREO
function seleccionarCorreo(tipo) {

    cerrarTodos();

    tipoCorreoSeleccionado = tipo; // 🔥 orden o historial

    $('#modal-email').modal('show'); // 🔥 SIEMPRE abre modal
}

// 🔴 NO cerrar si clic dentro
menuImpresion.addEventListener("click", e => e.stopPropagation());
menuCorreo.addEventListener("click", e => e.stopPropagation());

// ⚫ Cerrar si clic afuera
document.addEventListener("click", cerrarTodos);

</script>
</x-layout2>