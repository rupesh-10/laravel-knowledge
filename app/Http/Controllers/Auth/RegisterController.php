<?php


namespace App\Http\Controllers\Auth;


use App\Core\Admin\UpdateInvitation;
use App\Core\User\CreateUser;
use App\Http\Controllers\Api\ApiController;
use App\Models\Invitation;
use Illuminate\Http\Request;
use App\Services\User\UserServices;
use App\Services\Admin\InvitationServices;
class RegisterController extends ApiController
{

    protected $userServices;
    protected $invitationServices;

    public function __construct(UserServices $userServices, InvitationServices $invitationServices)
    {
        $this->userServices = $userServices;
        $this->invitationServices = $invitationServices;
    }
    // Register New User
    public function register(Request $request)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'user_name' => 'required|min:4|max:20',
            'password' => 'required|min:6',
        ];
        $response = $this->validateApiRequest($rules);
        if ($response!==true)  return $response;
    
        $created = $this->userServices->createUser($request->all());
        if ($created){
            return $this->successResponse($created);
        }
        return $this->failResponse();
    }

    // Confirm the Invitation
    public function confirmInvitation(Request $request): \Illuminate\Http\JsonResponse
    {
     
        $invitation = Invitation::where('invitation_token', $request['invitation_token'])->firstOrFail();
        $updated = $this->invitationServices->sendCode($invitation);
        if ($updated){
            return $this->successResponse($updated);
        }
        return $this->failResponse();
    }

}
