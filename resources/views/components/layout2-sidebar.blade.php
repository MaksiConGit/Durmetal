<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ $title }}</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{asset('AdminLTE-3.2.0/plugins/fontawesome-free/css/all.min.css')}}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="{{asset('AdminLTE-3.2.0/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('AdminLTE-3.2.0/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('AdminLTE-3.2.0/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('AdminLTE-3.2.0/dist/css/adminlte.min.css')}}">
  <link rel="stylesheet" href="{{asset('AdminLTE-3.2.0/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')}}">
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">
<!-- Site wrapper -->
<div class="wrapper">
    <!-- Navbar -->
  <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
    <div class="container-fluid ml-3">
      <div class="collapse navbar-collapse order-3" id="navbarCollapse">
        <!-- Left navbar links -->
        <ul class="navbar-nav">

          <li class="nav-item dropdown">
            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle disabled">
              <i class="fas fa-cart-plus mr-1"></i> COMPRAS
            </a>
            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
              <li><a href="{{ route('compras.buscar-comprobantes.index') }}" class="dropdown-item">Buscar comprobantes</a></li>
              <li><a href="{{ route('compras.ficha-del-proveedor.index') }}" class="dropdown-item">Ficha del proveedor</a></li>
              <li><a href="{{ route('compras.listado-de-saldos-proveedores.index') }}" class="dropdown-item">Listado de saldos</a></li>
              <li><a href="{{ route('compras.listado-movimientos-por-cuentas-gastos.index') }}" class="dropdown-item">Listado de movimientos por cuentas de gastos</a></li>
              <li><a href="{{ route('compras.resumen-cuenta-corriente.index') }}" class="dropdown-item">Resumen de cuenta cte</a></li>
              <li><a href="{{ route('compras.resumen-mensual-egresos.index') }}" class="dropdown-item">Resumen mensual de egresos</a></li>
              <li><a href="{{ route('compras.listado-de-iva.index') }}" class="dropdown-item">Listado de IVA Compras</a></li>
              <li><a href="{{ route('compras.listado-de-cheques-proveedores.index') }}" class="dropdown-item">Listado de cheques a proveedores</a></li>

              <li class="dropdown-divider"></li>

              <!-- Level two dropdown-->
              <li class="dropdown-submenu dropdown-hover">
                <a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">Actualizaciones</a>
                <ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
                  <li>
                    <a tabindex="-1" href="{{ route('compras.actualizaciones.proveedores.index') }}" class="dropdown-item">Proveedores</a>
                  </li>
                  <li>
                    <a tabindex="-1" href="{{ route('compras.actualizaciones.cuentas-de-gastos.index') }}" class="dropdown-item">Cuentas de gastos</a>
                  </li>
                </ul>
              </li>
              <!-- End Level two -->
            </ul>
          </li>

          <li class="nav-item dropdown">
            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle disabled">
              <i class="fas fa-money-bill-wave mr-1"></i> OTROS EGRESOS
            </a>
            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
              <li><a href="{{ route('otros-egresos.otros-egresos.index') }}" class="dropdown-item">Otros egresos</a></li>
              <li><a href="{{ route('otros-egresos.listado-entre-fechas.index') }}" class="dropdown-item">Listado entre fechas</a></li>

              <!-- Level two dropdown-->
              <li class="dropdown-submenu dropdown-hover">
                <a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">Actualizaciones</a>
                <ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
                  <li>
                    <a tabindex="-1" href="{{ route('otros-egresos.actualizaciones.cuentas.index') }}" class="dropdown-item">Cuentas</a>
                  </li>
                </ul>
              </li>
              <!-- End Level two -->
            </ul>
          </li>


          <li class="nav-item dropdown dropdown-hover">
            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">
              <i class="fas fa-dollar-sign mr-1"></i> VENTAS
            </a>
            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
              <li><a href="{{ route('ventas.buscar-documentos') }}" class="dropdown-item">Buscar documentos</a></li>
              <li><a href="{{ route('ventas.ficha-del-cliente') }}" class="dropdown-item">Ficha del cliente</a></li>
              <li><a href="{{ route('ventas.listado-de-saldos') }}" class="dropdown-item">Listado de saldos</a></li>
              <li><a href="{{ route('ventas.resumen-cuenta-corriente') }}" class="dropdown-item">Resumen de cuenta cte</a></li>
              <li><a href="{{ route('ventas.listado-de-iva') }}" class="dropdown-item">Listado de IVA Ventas</a></li>
              <li><a href="{{ route('ventas.listado-de-cheques') }}" class="dropdown-item">Listado de cheques de clientes</a></li>
              <li><a href="{{ route('ventas.trabajos-sin-facturar') }}" class="dropdown-item">Listado de trabajos pendientes de facturar</a></li>
              <li><a href="{{ route('ventas.listado-de-retenciones') }}" class="dropdown-item">Listado de retenciones</a></li>
              <li><a href="{{ route('ventas.listado-de-precios') }}" class="dropdown-item">Listado de precios</a></li>
              <li><a href="{{ route('ventas.valorizar-trabajos') }}" class="dropdown-item">Valorizar trabajos</a></li>

              <li class="dropdown-divider"></li>

              <!-- Level two dropdown-->
              <li class="dropdown-submenu dropdown-hover">
                <a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">Actualizaciones</a>
                <ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
                  <li>
                    <a tabindex="-1" href="{{route('clients.index')}}" class="dropdown-item">Clientes</a>
                  </li>
                  <li>
                    <a tabindex="-1" href="{{ route('tratamientos.index') }}" class="dropdown-item disabled">Precios</a>
                  </li>
                  <li>
                    <a href="" tabindex="-1" data-toggle="modal" data-target="#modal-divisas" class="dropdown-item">Divisas</a>
                  </li>
                </ul>
              </li>
              <!-- End Level two -->
            </ul>
          </li>


          <li class="nav-item dropdown dropdown-hover">
            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">
              <i class="fas fa-cogs mr-1"></i> PRODUCCION
            </a>
            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
              <li><a href="" data-toggle="modal" data-target="#modal-ingreso-materiales" class="dropdown-item">Ingreso de materiales</a></li>
              <li><a href="{{ route('programacion.index') }}" class="dropdown-item">Programación</a></li>
              <li><a href="{{ route('ingreso-datos.index') }}" class="dropdown-item">Ingreso de datos</a></li>
              <li><a href="{{ route('cargas.index') }}" class="dropdown-item">Cargas</a></li>

              <li class="dropdown-divider"></li>

              <!-- Level two dropdown-->
              <li class="dropdown-submenu dropdown-hover">
                <a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle disabled">Reportes</a>
                <ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
                  <li>
                    <a tabindex="-1" href="{{ route('reportes.materiales') }}" class="dropdown-item disabled">Materiales</a>
                  </li>
                  <li>
                    <a tabindex="-1" href="{{ route('reportes.materiales-resumido') }}" class="dropdown-item disabled">Materiales resumido</a>
                  </li>
                  <li>
                    <a tabindex="-1" href="{{ route('reportes.materiales-resumido-excel') }}" class="dropdown-item disabled">Materiales resumido (Excel)</a>
                  </li>
                  <li>
                    <a tabindex="-1" href="{{ route('reportes.pesos') }}" class="dropdown-item disabled">Peso por trataminetos entre fechas</a>
                  </li>
                  <li>
                    <a tabindex="-1" href="{{ route('reportes.pesos-resumido') }}" class="dropdown-item disabled">Peso por tratamientos entre fechas resumido</a>
                  </li>
                  <li>
                    <a tabindex="-1" href="{{ route('reportes.trabajos-no-aptos') }}" class="dropdown-item disabled">Trabajos NO APTOS</a>
                  </li>
                  <li>
                    <a tabindex="-1" href="{{ route('reportes.premios') }}" class="dropdown-item disabled">Premios</a>
                  </li>
                  <li>
                    <a tabindex="-1" href="{{ route('reportes.premios-por-aprobacion') }}" class="dropdown-item disabled">Premios - Por fecha de aprobación</a>
                  </li>
                </ul>
              </li>

              <li class="dropdown-divider"></li>

              <!-- Level two dropdown-->
              <li class="dropdown-submenu dropdown-hover">
                <a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle disabled">Actualizaciones</a>
                <ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
                  <li>
                    <a tabindex="-1" href="{{ route('durezas.index') }}" class="dropdown-item disabled">Durezas</a>
                  </li>
                  <li>
                    <a tabindex="-1" href="{{ route('materiales.index') }}" class="dropdown-item disabled">Materiales</a>
                  </li>
                  <li>
                    <a tabindex="-1" href="{{ route('tratamientos.index') }}" class="dropdown-item disabled">Tratamientos</a>
                  </li>
                  <li>
                    <a tabindex="-1" href="{{ route('medios-enfriamiento.index') }}" class="dropdown-item disabled">Medios de enfriamiento</a>
                  </li>
                  <li>
                    <a tabindex="-1" href="{{ route('procesos.index') }}" class="dropdown-item disabled">Procesos</a>
                  </li>
                  <li>
                    <a tabindex="-1" href="{{ route('clients.index') }}" class="dropdown-item disabled">Clientes</a>
                  </li>
                  <li>
                    <a tabindex="-1" href="{{ route('factores-premio.index') }}" class="dropdown-item disabled">Factores Premio</a>
                  </li>
                  <li>
                    <a tabindex="-1" href="{{ route('asignar-factores.index') }}" class="dropdown-item disabled">Asignar factores</a>
                  </li>
                  <li>
                    <a tabindex="-1" href="{{ route('repartir-premios.index') }}" class="dropdown-item disabled">Repartir Premios</a>
                  </li>
                </ul>
              </li>
              <!-- End Level two -->
            </ul>
          </li>

          <li class="nav-item dropdown">
            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle disabled">
              <i class="fas fa-sliders-h mr-1"></i> SISTEMA
            </a>
            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">

              <!-- Level two dropdown-->
              <li class="dropdown-submenu dropdown-hover">
                <a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">Configuración</a>
                <ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
                  <li>
                    <a tabindex="-1" href="{{ route('sistema.configuracion.configuracion-global.index') }}" class="dropdown-item">Configuración global</a>
                  </li>
                  <li>
                    <a tabindex="-1" href="{{ route('sistema.configuracion.puntos-de-venta.index') }}" class="dropdown-item">Puntos de venta</a>
                  </li>
                  <li>
                    <a tabindex="-1" href="{{ route('sistema.configuracion.terminales.index') }}" class="dropdown-item">Terminales</a>
                  </li>
                  <li>
                    <a tabindex="-1" href="#" class="dropdown-item">Entornos</a>
                  </li>
                  <li>
                    <a tabindex="-1" href="{{ route('sistema.configuracion.impresoras-fiscales.index') }}" class="dropdown-item">Impresoras fiscales</a>
                  </li>
                  <li>
                    <a tabindex="-1" href="{{ route('sistema.configuracion.usuarios.index') }}" class="dropdown-item">Usuarios</a>
                  </li>
                  <li>
                    <a tabindex="-1" href="{{ route('sistema.configuracion.reglas.index') }}" class="dropdown-item">Reglas</a>
                  </li>
                  <li>
                    <a tabindex="-1" href="{{ route('sistema.configuracion.plantillas-de-email.index') }}" class="dropdown-item">Plantillas de email</a>
                  </li>
                  <li>
                    <a tabindex="-1" href="{{ route('sistema.configuracion.conversor-de-durezas.index') }}" class="dropdown-item">Conversor de Durezas</a>
                  </li>
                  <li>
                    <a tabindex="-1" href="{{ route('sistema.configuracion.plantillas-de-carga.index') }}" class="dropdown-item">Plantillas de Carga</a>
                  </li>
                  <li>
                    <a tabindex="-1" href="{ route('sistema.configuracion.condiciones-de-venta.index') }}" class="dropdown-item">Condiciones de venta</a>
                  </li>
                  <li>
                    <a tabindex="-1" href="{{ route('sistema.actualizaciones.tarjetas.index') }}" class="dropdown-item">Tarjetas</a>
                  </li>
                  <li>
                    <a tabindex="-1" href="{{ route('sistema.configuracion.tipos-de-mensajes.index') }}" class="dropdown-item">Tipos de mensajes</a>
                  </li>
                </ul>
              </li>

              <!-- Level two dropdown-->
              <li class="dropdown-submenu dropdown-hover">
                <a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">Mantenimiento</a>
                <ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
                  <li>
                    <a tabindex="-1" href="#" class="dropdown-item">Actualización de saldos</a>
                  </li>
                  <li>
                    <a tabindex="-1" href="#" class="dropdown-item">Revisar mensajes del sistema</a>
                  </li>
                </ul>
              </li>

              <!-- Level two dropdown-->
              <li class="dropdown-submenu dropdown-hover">
                <a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">Desarrollador</a>
                <ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
                  <li>
                    <a tabindex="-1" href="#" class="dropdown-item">Base de datos</a>
                  </li>
                  <li>
                    <a tabindex="-1" href="#" class="dropdown-item">Crear tablas</a>
                  </li>
                  <li>
                    <a tabindex="-1" href="#" class="dropdown-item">Consulta CAE</a>
                  </li>
                  <li>
                    <a tabindex="-1" href="#" class="dropdown-item">Consulta parámetros FE</a>
                  </li>
                  <li>
                    <a tabindex="-1" href="#" class="dropdown-item">Scripts</a>
                  </li>

                  <!-- Level three dropdown-->
                  <li class="dropdown-submenu">
                    <a id="dropdownSubMenu3" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">IF Epson</a>
                    <ul aria-labelledby="dropdownSubMenu3" class="dropdown-menu border-0 shadow">
                      <li><a href="#" class="dropdown-item">Test Info</a></li>
                      <li><a href="#" class="dropdown-item">Test Características</a></li>
                      <li><a href="#" class="dropdown-item">Test Contribuyente</a></li>
                    </ul>
                  </li>

                  <!-- Level three dropdown-->
                  <li class="dropdown-submenu">
                    <a id="dropdownSubMenu3" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">IF Hasar</a>
                    <ul aria-labelledby="dropdownSubMenu3" class="dropdown-menu border-0 shadow">
                      <li><a href="#" class="dropdown-item">Configuración</a></li>
                    </ul>
                  </li>

                  <!-- End Level three -->

                  <li>
                    <a tabindex="-1" href="#" class="dropdown-item">Scripts migraciones</a>
                  </li>

                </ul>
              </li>
              <!-- End Level two -->

              <li><a href="#" class="dropdown-item">Mensajes de usuario</a></li>

              <li class="dropdown-divider"></li>

              <!-- Level two dropdown-->
              <li class="dropdown-submenu dropdown-hover">
                <a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">Actualizaciones</a>
                <ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
                  <li>
                    <a tabindex="-1" href="{{ route('sistema.actualizaciones.bancos.index') }}" class="dropdown-item">Bancos</a>
                  </li>
                  <li>
                    <a tabindex="-1" href="{{ route('sistema.actualizaciones.tarjetas.index') }}" class="dropdown-item">Tarjetas</a>
                  </li>
                </ul>
              </li>

            </ul>
          </li>

        </ul>

      </div>

    </div>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-light-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('ventas.buscar-documentos') }}" class="brand-link">
      <img src="{{asset('template/assets/img/Fueguito-PNG.ico')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-dark">Durmetal</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

      {{ $filtros }}
      
    </div>
    <!-- /.sidebar -->
  </aside>

    <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-0"></div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">

            <div class="card">
              <div class="card-header bg-dark">
                <h3 class="card-title">{{ $title }}</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                {{ $slot }}
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

  <!-- .modal -->
  <div class="modal fade" id="modal-divisas">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">DIVISAS</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

              <div class="row">

                <div class="col-6">
                    <div class="form-group mb-0">
                        <label for="filtro1" class="font-weight-normal">USD -> ARS</label>
                        <input type="text" id="filtro1" name="filtro1" value="{{ \App\Models\ConfiguracionGlobal::first()->USD_ARS }}" wire:model.live="cliente_desde" class="form-control form-control-sm">
                    </div>
                </div>

                <div class="col-6">
                    <div class="form-group mb-0">
                        <label for="filtro1" class="font-weight-normal">FECHA DE ACTUALIZACION</label>
                        <input type="date" disabled id="filtro1" name="filtro1" value="{{ \App\Models\ConfiguracionGlobal::first()->FechaActualizacion }}" class="form-control form-control-sm">
                    </div>
                </div>

              </div>

              <div class="row mt-3">
                  <div class="col-12">
                      <div class="form-group mb-0">
                          <label for="filtro1" class="font-weight-normal text-muted small">
                              1 dólar estadounidense equivale a {{ \App\Models\ConfiguracionGlobal::first()->USD_ARS }}
                          </label>
                      </div>
                  </div>
              </div>

            </div>

            <div class="modal-footer justify-content-end">

                <button class="btn btn-sidebar btn-sm bg-orange" data-dismiss="modal">
                    <span class="text-white">Guardar</span>
                    <i class="fas fa-floppy-disk fa-fw text-white ml-2"></i>
                </button>

                <button class="btn btn-sidebar btn-sm bg-orange" data-dismiss="modal">
                    <span class="text-white">Cancelar</span>
                    <i class="fas fa-xmark fa-fw text-white ml-2"></i>
                </button>

            </div>

        </div>
    </div>
  </div>

  <!-- /.modal -->

  <!-- .modal -->
  <form action="{{ route('orden-trabajo.store') }}" method="POST">
    @csrf
    <div class="modal fade" id="modal-ingreso-materiales">
      <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">
                  INGRESO DE MATERIALES <br>
                  <small class="text-muted">SELECCION DE OT</small>
                </h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">

                <div class="row">

                  <div class="col-6">
                    <div class="form-group mb-0">
                        <label for="pto_venta_id" class="font-weight-normal">PUNTO DE VENTA</label>
                        <select name="pto_venta_id" id="pto_venta_id" class="form-control form-control-sm">
                          @foreach (\App\Models\PuntoDeVenta::all() as $pto_venta)
                            <option value="{{ $pto_venta->id }}">{{ $pto_venta->Nombre }}</option>    
                          @endforeach
                        </select>
                    </div>
                  </div>

                  <div class="col-6">
                      <div class="form-group mb-0">
                          <label for="Numero" class="font-weight-normal">NUMERO</label>
                          <input type="text" id="Numero" name="Numero" value="{{ \App\Models\OrdenTrabajo::max('Numero') + 1 }}" class="form-control form-control-sm">
                      </div>
                  </div>

                </div>

              </div>

              <div class="modal-footer justify-content-end">

                  <button class="btn btn-sidebar btn-sm bg-orange">
                      <span class="text-white">Aceptar</span>
                      <i class="fas fa-check fa-fw text-white ml-2"></i>
                  </button>

                  <button class="btn btn-sidebar btn-sm bg-orange" data-dismiss="modal">
                      <span class="text-white">Cancelar</span>
                      <i class="fas fa-xmark fa-fw text-white ml-2"></i>
                  </button>

              </div>

          </div>
      </div>
    </div>

  </form>
  <!-- /.modal -->

