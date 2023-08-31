<?php

namespace App\Http\Controllers\ApiControllers;

use App\Actions\PoolInvitationsEmails\AcceptOrRejectInvitation;
use App\Actions\Prediction\ModifyPrediction;
use App\Http\Controllers\Controller;
use App\Models\PoolInvitationsEmails;
use App\Models\Prediction;
use Illuminate\Http\Request;

class PoolInvitationsPatchController extends Controller
{

    public function __construct(public AcceptOrRejectInvitation $acceptOrRejectInvitation)
    {
    }


    public function __invoke($idInvitationPool, Request $request)
    {
        $PoolInvitationsEmails = PoolInvitationsEmails::find($idInvitationPool);

        $this->acceptOrRejectInvitation->__invoke(
            $PoolInvitationsEmails,
            $request->get('accepted'),
            auth()->user()->id
        );

        return response()->json([
            'status' => 'true',
            'item' => "hola"
        ], 200);
    }

}