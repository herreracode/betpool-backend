<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\EnsureBelongsToPool;
use Betpool\Pool\Features\View\PoolViewController;

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {


    //Pool routes
    Route::get('/pool/{id_pool}', [PoolViewController::class, 'getPoolIndividualView'])->name('pool.indiviual-view')
        ->middleware(EnsureBelongsToPool::class);

    Route::get('/pool-create-view/', [PoolViewController::class, 'getPoolCreateView'])->name('pool.create-view');
});
