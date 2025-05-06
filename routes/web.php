<?php

use App\Http\Controllers\CityController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ExportController;
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

});

require __DIR__.'/auth.php';
