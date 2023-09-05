<?php

namespace App\Http\Middleware;

use App\Models\Pool;
use App\Models\PoolRound;
use Closure;
use Illuminate\Http\Request;

class EnsureBelongsToPool
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request                                                                          $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse) $next
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        try {

            if ($request->getMethod() == 'GET') {

                $idPool = $request->route()->parameter('id_pool');

                $idPoolRound = $request->route()->parameter('id_pool_round');

                /** @var Pool $Pool */
                $Pool = $idPool ? Pool::find($idPool) : PoolRound::find($idPoolRound)->pool;

                if ($Pool) {
                    $Pool->doesItbelongsToThePool(auth()->user());
                }
            }

        } catch (\Exception $exception) {
            var_dump("excepcion cayo". $exception->getMessage());
            die();
        }

        return $next($request);
    }
}
