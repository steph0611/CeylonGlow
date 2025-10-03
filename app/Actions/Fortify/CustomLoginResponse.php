<?php

namespace App\Actions\Fortify;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class CustomLoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        $user = $request->user();

        // Check if this is an API request
        if ($request->expectsJson() || $request->is('api/*')) {
            // Create API token for API requests
            $token = $user->createToken('api-token')->plainTextToken;
            
            return response()->json([
                'success' => true,
                'message' => 'Login successful',
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'is_admin' => $user->is_admin,
                ],
                'token' => $token,
                'token_type' => 'Bearer'
            ]);
        }

        // Web request - redirect as before
        if ($user->is_admin) {
            return redirect()->intended('/admin/dashboard'); 
        }

        return redirect()->intended('/dashboard'); 
    }
}
