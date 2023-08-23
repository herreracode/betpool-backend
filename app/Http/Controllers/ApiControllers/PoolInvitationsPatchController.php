<?php

namespace App\Http\Controllers\ApiControllers;

use App\Actions\Prediction\ModifyPrediction;
use App\Http\Controllers\Controller;
use App\Models\PoolInvitationsEmails;
use App\Models\Prediction;
use Illuminate\Http\Request;

class PoolInvitationsPatchController extends Controller
{

    public function __construct()
    {
    }


    public function __invoke($idInvitationPool, Request $request)
    {

        //todo: develop domain service with bussiness rules and unit test
        $PoolInvitationsEmails = PoolInvitationsEmails::find($idInvitationPool);

        //todo: when accept invitations, emit domain event to add user to pool
        $request->get('accepted') && $PoolInvitationsEmails->pool->addUser(auth()->user());

        $PoolInvitationsEmails->accepted = $request->get('accepted');

        $PoolInvitationsEmails->save();

        return response()->json([
            'status' => 'true',
            'item' => "hola"
        ], 200);
    }

}