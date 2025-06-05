<?php

use App\Exports\OrdenesTrabajoExport;
use App\Http\Controllers\CityController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\ItemOrdenTrabajoController;
use App\Http\Controllers\OrdenTrabajoController;
use App\Http\Controllers\OrdenTrabajoExportController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProgramacionController;
use App\Http\Controllers\ProgramacionExportController;
use App\Http\Controllers\TuControlador;
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

    Route::get('/programacion/export', [ProgramacionExportController::class, 'export'])->name('programacion.export');
    Route::get('programacion/{item_orden_trabajo}', [ProgramacionController::class, 'show'])->name('programacion.show');
    Route::resource('programacion', ProgramacionController::class)->names('programacion');

});

require __DIR__.'/auth.php';
