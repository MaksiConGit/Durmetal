<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Durmetal</title>
    <meta
      content="width=device-width, initial-scale=1.0, shrink-to-fit=no"
      name="viewport"
    />
    <link
      rel="icon"
      href="{{asset('template/assets/img/Fueguito-PNG.ico')}}"
      type="image/x-icon"
    />

    <!-- Fonts and icons -->
    <script src="{{ asset('template/assets/js/plugin/webfont/webfont.min.js') }}"></script>
    <script>
      WebFont.load({
        google: { families: ["Public Sans:300,400,500,600,700"] },
        custom: {
          families: [
            "Font Awesome 5 Solid",
            "Font Awesome 5 Regular",
            "Font Awesome 5 Brands",
            "simple-line-icons",
          ],
          urls: ["{{ asset('template/assets/css/fonts.min.css') }}"],
        },
        active: function () {
          sessionStorage.fonts = true;
        },
      });
    </script>    

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{asset('template/assets/css/bootstrap.min.css')}}" />
    <link rel="stylesheet" href="{{asset('template/assets/css/plugins.min.css')}}" />
    <link rel="stylesheet" href="{{asset('template/assets/css/kaiadmin.min.css')}}" />

    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link rel="stylesheet" href="{{asset('template/assets/css/demo.css')}}" />
    @yield('css')
    @livewireStyles
  </head>
  <body>
    <div class="wrapper">
      <!-- Sidebar -->
      <div class="sidebar" data-background-color="dark">
        <div class="sidebar-logo">
          <!-- Logo Header -->
          <div class="logo-header" data-background-color="dark">
            <a href="{{ route('index') }}" class="logo">
              <img
                src="{{asset('template/assets/img/Durmetal PNG.png')}}"
                alt="navbar brand"
                class="navbar-brand"
                height="120"
              />
            </a>
            <div class="nav-toggle">
              <button class="btn btn-toggle toggle-sidebar">
                <i class="gg-menu-right"></i>
              </button>
              <button class="btn btn-toggle sidenav-toggler">
                <i class="gg-menu-left"></i>
              </button>
            </div>
            <button class="topbar-toggler more">
              <i class="gg-more-vertical-alt"></i>
            </button>
          </div>
          <!-- End Logo Header -->
        </div>
        <div class="sidebar-wrapper scrollbar scrollbar-inner">
          <div class="sidebar-content">
            <ul class="nav nav-secondary">
              <li class="nav-item active">
                <a
                  data-bs-toggle="collapse"
                  href="#dashboard"
                  class="collapsed"
                  aria-expanded="false"
                >
                  <i class="fas fa-layer-group"></i>
                  <p>Tableros</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="dashboard">
                  <ul class="nav nav-collapse">
                    <li>
                      <a href="#">
                        <span class="sub-item">Vacío</span>
                      </a>
                    </li>
                    <li>
                      <a href="/">
                        <span class="sub-item">Hornos</span>
                      </a>
                    </li>
                    <li>
                      <a href="#">
                        <span class="sub-item">Producción</span>
                      </a>
                    </li>
                    <li>
                      <a href="#">
                        <span class="sub-item">Mensajes</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </li>
              <li class="nav-section">
                <span class="sidebar-mini-icon">
                  <i class="fa fa-ellipsis-h"></i>
                </span>
                <h4 class="text-section">Componentes</h4>
              </li>
              <li class="nav-item">
                <a data-bs-toggle="collapse" href="#base">
                  <i class="fas fa-cart-plus"></i>
                  <p>Compras</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="base">
                  <ul class="nav nav-collapse">
                    <li>
                      <a href="#">
                        <span class="sub-item">Buscar comprobantes</span>
                      </a>
                    </li>
                    <li>
                      <a href="#">
                        <span class="sub-item">Ficha del proveedor</span>
                      </a>
                    </li>
                    <li>
                      <a href="#">
                        <span class="sub-item">Listado de saldos</span>
                      </a>
                    </li>
                    <li>
                      <a href="#">
                        <span class="sub-item">Listado de movimientos por cuentas de gastos</span>
                      </a>
                    </li>
                    <li>
                      <a href="#">
                        <span class="sub-item">Resumen de cuenta cte</span>
                      </a>
                    </li>
                    <li>
                      <a href="#">
                        <span class="sub-item">Resumen mensual de egresos</span>
                      </a>
                    </li>
                    <li>
                      <a href="#">
                        <span class="sub-item">Listado de IVA Compras</span>
                      </a>
                    </li>
                    <li>
                      <a href="#">
                        <span class="sub-item">Listado de cheques a proveedores</span>
                      </a>
                    </li>
                    <li>
                      <a data-bs-toggle="collapse" href="#subnavcompras">
                        <span class="sub-item">Actualizaciones</span>
                        <span class="caret"></span>
                      </a>
                      <div class="collapse" id="subnavcompras">
                        <ul class="nav nav-collapse subnav">
                          <li>
                            <a href="#">
                              <span class="sub-item">Proveedores</span>
                            </a>
                          </li>
                          <li>
                            <a href="#">
                              <span class="sub-item">Cuentas de gastos</span>
                            </a>
                          </li>
                        </ul>
                      </div>
                    </li>
                  </ul>
                </div>
              </li>
              <li class="nav-item">
                <a data-bs-toggle="collapse" href="#sidebarLayouts">
                  <i class="fas fa-money-bill-wave"></i>
                  <p>Otros egresos</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="sidebarLayouts">
                  <ul class="nav nav-collapse">
                    <li>
                      <a href="sidebar-style-2.html">
                        <span class="sub-item">Listado entre fechas</span>
                      </a>
                    </li>
                    <li>
                      <a data-bs-toggle="collapse" href="#subnavotrosegresos">
                        <span class="sub-item">Actualizaciones</span>
                        <span class="caret"></span>
                      </a>
                      <div class="collapse" id="subnavotrosegresos">
                        <ul class="nav nav-collapse subnav">
                          <li>
                            <a href="#">
                              <span class="sub-item">Cuentas</span>
                            </a>
                          </li>
                        </ul>
                      </div>
                    </li>
                  </ul>
                </div>
              </li>
              <li class="nav-item">
                <a data-bs-toggle="collapse" href="#forms">
                  <i class="fas fa-dollar-sign"></i>
                  <p>Ventas</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="forms">
                  <ul class="nav nav-collapse">
                    <li>
                      <a href="#">
                        <span class="sub-item">Buscar documentos</span>
                      </a>
                    </li>
                    <li>
                      <a href="#">
                        <span class="sub-item">Ficha del cliente</span>
                      </a>
                    </li>
                    <li>
                      <a href="#">
                        <span class="sub-item">Listado de saldos</span>
                      </a>
                    </li>
                    <li>
                      <a href="#">
                        <span class="sub-item">Resumen de cuenta cte</span>
                      </a>
                    </li>
                    <li>
                      <a href="#-icons.html">
                        <span class="sub-item">Listado de IVA Ventas</span>
                      </a>
                    </li>
                    <li>
                      <a href="#-icons.html">
                        <span class="sub-item">Listado de cheques a clientes</span>
                      </a>
                    </li>
                    <li>
                      <a href="#-icons.html">
                        <span class="sub-item">Listado de trabajos pendientes a facturar</span>
                      </a>
                    </li>
                    <li>
                      <a href="#-icons.html">
                        <span class="sub-item">Listado de retenciones</span>
                      </a>
                    </li>
                    <li>
                      <a href="#-icons.html">
                        <span class="sub-item">Listado de precios</span>
                      </a>
                    </li>
                    <li>
                      <a href="#-icons.html">
                        <span class="sub-item">Valorizar trabajos</span>
                      </a>
                    </li>
                    <li>
                      <a data-bs-toggle="collapse" href="#subnavventas">
                        <span class="sub-item">Actualizaciones</span>
                        <span class="caret"></span>
                      </a>
                      <div class="collapse" id="subnavventas">
                        <ul class="nav nav-collapse subnav">
                          <li>
                            <a href="{{route('clients.index')}}">
                              <span class="sub-item">Clientes</span>
                            </a>
                          </li>
                          <li>
                            <a href="#">
                              <span class="sub-item">Precios</span>
                            </a>
                          </li>
                          <li>
                            <a href="#">
                              <span class="sub-item">Divisas</span>
                            </a>
                          </li>
                        </ul>
                      </div>
                    </li>
                  </ul>
                </div>
              </li>
              <li class="nav-item">
                <a data-bs-toggle="collapse" href="#tables">
                  <i class="fas fa-cogs"></i>
                  <p>Producción</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="tables">
                  <ul class="nav nav-collapse">
                    <li>
                      <a href="{{ route('orden-trabajo.create') }}">
                        <span class="sub-item">Ingreso de materiales</span>
                      </a>
                    </li>
                    <li>
                      <a href="{{ route('programacion.index') }}">
                        <span class="sub-item">Programación</span>
                      </a>
                    </li>
                    <li>
                      <a href="tables/datatables.html">
                        <span class="sub-item">Ingreso de datos</span>
                      </a>
                    </li>
                    <li>
                      <a href="{{ route('cargas.index') }}">
                        <span class="sub-item">Cargas</span>
                      </a>
                    </li>
                    <li>
                      <a data-bs-toggle="collapse" href="#subnavproduccion1">
                        <span class="sub-item">Reportes</span>
                        <span class="caret"></span>
                      </a>
                      <div class="collapse" id="subnavproduccion1">
                        <ul class="nav nav-collapse subnav">
                          <li>
                            <a href="{{ route('reportes.materiales') }}">
                              <span class="sub-item">Materiales</span>
                            </a>
                          </li>
                          <li>
                            <a href="{{ route('reportes.materiales-resumido') }}">
                              <span class="sub-item">Materiales resumido</span>
                            </a>
                          </li>
                          <li>
                            <a href="{{ route('reportes.materiales-resumido-excel') }}">
                              <span class="sub-item">Materiales resumido (Excel)</span>
                            </a>
                          </li>
                          <li>
                            <a href="{{ route('reportes.pesos') }}">
                              <span class="sub-item">Peso por tratamientos entre fechas</span>
                            </a>
                          </li>
                          <li>
                            <a href="#">
                              <span class="sub-item">Peso por tratamientos entre fechas resumido</span>
                            </a>
                          </li>
                          <li>
                            <a href="#">
                              <span class="sub-item">Trabajos NO APTOS</span>
                            </a>
                          </li>
                          <li>
                            <a href="#">
                              <span class="sub-item">Premios</span>
                            </a>
                          </li>
                          <li>
                            <a href="#">
                              <span class="sub-item">Premios - Por fecha de aprobación</span>
                            </a>
                          </li>
                        </ul>
                      </div>
                    </li>
                    <li>
                      <a data-bs-toggle="collapse" href="#subnavproduccion2">
                        <span class="sub-item">Actualizaciones</span>
                        <span class="caret"></span>
                      </a>
                      <div class="collapse" id="subnavproduccion2">
                        <ul class="nav nav-collapse subnav">
                          <li>
                            <a href="{{ route('durezas.index') }}">
                              <span class="sub-item">Durezas</span>
                            </a>
                          </li>
                          <li>
                            <a href="{{ route('materiales.index') }}">
                              <span class="sub-item">Materiales</span>
                            </a>
                          </li>
                          <li>
                            <a href="{{ route('tratamientos.index') }}">
                              <span class="sub-item">Tratamientos</span>
                            </a>
                          </li>
                          <li>
                            <a href="{{ route('medios-enfriamiento.index') }}">
                              <span class="sub-item">Medios de enfriamiento</span>
                            </a>
                          </li>
                          <li>
                            <a href="{{ route('procesos.index') }}">
                              <span class="sub-item">Procesos</span>
                            </a>
                          </li>
                          <li>
                            <a href="{{ route('clients.index') }}">
                              <span class="sub-item">Clientes</span>
                            </a>
                          </li>
                          <li>
                            <a href="{{ route('factores-premio.index') }}">
                              <span class="sub-item">Factores Premio</span>
                            </a>
                          </li>
                          <li>
                            <a href="{{ route('asignar-factores.index') }}">
                              <span class="sub-item">Asignar factores</span>
                            </a>
                          </li>
                          <li>
                            <a href="{{ route('repartir-premios.index') }}">
                              <span class="sub-item">Repartir Premios</span>
                            </a>
                          </li>
                        </ul>
                      </div>
                    </li>
                  </ul>
                </div>
              </li>
              <li class="nav-item">
                <a data-bs-toggle="collapse" href="#maps">
                  <i class="fas fa-sliders-h"></i>
                  <p>Sistema</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="maps">
                  <ul class="nav nav-collapse">
                    <li>
                      <a data-bs-toggle="collapse" href="#subnavsistema1">
                        <span class="sub-item">Configuración</span>
                        <span class="caret"></span>
                      </a>
                      <div class="collapse" id="subnavsistema1">
                        <ul class="nav nav-collapse subnav">
                          <li>
                            <a href="#">
                              <span class="sub-item">Configuración global</span>
                            </a>
                          </li>
                          <li>
                            <a href="#">
                              <span class="sub-item">Puntos de venta</span>
                            </a>
                          </li>
                          <li>
                            <a href="#">
                              <span class="sub-item">Terminales</span>
                            </a>
                          </li>
                          <li>
                            <a href="#">
                              <span class="sub-item">Entornos</span>
                            </a>
                          </li>
                          <li>
                            <a href="#">
                              <span class="sub-item">Impresoras fiscales</span>
                            </a>
                          </li>
                          <li>
                            <a href="#">
                              <span class="sub-item">Usuarios</span>
                            </a>
                          </li>
                          <li>
                            <a href="#">
                              <span class="sub-item">Reglas</span>
                            </a>
                          </li>
                          <li>
                            <a href="#">
                              <span class="sub-item">Plantillas de email</span>
                            </a>
                          </li>
                          <li>
                            <a href="#">
                              <span class="sub-item">Conversor de Durezas</span>
                            </a>
                          </li>
                          <li>
                            <a href="#">
                              <span class="sub-item">Plantillas de Carga</span>
                            </a>
                          </li>
                          <li>
                            <a href="#">
                              <span class="sub-item">Condiciones de venta</span>
                            </a>
                          </li>
                          <li>
                            <a href="#">
                              <span class="sub-item">Tarjetas</span>
                            </a>
                          </li>
                          <li>
                            <a href="#">
                              <span class="sub-item">Tipos de mensajes</span>
                            </a>
                          </li>
                        </ul>
                      </div>
                    </li>
                    <li>
                      <a data-bs-toggle="collapse" href="#subnavsistema2">
                        <span class="sub-item">Mantenimiento</span>
                        <span class="caret"></span>
                      </a>
                      <div class="collapse" id="subnavsistema2">
                        <ul class="nav nav-collapse subnav">
                          <li>
                            <a href="#">
                              <span class="sub-item">Actualización de saldos</span>
                            </a>
                          </li>
                          <li>
                            <a href="#">
                              <span class="sub-item">Revisar mensajes del sistema</span>
                            </a>
                          </li>
                        </ul>
                      </div>
                    </li>
                    <li>
                      <a data-bs-toggle="collapse" href="#subnavsistema3">
                        <span class="sub-item">Desarrollador</span>
                        <span class="caret"></span>
                      </a>
                      <div class="collapse" id="subnavsistema3">
                        <ul class="nav nav-collapse subnav">
                          <li>
                            <a href="#">
                              <span class="sub-item">Base de datos</span>
                            </a>
                          </li>
                          <li>
                            <a href="#">
                              <span class="sub-item">Crear tablas</span>
                            </a>
                          </li>
                          <li>
                            <a href="#">
                              <span class="sub-item">Consulta CAE</span>
                            </a>
                          </li>
                          <li>
                            <a href="#">
                              <span class="sub-item">Consulta parámetros FE</span>
                            </a>
                          </li>
                          <li>
                            <a href="#">
                              <span class="sub-item">Scripts</span>
                            </a>
                          </li>
                          <li>
                            <a data-bs-toggle="collapse" href="#subnavsistema3.1">
                              <span class="sub-item">IF Epson</span>
                              <span class="caret"></span>
                            </a>
                            <div class="collapse" id="subnavsistema3.1">
                              <ul class="nav nav-collapse subnav">
                                <li>
                                  <a href="#">
                                    <span class="sub-item">Test Info</span>
                                  </a>
                                </li>
                                <li>
                                  <a href="#">
                                    <span class="sub-item">Test Características</span>
                                  </a>
                                </li>
                                <li>
                                  <a href="#">
                                    <span class="sub-item">Test Contribuyente</span>
                                  </a>
                                </li>
                              </ul>
                            </div>
                          </li>
                          <li>
                            <a data-bs-toggle="collapse" href="#subnavsistema3.2">
                              <span class="sub-item">IF Hasar</span>
                              <span class="caret"></span>
                            </a>
                            <div class="collapse" id="subnavsistema3.2">
                              <ul class="nav nav-collapse subnav">
                                <li>
                                  <a href="#">
                                    <span class="sub-item">Configuración</span>
                                  </a>
                                </li>
                              </ul>
                            </div>
                          </li>
                          <li>
                            <a href="#">
                              <span class="sub-item">Script migraciones</span>
                            </a>
                          </li>
                        </ul>
                      </div>
                    </li>
                    <li>
                      <a href="#">
                        <span class="sub-item">Mensajes de usuario</span>
                      </a>
                    </li>
                    <li>
                      <a data-bs-toggle="collapse" href="#subnavsistema4">
                        <span class="sub-item">Actualizaciones</span>
                        <span class="caret"></span>
                      </a>
                      <div class="collapse" id="subnavsistema4">
                        <ul class="nav nav-collapse subnav">
                          <li>
                            <a href="#">
                              <span class="sub-item">Bancos</span>
                            </a>
                          </li>
                          <li>
                            <a href="#">
                              <span class="sub-item">Tarjetas</span>
                            </a>
                          </li>
                        </ul>
                      </div>
                    </li>
                  </ul>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <!-- End Sidebar -->

      <div class="main-panel">
        <div class="main-header">
          <div class="main-header-logo">
            <!-- Logo Header -->
            <div class="logo-header" data-background-color="dark">
              <a href="index.html" class="logo">
                <img
                  src="{{asset('template/assets/img/kaiadmin/logo_light.svg')}}"
                  alt="navbar brand"
                  class="navbar-brand"
                  height="20"
                />
              </a>
              <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                  <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                  <i class="gg-menu-left"></i>
                </button>
              </div>
              <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
              </button>
            </div>
            <!-- End Logo Header -->
          </div>
          <!-- Navbar Header -->
          <nav
            class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom"
          >
            <div class="container-fluid">
              <h3 class="fw-bold">{{$title}}</h3>
              <ul class="breadcrumbs">
                  {{$breadcrumbs}}
              </ul>
              
              <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
                <li
                  class="nav-item topbar-icon dropdown hidden-caret d-flex d-lg-none"
                >
                  <a
                    class="nav-link dropdown-toggle"
                    data-bs-toggle="dropdown"
                    href="#"
                    role="button"
                    aria-expanded="false"
                    aria-haspopup="true"
                  >
                    <i class="fa fa-search"></i>
                  </a>
                  <ul class="dropdown-menu dropdown-search animated fadeIn">
                    <form class="navbar-left navbar-form nav-search">
                      <div class="input-group">
                        <input
                          type="text"
                          placeholder="Search ..."
                          class="form-control"
                        />
                      </div>
                    </form>
                  </ul>
                </li>
                <li class="nav-item topbar-user dropdown hidden-caret">
                  <a
                    class="dropdown-toggle profile-pic"
                    data-bs-toggle="dropdown"
                    href="#"
                    aria-expanded="false"
                  >
                    <div class="avatar-sm">
                      <img
                        src="{{ asset('template/assets/img/user (1).png') }}"
                        alt="..."
                        class="avatar-img rounded-circle"
                      />
                    </div>
                    <span class="profile-username">
                      <span class="fw-bold">{{$name = Auth::user()->name}}</span>
                    </span>
                  </a>
                
                  <ul class="dropdown-menu dropdown-user animated fadeIn">
                    <div class="dropdown-user-scroll scrollbar-outer">
                      <a class="dropdown-item" href="{{ route('logout') }}"
                         onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Logout
                      </a>
                
                      <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                      </form>
                    </div>
                  </ul>
                </li>
                
              </ul>
            </div>
          </nav>
          <!-- End Navbar -->
        </div>

        <div class="container">
          <div class="page-inner">

            <div class="row">
             
                {{$slot}}
              
            </div>

        </div>
       
        </div>
    </div>
    <!--   Core JS Files   -->
    <script src="{{asset('template/assets/js/core/jquery-3.7.1.min.js')}}"></script>
    <script src="{{asset('template/assets/js/core/popper.min.js')}}"></script>
    <script src="{{asset('template/assets/js/core/bootstrap.min.js')}}"></script>

    <!-- jQuery Scrollbar -->
    <script src="{{asset('template/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js')}}"></script>

    <!-- Chart JS -->
    <script src="{{asset('template/assets/js/plugin/chart.js/chart.min.js')}}"></script>

    <!-- jQuery Sparkline -->
    <script src="{{asset('template/assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js')}}"></script>

    <!-- Chart Circle -->
    <script src="{{asset('template/assets/js/plugin/chart-circle/circles.min.js')}}"></script>

    <!-- Datatables -->
    <script src="{{asset('template/assets/js/plugin/datatables/datatables.min.js')}}"></script>

    <!-- Bootstrap Notify -->
    <script src="{{asset('template/assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js')}}"></script>

    <!-- jQuery Vector Maps -->
    <script src="{{asset('template/assets/js/plugin/jsvectormap/jsvectormap.min.js')}}"></script>
    <script src="{{asset('template/assets/js/plugin/jsvectormap/world.js')}}"></script>

    <!-- Sweet Alert -->
    <script src="{{asset('template/assets/js/plugin/sweetalert/sweetalert.min.js')}}"></script>

    <!-- Kaiadmin JS -->
    <script src="{{asset('template/assets/js/kaiadmin.min.js')}}"></script>
    @yield('js')

    @livewireScripts
  </body>
</html>
