<?php
namespace App\Services\User;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserServices {
    
    // Create New User
    public function createUser($data){
        $data['password'] = Hash::make($data['password']);
        $data['avatar'] = 'avatar/avatar.jpg';
        $data['registered_at'] = now();
        $data['user_role'] = User::IS_USER;
        $data['user_name'] = $data['user_name'];
        $user = User::create($data);
        $user->createToken('Personal Access Token');
        return $user;
    }

    public function updateUser($data, $user){
        $data['user_role'] = User::IS_USER;
        if(isset($data['avatar'])){
        $image_name = uniqid('avatar_', true) . '.jpg';
        $image = \Image::make($data['avatar'])->stream('jpg');
        $data['avatar'] = 'avatar/'.$image_name;
        Storage::disk('public')->put('/avatar/'.$image_name, $image);
        }
        if(isset($data['password']))  $data['password'] = Hash::make($data['password']);
        return $user->update($data);
    }
}