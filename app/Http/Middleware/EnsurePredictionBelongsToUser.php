<?php

namespace App\Http\Middleware;

use App\Models\Prediction;
use Closure;
use Betpool\Pool\Domain\Pool;
use Illuminate\Http\Request;

class EnsurePredictionBelongsToUser
{
    /**
     * @param Request $request
     * @param Closure $next
     *
     * @return mixed|void
     */
    public function handle(Request $request, Closure $next)
    {
        try {

            $Prediction = $this->getPredictionByRequest($request);

            if($Prediction->user->id !== auth()->user()->id){

                var_dump("acceso no autorizado");

                die();

            }


        } catch (\Exception $exception) {

            var_dump("excepcion cayo" . $exception->getMessage());

            die();
        }

        return $next($request);
    }

    private function getPredictionByRequest(Request $request): Prediction|null
    {
        if ($request->getMethod() == 'GET') {

            $idPrediction = $request->route()->parameter('prediction_id');

            /** @var Pool $Pool */
             $idPrediction && $Prediction = Prediction::find($idPrediction);

        }

        return $Prediction ? : null;
    }
}
