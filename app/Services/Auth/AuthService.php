<?php

namespace App\Services\Auth;

use App\Models\User;
use App\Services\Service;
use Illuminate\Support\Facades\Auth;

class AuthService extends Service
{
    public function getAuthenticatedUser()
    {
        return Auth::user();
    }

    public function getCompanyAuth()
    {
        return $this->getAuthenticatedUser()->company ?? null;
    }

    public function autoLogin($user)
    {
        Auth::login($user);
    }

    public function IsSuperUser()
    {
        $user = $this->getAuthenticatedUser()->id;
        $user = User::find($user);

        return $user && $user->isOwnerSystem();
    }
}
