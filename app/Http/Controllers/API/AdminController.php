<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Invitation;
use Illuminate\Http\Request;
use App\Services\Admin\InvitationServices;


class AdminController extends ApiController
{

    private $invitationServices;

    public function __construct(InvitationServices $invitationServices)
    {
        $this->invitationServices = $invitationServices;
        
    }
    public function invite(Request $request){
        $rules = [
            'email' => 'required|email|unique:invitations'
        ]; 

        $response = $this->validateApiRequest($rules);

        if($response!==true) return $response;
 

        $invite = $this->invitationServices->inviteUser($request['email']);

        if ($invite){
            return $this->successResponse($invite);
        }
        return $this->failResponse();
    }
}
