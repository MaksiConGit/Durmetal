<?php

use App\Http\Controllers\CityController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\ItemOrdenTrabajoController;
use App\Http\Controllers\OrdenTrabajoController;
use App\Http\Controllers\ProfileController;
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
    Route::get('/export', [ExportController::class, 'export'])->name('clients.export');
    Route::get('/cities/search', [CityController::class, 'search'])->name('cities.search');

    Route::resource('orden-trabajo', OrdenTrabajoController::class)->names('orden-trabajo');

    Route::get('/item-orden-trabajo/create/{orden_trabajo}', [ItemOrdenTrabajoController::class, 'create'])->name('item-orden-trabajo.create');
    Route::post('/item-orden-trabajo/{orden_trabajo}', [ItemOrdenTrabajoController::class, 'store'])->name('item-orden-trabajo.store');

    // Route::resource('item-orden-trabajo', ItemOrdenTrabajoController::class)->names('item-orden-trabajo');

});

require __DIR__.'/auth.php';
