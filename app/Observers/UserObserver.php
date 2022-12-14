<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserObserver
{    
    /**
     * Handle the User "creating" event
     *
     * @param  User $user
     * @return void
     */
    public function creating(User $user): void
    {
        if ($user->isDirty('password')) {
            $user->password = Hash::make($user->password);
        }
    }
}
