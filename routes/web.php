<?php

use App\Http\Controllers\TestController;
use App\Http\Controllers\ViewControllers\PoolViewController;
use App\Http\Controllers\ViewControllers\PoolRoundViewController;
use App\Http\Controllers\ViewControllers\PredictionViewController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [TestController::class, 'hola'])->name('dashboard');
    
    //Pool routes
    Route::get('/pool/{id}', [PoolViewController::class, 'getPoolIndividualView'])->name('pool.indiviual-view');
    
    //Pool Round Routes
    Route::get('/pool-round/{id}', [PoolRoundViewController::class, 'getPoolRoundIndividualView'])->name('pool-round.indiviual-view');
    
    //Predictions routes
    Route::get('/create-predictions', [PredictionViewController::class, 'createPredictionsView'])->name('predictions.create-view');

});
