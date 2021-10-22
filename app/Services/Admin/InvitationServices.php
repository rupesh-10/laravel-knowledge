<?php
namespace App\Services\Admin;

use App\Mail\InvitationMail;
use App\Mail\SendVerificationCodeMail;
use App\Models\Invitation;
use Illuminate\Support\Facades\Mail;

class InvitationServices {
    public function inviteUser($email){
        $invitation =  Invitation::create([
            'email' => $email,
            'invitation_token' => substr(md5(rand(0, 9) . $email . now()), 0, 32),
            'registered_at' => null,
            'expires_at' => now()->addMinutes(30)
       ]);
        Mail::to($email)->send(
            new InvitationMail($invitation->link)
        );
       return $invitation;
    }

    public function sendCode($invitation){
        try {
            $code = random_int(100000, 999999);
            $invitation->update(['registered_at' => now(), 'verification_code' => $code, 'expires_at' => now()->addMinutes(30)]);
            Mail::to($invitation->email)->send(
                new SendVerificationCodeMail($code)
            );
            return true;
        }catch (\Throwable $throwable)
        {
            return false;
        }
    }
}
