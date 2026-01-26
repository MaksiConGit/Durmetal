<?php

use App\Http\Controllers\AsignarFactorController;
use App\Http\Controllers\BancosController;
use App\Http\Controllers\CargaController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CodigoComplejidadController;
use App\Http\Controllers\ComprasController;
use App\Http\Controllers\CondicionVentaController;
use App\Http\Controllers\ConfiguracionGlobalController;
use App\Http\Controllers\ConversorDurezasController;
use App\Http\Controllers\DivisasController;
use App\Http\Controllers\DocumentosController;
use App\Http\Controllers\DurezaController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\FactorPremioController;
use App\Http\Controllers\ImpresoraFiscalController;
use App\Http\Controllers\IngresoDatosController;
use App\Http\Controllers\ItemOrdenTrabajoController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\MedioEnfriamientoController;
use App\Http\Controllers\MensajeUsuarioController;
use App\Http\Controllers\OrdenTrabajoController;
use App\Http\Controllers\OrdenTrabajoExportController;
use App\Http\Controllers\OtrosEgresosController;
use App\Http\Controllers\PlantillaCargaController;
use App\Http\Controllers\PlantillaEmailController;
use App\Http\Controllers\ProcesoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProgramacionController;
use App\Http\Controllers\ProgramacionExportController;
use App\Http\Controllers\PuntoVentaController;
use App\Http\Controllers\ReglaController;
use App\Http\Controllers\RepartirPremioController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\SistemaController;
use App\Http\Controllers\TableroController;
use App\Http\Controllers\TablerosController;
use App\Http\Controllers\TarjetasController;
use App\Http\Controllers\TerminalController;
use App\Http\Controllers\TipoMensajeController;
use App\Http\Controllers\TratamientoController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\VentasController;
use App\Models\ConfiguracionGlobal;
use App\Models\FacturaVenta;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::get('/', function () {
        return view('ventas.buscar-documentos.index');
    })->name('index');
    

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('clients', ClientController::class)->names('clients');
    Route::get('/clientes/buscar', [ClientController::class, 'search'])->name('clientes.buscar');
    Route::get('/export', [ExportController::class, 'export'])->name('clients.export');
    Route::get('/cities/search', [CityController::class, 'search'])->name('cities.search');

    // Producción
    Route::resource('orden-trabajo', OrdenTrabajoController::class)->names('orden-trabajo');
    Route::get('enviar-mail', [OrdenTrabajoController::class, 'mail'])->name('enviar.mail');

    Route::get('/item-orden-trabajo/create/{orden_trabajo}', [ItemOrdenTrabajoController::class, 'create'])->name('item-orden-trabajo.create');
    Route::post('/item-orden-trabajo/{orden_trabajo}', [ItemOrdenTrabajoController::class, 'store'])->name('item-orden-trabajo.store');
    Route::get('/item-orden-trabajo/{item_orden_trabajo}/edit', [ItemOrdenTrabajoController::class, 'edit'])->name('item-orden-trabajo.edit');
    Route::put('/item-orden-trabajo/{item_orden_trabajo}', [ItemOrdenTrabajoController::class, 'update'])->name('item-orden-trabajo.update');
    Route::delete('/item-orden-trabajo/{item_orden_trabajo}', [ItemOrdenTrabajoController::class, 'destroy'])->name('item-orden-trabajo.destroy');
    Route::get('/exportar-orden/{id}', [OrdenTrabajoExportController::class, 'export'])->name('orden-trabajo.export');

    Route::get('programacion', [ProgramacionController::class, 'index'])->name('programacion.index');
    Route::get('programacion/create', [ProgramacionController::class, 'create'])->name('programacion.create');
    Route::post('programacion', [ProgramacionController::class, 'store'])->name('programacion.store');
    Route::get('/programacion/{programacion}/edit', [ProgramacionController::class, 'edit'])->name('programacion.edit');
    Route::put('programacion/{programacion}', [ProgramacionController::class, 'update'])->name('programacion.update');
    Route::get('programacion/export', [ProgramacionExportController::class, 'export'])->name('programacion.export');
    Route::get('programacion/{item_orden_trabajo}', [ProgramacionController::class, 'show'])->name('programacion.show');
    Route::delete('/programacion/{programacion}', [ProgramacionController::class, 'destroy'])->name('programacion.destroy');

    Route::get('/cargas', [CargaController::class, 'index'])->name('cargas.index');
    Route::get('cargas/{ids}', [CargaController::class, 'show'])->name('cargas.show');
    Route::get('/cargas/{ids}/edit', [CargaController::class, 'edit'])->name('cargas.edit');
    Route::put('/cargas/{ids}', [CargaController::class, 'update'])->name('cargas.update');
    Route::delete('/cargas/{programacion}', [CargaController::class, 'destroy'])->name('cargas.destroy');

    Route::resource('actualizaciones/durezas', DurezaController::class)->names('durezas');
    Route::resource('actualizaciones/materiales', MaterialController::class)->names('materiales')->parameters(['materiales' => 'material']);
    Route::resource('actualizaciones/tratamientos', TratamientoController::class)->names('tratamientos');
    Route::resource('actualizaciones/medios-enfriamiento', MedioEnfriamientoController::class)->names('medios-enfriamiento')->parameters(['medios-enfriamiento' => 'medio_enfriamiento']);
    Route::resource('actualizaciones/procesos', ProcesoController::class)->names('procesos');
    Route::resource('actualizaciones/factores-premio', FactorPremioController::class)->names('factores-premio')->parameters(['factores-premio' => 'factor_premio']);
    
    // Route::get('actualizaciones/tratamientos/{tratamiento}/precio/create', [CodigoComplejidadController::class, 'create'])->name('precios.create');
    // Route::post('actualizaciones/precios', [CodigoComplejidadController::class, 'store'])->name('precios.store');
    // Route::get('actualizaciones/precios/{precio}/edit', [CodigoComplejidadController::class, 'edit'])->name('precios.edit');
    // Route::delete('actualizaciones/tratamientos/{tratamiento}/precios/{precio}', [CodigoComplejidadController::class, 'destroy'])->name('precios.destroy');

    Route::resource('actualizaciones/asignar-factores', AsignarFactorController::class)->names('asignar-factores')->parameters(['asignar-factores' => 'usuario']);
    Route::resource('actualizaciones/repartir-premios', RepartirPremioController::class)->names('repartir-premios')->parameters(['repartir-premios' => 'premio']);

    Route::get('ingreso-datos', [IngresoDatosController::class, 'index'])->name('ingreso-datos.index');
    Route::put('ingreso-datos/update', [IngresoDatosController::class, 'update'])->name('ingreso-datos.update');
    Route::get('ingreso-datos/pdf/{certificado}', [IngresoDatosController::class, 'pdf'])->name('ingreso-datos.pdf');
