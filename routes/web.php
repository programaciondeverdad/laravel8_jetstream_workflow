<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TramiteController;

use App\Models\TramiteTipo;
use App\Models\Tramite;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia\Inertia::render('Dashboard');
})->name('dashboard');



Route::middleware(['auth:sanctum', 'verified'])
    ->get('/public/home', [HomeController::class, 'index'])
    ->name('home');


Route::middleware(['auth:sanctum', 'verified'])
    ->get('/admin/', [HomeController::class, 'panelControlAdmin'])
    ->name('panelControlAdmin');

// Tramites 
// TODO: Crear archivo de configuración de urls y en RouteServiceProvider.php
/*Route::middleware(['auth:sanctum', 'verified'])
    ->get('/tramite/certificado-ausencia/', [TramiteController::class, 'index'])
    ->name('panelControlAdmin');*/

Route::middleware(['auth:sanctum', 'verified'])
    ->get('/tramite/{tramiteTipo:slug}/{tramite?}', [TramiteController::class, 'index'])
    ->name('tramite');

/*
// Modos Implícitos
// Con este modo debemos agregar una función en el Modelo TramiteTipo (getRouteKeyName())
Route::get('/tramite/{tramiteTipo}/', function (TramiteTipo $tramiteTipo) {
    return $tramiteTipo;
});

// Con este modo no debemos configurar nada más, solo traer la clase!
Route::get('/tramite/{tramiteTipo:slug}/', function (TramiteTipo $tramiteTipo) {
    return $tramiteTipo;
});


// Modo Explícito
// Además hay que agregar en RouteServiceProvider.php:
// Route::model('tramiteTipo', TramiteTipo::class);
Route::get('/tramite/{tramiteTipo}/', function (TramiteTipo $tramiteTipo) {
    return $tramiteTipo;
});
*/