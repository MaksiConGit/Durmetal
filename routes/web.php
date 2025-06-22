<?php

use App\Http\Controllers\AsignarFactorController;
use App\Http\Controllers\CargaController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CodigoComplejidadController;
use App\Http\Controllers\DurezaController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\FactorPremioController;
use App\Http\Controllers\ItemOrdenTrabajoController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\MedioEnfriamientoController;
use App\Http\Controllers\OrdenTrabajoController;
use App\Http\Controllers\OrdenTrabajoExportController;
use App\Http\Controllers\ProcesoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProgramacionController;
use App\Http\Controllers\ProgramacionExportController;
use App\Http\Controllers\RepartirPremioController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\TratamientoController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::get('/', function () {
        return view('index');
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
    Route::get('programacion/export', [ProgramacionExportController::class, 'export'])->name('programacion.export');
    Route::get('programacion/{item_orden_trabajo}', [ProgramacionController::class, 'show'])->name('programacion.show');

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
    
    Route::get('actualizaciones/tratamientos/{tratamiento}/precio/create', [CodigoComplejidadController::class, 'create'])->name('precios.create');
    Route::post('actualizaciones/precios', [CodigoComplejidadController::class, 'store'])->name('precios.store');
    Route::get('actualizaciones/precios/{precio}/edit', [CodigoComplejidadController::class, 'edit'])->name('precios.edit');
    Route::delete('actualizaciones/tratamientos/{tratamiento}/precios/{precio}', [CodigoComplejidadController::class, 'destroy'])->name('precios.destroy');

    Route::resource('actualizaciones/asignar-factores', AsignarFactorController::class)->names('asignar-factores')->parameters(['asignar-factores' => 'usuario']);
    Route::resource('actualizaciones/repartir-premios', RepartirPremioController::class)->names('repartir-premios')->parameters(['repartir-premios' => 'premio']);


    Route::get('reportes/materiales', [ReporteController::class, 'materiales'])->name('reportes.materiales');
    Route::get('reportes/materiales-resumido', [ReporteController::class, 'materialesResumido'])->name('reportes.materiales-resumido');
    Route::get('reportes/materiales-resumido-excel', [ReporteController::class, 'materialesResumidoExcel'])->name('reportes.materiales-resumido-excel');

    Route::get('reportes/peso-por-tratamientos', [ReporteController::class, 'pesos'])->name('reportes.pesos');
    Route::get('reportes/peso-por-tratamientos-resumido', [ReporteController::class, 'pesosResumido'])->name('reportes.pesos-resumido');

    Route::get('reportes/trabajos-no-aptos', [ReporteController::class, 'trabajosNoAptos'])->name('reportes.trabajos-no-aptos');

    Route::get('reportes/premios-por-aprobacion', [ReporteController::class, 'premiosPorAprobacion'])->name('reportes.premios-por-aprobacion');
    Route::put('reportes/premios-por-aprobacion', [ReporteController::class, 'premiosPorAprobacionUpdate'])->name('reportes.premios-por-aprobacion.update');


});

require __DIR__.'/auth.php';
