<?php

namespace App\Http\Middleware;

use App\Models\PoolRound;
use App\Models\Prediction;
use Closure;
use Betpool\Pool\Domain\Pool;
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

            $Pool = $this->getPoolByRequest($request);

            $Pool && $Pool->doesItbelongsToThePool(auth()->user());

        } catch (\Exception $exception) {

            var_dump("excepcion cayo" . $exception->getMessage());

            die();
        }

        return $next($request);
    }

    private function getPoolByRequest(Request $request): Pool|null
    {
        if ($request->getMethod() == 'GET') {

            $idPool = $request->route()->parameter('id_pool');

            $idPoolRound = $request->route()->parameter('id_pool_round');

            /** @var Pool $Pool */
            $Pool = $idPool ? Pool::find($idPool) : PoolRound::find($idPoolRound)->pool;

        }elseif ($request->getMethod() == 'POST' ) {

            $idPool = $request->get('id_pool') ?  : $request->route()->parameter('id_pool');

            $idPoolRound = $request->get('id_pool_round');

            /** @var Pool $Pool */
            $Pool = $idPool ? Pool::find($idPool) : PoolRound::find($idPoolRound)->pool;
        }else{

            $idPrediction = $request->route()->parameter('prediction_id');

            $Prediction = Prediction::find($idPrediction);

            $idPrediction && $Pool = $Prediction->pool;
        }

        return $Pool ? : null;
    }
}