<!-- jQuery -->
<script src="{{asset('AdminLTE-3.2.0/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('AdminLTE-3.2.0/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('AdminLTE-3.2.0/dist/js/adminlte.min.js')}}"></script>
<!-- DataTables  & Plugins -->
<script src="{{asset('AdminLTE-3.2.0/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('AdminLTE-3.2.0/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('AdminLTE-3.2.0/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('AdminLTE-3.2.0/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{asset('AdminLTE-3.2.0/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('AdminLTE-3.2.0/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('AdminLTE-3.2.0/plugins/jszip/jszip.min.js')}}"></script>
<script src="{{asset('AdminLTE-3.2.0/plugins/pdfmake/pdfmake.min.js')}}"></script>
<script src="{{asset('AdminLTE-3.2.0/plugins/pdfmake/vfs_fonts.js')}}"></script>
<script src="{{asset('AdminLTE-3.2.0/plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('AdminLTE-3.2.0/plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{asset('AdminLTE-3.2.0/plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>
<script src="{{asset('AdminLTE-3.2.0/plugins/sweetalert2/sweetalert2.min.js')}}}"></script>
<!-- SweetAlert2 -->
<script src="{{asset('AdminLTE-3.2.0/plugins/sweetalert2/sweetalert2.min.js')}}"></script>
<!-- Toastr -->
<script src="{{asset('AdminLTE-3.2.0/plugins/toastr/toastr.min.js')}}"></script>

<!-- Page specific script -->
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>
@yield('js')

@livewireScripts
</body>
</html>
