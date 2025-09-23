<?php

namespace App\Actions\Fortify;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class CustomLoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        $user = $request->user();

        if ($user->is_admin) {
            return redirect()->intended('/admin/dashboard'); 
        }

        return redirect()->intended('/dashboard'); 
    }
}
