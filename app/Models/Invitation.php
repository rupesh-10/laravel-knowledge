<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    use HasFactory;

    protected $fillable = [
        'email', 'invitation_token', 'registered_at','verification_code','expires_at'
    ];
    protected $appends = ['link'];

    public function getLinkAttribute(): string
    {
        return urldecode(route('confirm') . '?token=' . $this->token);
    }
}
