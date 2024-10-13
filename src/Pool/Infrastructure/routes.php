<?php

use Illuminate\Support\Facades\Route;
use Betpool\Pool\Features\InviteGuest\InviteGuestToPoolController;
use App\Http\Middleware\EnsureBelongsToPool;

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {


    Route::post('/pool/{id_pool}/invite-guest', InviteGuestToPoolController::class)
        ->name('pool.post.invite-guest')
        ->middleware(EnsureBelongsToPool::class);
});
