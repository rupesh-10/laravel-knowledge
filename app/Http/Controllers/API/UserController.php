<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\User\UserServices;

class UserController extends ApiController
{

    private $userServices;

    public function __construct(UserServices $userServices)
    {
        $this->userServices = $userServices;
    }

    public function updateProfile(Request $request, $id)
    {
        $rules = [
            'user_name' => 'min:4|max:20',
            'avatar' => 'image|dimensions:width=256,height=256',
            'password' => 'min:6',
        ];
        $response = $this->validateApiRequest($rules);
        if($response!==true) return $response;
        $user = User::find($id);
        $updated = $this->userServices->updateUser($request->all(),$user);
        if ($updated){
            return $this->successResponse($updated);
        }
        return $this->failResponse();
    }
}
