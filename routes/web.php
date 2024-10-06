<?php

use App\Http\Controllers\ApiControllers\PoolInvitationsPatchController;
use App\Http\Controllers\ApiControllers\PoolPostController;
use App\Http\Controllers\ApiControllers\PoolRoundPostController;
use App\Http\Controllers\ApiControllers\PredictionPatchController;
use App\Http\Controllers\ApiControllers\PredictionPostController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\ViewControllers\PoolViewController;
use App\Http\Controllers\ViewControllers\PoolRoundViewController;
use App\Http\Controllers\ViewControllers\PredictionViewController;
use App\Http\Controllers\ApiControllers\PoolAddUsersController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Middleware\EnsureBelongsToPool;

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

    /**
     * Views controller
     */

    Route::get('/dashboard', [TestController::class, 'hola'])->name('dashboard');

    //Pool routes
    Route::get('/pool/{id_pool}', [PoolViewController::class, 'getPoolIndividualView'])->name('pool.indiviual-view')
        ->middleware(EnsureBelongsToPool::class);

    Route::get('/pool-create-view/', [PoolViewController::class, 'getPoolCreateView'])->name('pool.create-view');

    //Pool Round Routes
    Route::get('/pool-round/{id_pool_round}', [PoolRoundViewController::class, 'getPoolRoundIndividualView'])->name('pool-round.indiviual-view')
        ->middleware(EnsureBelongsToPool::class);

    Route::get('/pool-round-create-view/{id_pool}', [PoolRoundViewController::class, 'getPoolRoundCreateView'])
        ->name('pool-round.create-view')
        ->middleware(EnsureBelongsToPool::class);

    //Predictions routes
    Route::get('/create-predictions/{id_pool_round}', [PredictionViewController::class, 'createPredictionsView'])
        ->name('predictions.create-view')
        ->middleware(EnsureBelongsToPool::class);

    //todo: edit prediction add middelware
    Route::get('/edit-predictions/{prediction_id}', [PredictionViewController::class, 'editPredictionsView'])->name('predictions.edit-view')->middleware(\App\Http\Middleware\EnsurePredictionBelongsToUser::class);


    /**
     * end Views controller
     */


    Route::post('/pools', PoolPostController::class)
        ->name('pool.store');

    Route::post('/pool-rounds', PoolRoundPostController::class)
        ->name('pool-round.store')
        ->middleware(EnsureBelongsToPool::class);

    Route::post('/predictions', PredictionPostController::class)
        ->name('predictions.store')
        ->middleware(EnsureBelongsToPool::class);

    Route::patch('/predictions/{prediction_id}', PredictionPatchController::class)
        ->name('predictions.put')
        ->middleware(EnsureBelongsToPool::class);

    Route::patch('/pool-invitations/{pools_invitations_id}', PoolInvitationsPatchController::class)->name('pools-invitations-emails.patch');

    Route::delete('/pools/{pool_id}', \App\Http\Controllers\ApiControllers\PoolDeleteController::class)
        ->name('pool.delete');

    Route::post('/pool/{id_pool}/add-user', PoolAddUsersController::class)
        ->name('pool.post.add-user')
        ->middleware(EnsureBelongsToPool::class);
});