Route::get(
    '/ingreso-datos/{certificado}/email',
    [IngresoDatosController::class, 'email']
)->name('ingreso-datos.email');

    Route::get('reportes/materiales', [ReporteController::class, 'materiales'])->name('reportes.materiales');
    Route::get('reportes/materiales-resumido', [ReporteController::class, 'materialesResumido'])->name('reportes.materiales-resumido');
    Route::get('reportes/materiales-resumido-excel', [ReporteController::class, 'materialesResumidoExcel'])->name('reportes.materiales-resumido-excel');

    Route::get('reportes/peso-por-tratamientos', [ReporteController::class, 'pesos'])->name('reportes.pesos');
    Route::get('reportes/peso-por-tratamientos-resumido', [ReporteController::class, 'pesosResumido'])->name('reportes.pesos-resumido');

    Route::get('reportes/trabajos-no-aptos', [ReporteController::class, 'trabajosNoAptos'])->name('reportes.trabajos-no-aptos');

    Route::get('reportes/premios-por-aprobacion', [ReporteController::class, 'premiosPorAprobacion'])->name('reportes.premios-por-aprobacion');
    Route::put('reportes/premios-por-aprobacion', [ReporteController::class, 'premiosPorAprobacionUpdate'])->name('reportes.premios-por-aprobacion.update');

    Route::get('reportes/premios', [ReporteController::class, 'premios'])->name('reportes.premios');


    // Ventas
    Route::get('divisas', [DivisasController::class, 'edit'])->name('divisas.edit');
    Route::put('divisas/{configuracion_global}', [DivisasController::class, 'update'])->name('divisas.update');

    Route::get('actualizaciones/precios', [CodigoComplejidadController::class, 'index'])->name('ventas.precios.index');
    Route::get('actualizaciones/precios/create/{tratamiento}', [CodigoComplejidadController::class, 'create'])->name('ventas.precios.create');
    Route::post('actualizaciones/precios', [CodigoComplejidadController::class, 'store'])->name('ventas.precios.store');
    Route::put('actualizaciones/precios/{precio}', [CodigoComplejidadController::class, 'update'])->name('ventas.precios.update');
    Route::put('actualizaciones/precios/tratamiento/{tratamiento}', [CodigoComplejidadController::class, 'updateTratamiento'])->name('ventas.precios.update.tratamiento');
    Route::put('actualizaciones/precios/precio/{precio}', [CodigoComplejidadController::class, 'updatePrecio'])->name('ventas.precios.update.precio');
    Route::delete('actualizaciones/precios/{precio}', [CodigoComplejidadController::class, 'destroy'])->name('ventas.precios.destroy');

    Route::get('trabajos-pendientes-de-facturar', [VentasController::class, 'trabajosSinFacturar'])->name('ventas.trabajos-sin-facturar');
    Route::get('listado-de-retenciones', [VentasController::class, 'listadoDeRetenciones'])->name('ventas.listado-de-retenciones');
    Route::get('listado-de-precios', [VentasController::class, 'listadoDePrecios'])->name('ventas.listado-de-precios');

    Route::get('ficha-del-cliente', [VentasController::class, 'fichaDelCliente'])->name('ventas.ficha-del-cliente');
    Route::get('ficha-del-cliente/{cliente}', [VentasController::class, 'fichaDelClienteShow'])->name('ventas.ficha-del-cliente.show');

    Route::get('ficha-del-cliente/orden-trabajo/create/{cliente}', [VentasController::class, 'fichaDelClienteOrdenCreate'])->name('ventas.ficha-del-cliente-orden.create');
    
    Route::get('ficha-del-cliente/nota-envio/create/{cliente}', [VentasController::class, 'fichaDelClienteNotaEnvioCreate'])->name('ventas.ficha-del-cliente-nota-envio.create');
    Route::put('ficha-del-cliente/nota-envio/divisas/{configuracion_global}/{cliente}', [VentasController::class, 'divisasUpdate'])->name('ventas.divisas.update');
    Route::post('ficha-del-cliente/nota-envio/{cliente}', [VentasController::class, 'fichaDelClienteNotaEnvioStore'])->name('ventas.ficha-del-cliente-nota-envio.store');
    Route::put('ficha-del-cliente/nota-envio/precios/{precio}', [VentasController::class, 'fichaDelClienteNotaEnvioCC'])->name('ventas.ficha-del-cliente-nota-envio.cc');
    Route::get('ficha-del-cliente/nota-envio/show/{nota_envio}', [VentasController::class, 'fichaDelClienteNotaEnvioShow'])->name('ventas.ficha-del-cliente-nota-envio.show');
    Route::get('ficha-del-cliente/nota-envio/pdf/{nota_envio}', [VentasController::class, 'fichaDelClienteNotaEnvioPDF'])->name('ventas.ficha-del-cliente-nota-envio.pdf');
    Route::put('ficha-del-cliente/nota-envio/orden-trabajo/{item_orden_trabajo}', [VentasController::class, 'fichaDelClienteNotaEnvioOrdenTrabajo'])->name('ventas.ficha-del-cliente-nota-envio.orden-trabajo');
    Route::get('ficha-del-cliente/nota-envio/{nota_envio}/edit', [VentasController::class, 'fichaDelClienteNotaEnvioEdit'])->name('ventas.ficha-del-cliente-nota-envio.edit');
    Route::put('ficha-del-cliente/nota-envio/{nota_envio}', [VentasController::class, 'fichaDelClienteNotaEnvioUpdate'])->name('ventas.ficha-del-cliente-nota-envio.update');
    Route::put('ficha-del-cliente/nota-envio/divisas/{configuracion_global}/{nota_envio}/edit', [VentasController::class, 'divisasUpdateEdit'])->name('ventas.divisas.update.edit');
    Route::get('ficha-del-cliente/nota-envio/{nota_envio}', [VentasController::class, 'fichaDelClienteNotaEnvioDestroy'])->name('ventas.ficha-del-cliente-nota-envio.destroy');
    Route::get('ficha-del-cliente/nota-envio/{nota_envio}/enviar-email', [VentasController::class, 'fichaDelClienteNotaEnvioMail'])->name('ventas.ficha-del-cliente-nota-envio.email');

    Route::get('ficha-del-cliente/factura-venta/create/{cliente}', [VentasController::class, 'fichaDelClienteFacturaVentaCreate'])->name('ventas.ficha-del-cliente-factura-venta.create');
    Route::post('ficha-del-cliente/factura-venta/{cliente}', [VentasController::class, 'fichaDelClienteFacturaVentaStore'])->name('ventas.ficha-del-cliente-factura-venta.store');
    Route::get('ficha-del-cliente/factura-venta/show/{factura_venta}', [VentasController::class, 'fichaDelClienteFacturaVentaShow'])->name('ventas.ficha-del-cliente-factura-venta.show');
    Route::get('ficha-del-cliente/factura-venta/pdf/{factura_venta}', [VentasController::class, 'fichaDelClienteFacturaVentaPDF'])->name('ventas.ficha-del-cliente-factura-venta.pdf');
    Route::get('ficha-del-cliente/factura-venta/{factura_venta}/edit', [VentasController::class, 'fichaDelClienteFacturaVentaEdit'])->name('ventas.ficha-del-cliente-factura-venta.edit');
    Route::put('ficha-del-cliente/factura-venta/{factura_venta}', [VentasController::class, 'fichaDelClienteFacturaVentaUpdate'])->name('ventas.ficha-del-cliente-factura-venta.update');
    Route::get('ficha-del-cliente/factura-venta/{factura_venta}/pendiente', [VentasController::class, 'fichaDelClienteFacturaVentaDestroyPendiente'])->name('ventas.ficha-del-cliente-factura-venta.destroy-pendiente');
    Route::get('ficha-del-cliente/factura-venta/{factura_venta}/completo', [VentasController::class, 'fichaDelClienteFacturaVentaDestroyCompleto'])->name('ventas.ficha-del-cliente-factura-venta.destroy-completo');
    Route::get('ventas/factura/{factura_venta}/enviar-email', [VentasController::class, 'fichaDelClienteFacturaVentaMail'])->name('ventas.ficha-del-cliente-factura-venta.email');

    Route::get('ficha-del-cliente/recibo-venta/create/{cliente}', [VentasController::class, 'fichaDelClienteReciboVentaCreate'])->name('ventas.ficha-del-cliente-recibo-venta.create');
    Route::post('ficha-del-cliente/recibo-venta/{cliente}', [VentasController::class, 'fichaDelClienteReciboVentaStore'])->name('ventas.ficha-del-cliente-recibo-venta.store');
    Route::get('ficha-del-cliente/recibo-venta/show/{recibo_venta}', [VentasController::class, 'fichaDelClienteReciboVentaShow'])->name('ventas.ficha-del-cliente-recibo-venta.show');
    Route::get('ficha-del-cliente/recibo-venta/pdf/{recibo_venta}', [VentasController::class, 'fichaDelClienteReciboVentaPDF'])->name('ventas.ficha-del-cliente-recibo-venta.pdf');
    Route::get('ficha-del-cliente/recibo-venta/{recibo_venta}/edit', [VentasController::class, 'fichaDelClienteReciboVentaEdit'])->name('ventas.ficha-del-cliente-recibo-venta.edit');
    Route::put('ficha-del-cliente/recibo-venta/{recibo_venta}', [VentasController::class, 'fichaDelClienteReciboVentaUpdate'])->name('ventas.ficha-del-cliente-recibo-venta.update');
    Route::get('ficha-del-cliente/recibo-venta/{recibo_venta}/enviar-email', [VentasController::class, 'fichaDelClienteReciboVentaMail'])->name('ventas.ficha-del-cliente-recibo-venta.email');

    Route::get('ficha-del-cliente/nota-credito/create/{cliente}/{factura_venta}', [VentasController::class, 'fichaDelClienteNotaCreditoCreate'])->name('ventas.ficha-del-cliente-nota-credito.create');
    Route::post('ficha-del-cliente/nota-credito/{cliente}', [VentasController::class, 'fichaDelClienteNotaCreditoStore'])->name('ventas.ficha-del-cliente-nota-credito.store');
    Route::get('ficha-del-cliente/nota-credito/show/{nota_credito_venta}', [VentasController::class, 'fichaDelClienteNotaCreditoShow'])->name('ventas.ficha-del-cliente-nota-credito.show');
    Route::get('ficha-del-cliente/nota-credito/{nota_credito}/edit', [VentasController::class, 'fichaDelClienteNotaCreditoEdit'])->name('ventas.ficha-del-cliente-nota-credito.edit');
    Route::put('ficha-del-cliente/nota-credito/{nota_credito}', [VentasController::class, 'fichaDelClienteNotaCreditoUpdate'])->name('ventas.ficha-del-cliente-nota-credito.update');
    Route::get('ficha-del-cliente/nota-credito/pdf/{nota_credito}', [VentasController::class, 'fichaDelClienteNotaCreditoPDF'])->name('ventas.ficha-del-cliente-nota-credito.pdf');
    Route::get('ficha-del-cliente/nota-credito/{nota_credito}/enviar-email', [VentasController::class, 'fichaDelClienteNotaCreditoMail'])->name('ventas.ficha-del-cliente-nota-credito.email');

    Route::get('ficha-del-cliente/nota-debito/create/{cliente}/{factura_venta}', [VentasController::class, 'fichaDelClienteNotaDebitoCreate'])->name('ventas.ficha-del-cliente-nota-debito.create');
    Route::post('ficha-del-cliente/nota-debito/{cliente}', [VentasController::class, 'fichaDelClienteNotaDebitoStore'])->name('ventas.ficha-del-cliente-nota-debito.store');
    Route::get('ficha-del-cliente/nota-debito/show/{nota_debito}', [VentasController::class, 'fichaDelClienteNotaDebitoShow'])->name('ventas.ficha-del-cliente-nota-debito.show');
    Route::get('ficha-del-cliente/nota-debito/{nota_debito}/edit', [VentasController::class, 'fichaDelClienteNotaDebitoEdit'])->name('ventas.ficha-del-cliente-nota-debito.edit');
    Route::put('ficha-del-cliente/nota-debito/{nota_debito}', [VentasController::class, 'fichaDelClienteNotaDebitoUpdate'])->name('ventas.ficha-del-cliente-nota-debito.update');
    Route::get('ficha-del-cliente/nota-debito/pdf/{nota_debito}', [VentasController::class, 'fichaDelClienteNotaDebitoPDF'])->name('ventas.ficha-del-cliente-nota-debito.pdf');
    Route::get('ficha-del-cliente/nota-debito/{nota_debito}/enviar-email', [VentasController::class, 'fichaDelClienteNotaDebitoMail'])->name('ventas.ficha-del-cliente-nota-debito.email');

    Route::get('ficha-del-cliente/minuta/create/{cliente}', [VentasController::class, 'fichaDelClienteMinutaCreate'])->name('ventas.ficha-del-cliente-minuta.create');

    Route::get('listado-de-cheques', [VentasController::class, 'listadoDeCheques'])->name('ventas.listado-de-cheques');

    Route::get('valorizar-trabajos', [VentasController::class, 'valorizarTrabajos'])->name('ventas.valorizar-trabajos');

    Route::get('listado-de-saldos', [VentasController::class, 'listadoDeSaldos'])->name('ventas.listado-de-saldos');

    Route::get('resumen-cuenta-corriente', [VentasController::class, 'resumenCuentaCorriente'])->name('ventas.resumen-cuenta-corriente');
    Route::get('resumen-cuenta-corriente/pdf/{cliente}', [VentasController::class, 'resumenCuentaCorrientePDF'])->name('ventas.resumen-cuenta-corriente.pdf');
    Route::get('resumen-cuenta-corriente/{cliente}/enviar-email', [VentasController::class, 'resumenCuentaCorrienteMail'])->name('ventas.resumen-cuenta-corriente.email');

    Route::get('listado-de-iva', [VentasController::class, 'listadoDeIVA'])->name('ventas.listado-de-iva');

    Route::get('buscar-documentos', [VentasController::class, 'buscarDocumentos'])->name('ventas.buscar-documentos');

    // Otros Egresos
    Route::get('otros-egresos', [OtrosEgresosController::class, 'otrosEgresos'])->name('otros-egresos.otros-egresos.index');
    Route::get('otros-egresos/create', [OtrosEgresosController::class, 'otrosEgresosCreate'])->name('otros-egresos.otros-egresos.create');
    Route::post('otros-egresos', [OtrosEgresosController::class, 'otrosEgresosStore'])->name('otros-egresos.otros-egresos.store');
    Route::get('otros-egresos/{movimiento_cuenta_gastos}/edit', [OtrosEgresosController::class, 'otrosEgresosEdit'])->name('otros-egresos.otros-egresos.edit');
    Route::put('otros-egresos/{movimiento_cuenta_gastos}', [OtrosEgresosController::class, 'otrosEgresosUpdate'])->name('otros-egresos.otros-egresos.update');
    Route::delete('otros-egresos/{movimiento_cuenta_gastos}', [OtrosEgresosController::class, 'otrosEgresosDestroy'])->name('otros-egresos.otros-egresos.destroy');

    Route::get('otros-egresos/actualizaciones/cuentas', [OtrosEgresosController::class, 'cuentasIndex'])->name('otros-egresos.actualizaciones.cuentas.index');
    Route::get('otros-egresos/actualizaciones/cuentas/create', [OtrosEgresosController::class, 'cuentasCreate'])->name('otros-egresos.actualizaciones.cuentas.create');
    Route::post('otros-egresos/actualizaciones/cuentas', [OtrosEgresosController::class, 'cuentasStore'])->name('otros-egresos.actualizaciones.cuentas.store');
    Route::get('otros-egresos/actualizaciones/cuentas/{cuenta_otros_egresos}/edit', [OtrosEgresosController::class, 'cuentasEdit'])->name('otros-egresos.actualizaciones.cuentas.edit');
    Route::put('otros-egresos/actualizaciones/cuentas/{cuenta_otros_egresos}', [OtrosEgresosController::class, 'cuentasUpdate'])->name('otros-egresos.actualizaciones.cuentas.update');
    Route::delete('otros-egresos/actualizaciones/cuentas/{cuenta_otros_egresos}', [OtrosEgresosController::class, 'cuentasDestroy'])->name('otros-egresos.actualizaciones.cuentas.destroy');

    Route::get('otros-egresos/listado-entre-fechas', [OtrosEgresosController::class, 'listadoEntreFechasIndex'])->name('otros-egresos.listado-entre-fechas.index');

    // Compras
    Route::get('compras/actualizaciones/proveedores', [ComprasController::class, 'proveedoresIndex'])->name('compras.actualizaciones.proveedores.index');
    Route::get('compras/actualizaciones/proveedores/create', [ComprasController::class, 'proveedoresCreate'])->name('compras.actualizaciones.proveedores.create');
    Route::post('compras/actualizaciones/proveedores', [ComprasController::class, 'proveedoresStore'])->name('compras.actualizaciones.proveedores.store');
    Route::get('compras/actualizaciones/proveedores/{proveedor}/edit', [ComprasController::class, 'proveedoresEdit'])->name('compras.actualizaciones.proveedores.edit');
    Route::put('compras/actualizaciones/proveedores/{proveedor}', [ComprasController::class, 'proveedoresUpdate'])->name('compras.actualizaciones.proveedores.update');
    Route::delete('compras/actualizaciones/proveedores/{proveedor}', [ComprasController::class, 'proveedoresDestroy'])->name('compras.actualizaciones.proveedores.destroy');

    Route::get('compras/actualizaciones/cuenta-de-gastos', [ComprasController::class, 'cuentaDeGastosIndex'])->name('compras.actualizaciones.cuentas-de-gastos.index');
    Route::get('compras/actualizaciones/cuentas-de-gastos/create', [ComprasController::class, 'cuentaDeGastosCreate'])->name('compras.actualizaciones.cuentas-de-gastos.create');
    Route::post('compras/actualizaciones/cuentas-de-gastos', [ComprasController::class, 'cuentaDeGastosStore'])->name('compras.actualizaciones.cuentas-de-gastos.store');
    Route::get('compras/actualizaciones/cuentas-de-gastos/{cuenta_de_gastos}/edit', [ComprasController::class, 'cuentaDeGastosEdit'])->name('compras.actualizaciones.cuentas-de-gastos.edit');
    Route::put('compras/actualizaciones/cuentas-de-gastos/{cuenta_de_gastos}', [ComprasController::class, 'cuentaDeGastosUpdate'])->name('compras.actualizaciones.cuentas-de-gastos.update');
    Route::delete('compras/actualizaciones/cuentas-de-gastos/{cuenta_de_gastos}', [ComprasController::class, 'cuentaDeGastosDestroy'])->name('compras.actualizaciones.cuentas-de-gastos.destroy');

    Route::get('compras/listado-de-cheques-proveedores', [ComprasController::class, 'listadoDeChequesProveedores'])->name('compras.listado-de-cheques-proveedores.index');

    Route::get('compras/listado-de-iva', [ComprasController::class, 'listadoDeIva'])->name('compras.listado-de-iva.index');

    Route::get('compras/resumen-mensual-egresos', [ComprasController::class, 'resumenMensualEgresos'])->name('compras.resumen-mensual-egresos.index');

    Route::get('compras/resumen-cuenta-corriente/{proveedor?}', [ComprasController::class, 'resumenCuentaCorriente'])->name('compras.resumen-cuenta-corriente.index');

    Route::get('compras/listado-movimientos-por-cuentas-gastos', [ComprasController::class, 'listadoMovimientosCuentasGastos'])->name('compras.listado-movimientos-por-cuentas-gastos.index');

    Route::get('compras/listado-de-saldos-proveedores', [ComprasController::class, 'listadoSaldosProveedores'])->name('compras.listado-de-saldos-proveedores.index');

    Route::get('compras/ficha-del-proveedor', [ComprasController::class, 'fichaDelProveedorIndex'])->name('compras.ficha-del-proveedor.index');
    Route::get('compras/ficha-del-proveedor/{proveedor}', [ComprasController::class, 'fichaDelProveedorShow'])->name('compras.ficha-del-proveedor.show');

    Route::get('compras/ficha-del-proveedor/facturas/create/{proveedor}', [ComprasController::class, 'fichaFacturaCompraCreate'])->name('compras.ficha-del-proveedor.factura-compra.create');
    Route::post('compras/ficha-del-proveedor/facturas', [ComprasController::class, 'fichaFacturaCompraStore'])->name('compras.ficha-del-proveedor.factura-compra.store');
    Route::get('compras/ficha-del-proveedor/facturas/{factura_compra}/edit', [ComprasController::class, 'fichaFacturaCompraEdit'])->name('compras.ficha-del-proveedor.factura-compra.edit');
    Route::put('compras/ficha-del-proveedor/facturas/{factura_compra}', [ComprasController::class, 'fichaFacturaCompraUpdate'])->name('compras.ficha-del-proveedor.factura-compra.update');
    Route::delete('compras/ficha-del-proveedor/facturas/{factura_compra}', [ComprasController::class, 'fichaFacturaCompraDestroy'])->name('compras.ficha-del-proveedor.factura-compra.destroy');

    Route::get('compras/ficha-del-proveedor/ordenes-de-pago/create/{proveedor}', [ComprasController::class, 'fichaOrdenPagoCreate'])->name('compras.ficha-del-proveedor.orden-pago.create');
    Route::post('compras/ficha-del-proveedor/ordenes-de-pago', [ComprasController::class, 'fichaOrdenPagoStore'])->name('compras.ficha-del-proveedor.orden-pago.store');
    Route::get('compras/ficha-del-proveedor/ordenes-de-pago/{orden_pago}/edit', [ComprasController::class, 'fichaOrdenPagoEdit'])->name('compras.ficha-del-proveedor.orden-pago.edit');
    Route::put('compras/ficha-del-proveedor/ordenes-de-pago/{orden_pago}', [ComprasController::class, 'fichaOrdenPagoUpdate'])->name('compras.ficha-del-proveedor.orden-pago.update');
    Route::delete('compras/ficha-del-proveedor/ordenes-de-pago/{orden_pago}', [ComprasController::class, 'fichaOrdenPagoDestroy'])->name('compras.ficha-del-proveedor.orden-pago.destroy');

    Route::get('compras/ficha-del-proveedor/notas-de-credito/create/{proveedor}', [ComprasController::class, 'fichaNotaCreditoCreate'])->name('compras.ficha-del-proveedor.nota-credito.create');
    Route::post('compras/ficha-del-proveedor/notas-de-credito', [ComprasController::class, 'fichaNotaCreditoStore'])->name('compras.ficha-del-proveedor.nota-credito.store');
    Route::get('compras/ficha-del-proveedor/notas-de-credito/{nota_credito}/edit', [ComprasController::class, 'fichaNotaCreditoEdit'])->name('compras.ficha-del-proveedor.nota-credito.edit');
    Route::put('compras/ficha-del-proveedor/notas-de-credito/{nota_credito}', [ComprasController::class, 'fichaNotaCreditoUpdate'])->name('compras.ficha-del-proveedor.nota-credito.update');
    Route::delete('compras/ficha-del-proveedor/notas-de-credito/{nota_credito}', [ComprasController::class, 'fichaNotaCreditoDestroy'])->name('compras.ficha-del-proveedor.nota-credito.destroy');
    
    Route::get('compras/ficha-del-proveedor/nota-de-debito/create/{proveedor}', [ComprasController::class, 'fichaNotaDebitoCreate'])->name('compras.ficha-del-proveedor.nota-debito.create');
    Route::post('compras/ficha-del-proveedor/nota-de-debito', [ComprasController::class, 'fichaNotaDebitoStore'])->name('compras.ficha-del-proveedor.nota-debito.store');
    Route::get('compras/ficha-del-proveedor/nota-de-debito/{nota_debito}/edit', [ComprasController::class, 'fichaNotaDebitoEdit'])->name('compras.ficha-del-proveedor.nota-debito.edit');
    Route::put('compras/ficha-del-proveedor/nota-de-debito/{nota_debito}', [ComprasController::class, 'fichaNotaDebitoUpdate'])->name('compras.ficha-del-proveedor.nota-debito.update');
    Route::delete('compras/ficha-del-proveedor/nota-de-debito/{nota_debito}', [ComprasController::class, 'fichaNotaDebitoDestroy'])->name('compras.ficha-del-proveedor.nota-debito.destroy');
    
    Route::get('compras/ficha-del-proveedor/minutas/create/{proveedor}', [ComprasController::class, 'fichaMinutaCreate'])->name('compras.ficha-del-proveedor.minuta.create');
    Route::post('compras/ficha-del-proveedor/minutas', [ComprasController::class, 'fichaMinutaStore'])->name('compras.ficha-del-proveedor.minuta.store');
    Route::get('compras/ficha-del-proveedor/minutas/{minuta_compra}/edit', [ComprasController::class, 'fichaMinutaEdit'])->name('compras.ficha-del-proveedor.minuta.edit');
    Route::put('compras/ficha-del-proveedor/minutas/{minuta_compra}', [ComprasController::class, 'fichaMinutaUpdate'])->name('compras.ficha-del-proveedor.minuta.update');
    Route::delete('compras/ficha-del-proveedor/minutas/{minuta_compra}', [ComprasController::class, 'fichaMinutaDestroy'])->name('compras.ficha-del-proveedor.minuta.destroy');

    Route::delete('otros-egresos/{movimiento_cuenta_gastos}', [OtrosEgresosController::class, 'otrosEgresosDestroy'])->name('otros-egresos.otros-egresos.destroy');


    Route::get('/test-mail', function () {
        Mail::raw('Correo de prueba', function ($message) {
            $message->to('maksiconpruebas@gmail.com')
                    ->subject('Test Ferozo');
        });

        return 'Mail enviado';
    });

    Route::get('compras/buscar-comprobantes', [ComprasController::class, 'buscarComprobantes'])->name('compras.buscar-comprobantes.index');

    // Sistema
    Route::prefix('sistema/actualizaciones')->group(function () {
        Route::resource('bancos', BancosController::class)->names([
            'index'   => 'sistema.actualizaciones.bancos.index',
            'create'  => 'sistema.actualizaciones.bancos.create',
            'store'   => 'sistema.actualizaciones.bancos.store',
            'edit'    => 'sistema.actualizaciones.bancos.edit',
            'update'  => 'sistema.actualizaciones.bancos.update',
            'destroy' => 'sistema.actualizaciones.bancos.destroy',
        ])->except(['show']);

        Route::resource('tarjetas', TarjetasController::class)->names([
            'index'   => 'sistema.actualizaciones.tarjetas.index',
            'create'  => 'sistema.actualizaciones.tarjetas.create',
            'store'   => 'sistema.actualizaciones.tarjetas.store',
            'edit'    => 'sistema.actualizaciones.tarjetas.edit',
            'update'  => 'sistema.actualizaciones.tarjetas.update',
            'destroy' => 'sistema.actualizaciones.tarjetas.destroy',
        ])->except(['show']);
    });

    Route::prefix('sistema/configuracion')->group(function () {

        Route::resource('configuracion-global', ConfiguracionGlobalController::class)->names([
            'index'    => 'sistema.configuracion.configuracion-global.index',
            'update'  => 'sistema.configuracion.configuracion-global.update',
        ])->except(['edit', 'create', 'store', 'show', 'destroy']);

        Route::resource('puntos-de-venta', PuntoVentaController::class)->names([
            'index'   => 'sistema.configuracion.puntos-de-venta.index',
            'create'  => 'sistema.configuracion.puntos-de-venta.create',
            'store'   => 'sistema.configuracion.puntos-de-venta.store',
            'edit'    => 'sistema.configuracion.puntos-de-venta.edit',
            'update'  => 'sistema.configuracion.puntos-de-venta.update',
            'destroy' => 'sistema.configuracion.puntos-de-venta.destroy',
        ])->except(['show']);

        Route::resource('terminales', TerminalController::class)->names([
            'index'   => 'sistema.configuracion.terminales.index',
            'create'  => 'sistema.configuracion.terminales.create',
            'store'   => 'sistema.configuracion.terminales.store',
            'edit'    => 'sistema.configuracion.terminales.edit',
            'update'  => 'sistema.configuracion.terminales.update',
            'destroy' => 'sistema.configuracion.terminales.destroy',
        ])->parameters([
        'terminales' => 'terminal'
        ])->except(['show']);

        Route::resource('impresoras-fiscales', ImpresoraFiscalController::class)->names([
            'index'   => 'sistema.configuracion.impresoras-fiscales.index',
            'create'  => 'sistema.configuracion.impresoras-fiscales.create',
            'store'   => 'sistema.configuracion.impresoras-fiscales.store',
            'edit'    => 'sistema.configuracion.impresoras-fiscales.edit',
            'update'  => 'sistema.configuracion.impresoras-fiscales.update',
            'destroy' => 'sistema.configuracion.impresoras-fiscales.destroy',
        ])->parameters([
        'impresoras-fiscales' => 'impresora_fiscal'
        ])->except(['show']);

        Route::resource('usuarios', UsuarioController::class)->names([
            'index'   => 'sistema.configuracion.usuarios.index',
            'create'  => 'sistema.configuracion.usuarios.create',
            'store'   => 'sistema.configuracion.usuarios.store',
            'edit'    => 'sistema.configuracion.usuarios.edit',
            'update'  => 'sistema.configuracion.usuarios.update',
            'destroy' => 'sistema.configuracion.usuarios.destroy',
        ])->except(['show']);

        Route::resource('reglas', ReglaController::class)->names([
            'index'   => 'sistema.configuracion.reglas.index',
            'create'  => 'sistema.configuracion.reglas.create',
            'store'   => 'sistema.configuracion.reglas.store',
            'edit'    => 'sistema.configuracion.reglas.edit',
            'update'  => 'sistema.configuracion.reglas.update',
            'destroy' => 'sistema.configuracion.reglas.destroy',
        ])->except(['show']);

        Route::resource('plantillas-de-email', PlantillaEmailController::class)->names([
            'index'   => 'sistema.configuracion.plantillas-de-email.index',
            'edit'    => 'sistema.configuracion.plantillas-de-email.edit',
            'update'  => 'sistema.configuracion.plantillas-de-email.update',
            'destroy' => 'sistema.configuracion.plantillas-de-email.destroy',
        ])->except(['show', 'create', 'store', 'destroy']);

        Route::resource('conversor-de-durezas', ConversorDurezasController::class)->names([
            'index'   => 'sistema.configuracion.conversor-de-durezas.index',
            'update'  => 'sistema.configuracion.conversor-de-durezas.update',
            'destroy' => 'sistema.configuracion.conversor-de-durezas.destroy',
        ])->except(['show', 'create', 'store', 'edit']);

        Route::resource('plantillas-de-carga', PlantillaCargaController::class)->names([
            'index'   => 'sistema.configuracion.plantillas-de-carga.index',
            'create'  => 'sistema.configuracion.plantillas-de-carga.create',
            'store'   => 'sistema.configuracion.plantillas-de-carga.store',
            'edit'    => 'sistema.configuracion.plantillas-de-carga.edit',
            'update'  => 'sistema.configuracion.plantillas-de-carga.update',
            'destroy' => 'sistema.configuracion.plantillas-de-carga.destroy',
        ])->except(['show', 'create', 'store', 'edit']);

        Route::resource('condiciones-de-venta', CondicionVentaController::class)->names([
            'index'   => 'sistema.configuracion.condiciones-de-venta.index',
            'create'  => 'sistema.configuracion.condiciones-de-venta.create',
            'store'   => 'sistema.configuracion.condiciones-de-venta.store',
            'edit'    => 'sistema.configuracion.condiciones-de-venta.edit',
            'update'  => 'sistema.configuracion.condiciones-de-venta.update',
            'destroy' => 'sistema.configuracion.condiciones-de-venta.destroy',
        ])->parameters([
        'condiciones-de-venta' => 'condicion_venta'
        ])->except(['show']);

        Route::resource('tipos-de-mensajes', TipoMensajeController::class)->names([
            'index'   => 'sistema.configuracion.tipos-de-mensajes.index',
            'create'  => 'sistema.configuracion.tipos-de-mensajes.create',
            'store'   => 'sistema.configuracion.tipos-de-mensajes.store',
            'edit'    => 'sistema.configuracion.tipos-de-mensajes.edit',
            'update'  => 'sistema.configuracion.tipos-de-mensajes.update',
            'destroy' => 'sistema.configuracion.tipos-de-mensajes.destroy',
        ])->except(['show']);
    });

    Route::prefix('sistema/mensajes-de-usuario')->group(function () {
        Route::resource('mensajes-de-usuario', MensajeUsuarioController::class)->names([
            'index'   => 'sistema.mensajes-de-usuario.index',
            'create'  => 'sistema.mensajes-de-usuario.create',
            'store'   => 'sistema.mensajes-de-usuario.store',
            'edit'    => 'sistema.mensajes-de-usuario.edit',
            'update'  => 'sistema.mensajes-de-usuario.update',
            'destroy' => 'sistema.mensajes-de-usuario.destroy',
        ])->except(['show']);
    });

    // TABLEROS

    Route::get('tableros/hornos', [TablerosController::class, 'hornos'])->name('tableros.hornos.index');

});

require __DIR__.'/auth.php';
