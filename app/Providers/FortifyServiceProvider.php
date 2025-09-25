<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Actions\Fortify\CustomLoginResponse;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use App\Models\User;

class FortifyServiceProvider extends ServiceProvider
{
   
    public function register(): void
    {
        //
    }

   
    public function boot(): void
    {
        // Bind custom login response
        $this->app->singleton(LoginResponseContract::class, CustomLoginResponse::class);

        // Fortify default actions
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        // Custom authentication logic (admin vs normal user)
        Fortify::authenticateUsing(function (Request $request) {
            $user = User::where('email', $request->email)->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                return null;
            }

            // Admin login - only allow admin users to login via admin route
            if ($request->routeIs('admin.login.submit')) {
                if ($user->is_admin) {
                    return $user;
                }
                return null; // Non-admin users cannot login via admin route
            }

            // Normal user login - only allow non-admin users to login via normal route
            if ($request->routeIs('login.store')) {
                if (!$user->is_admin) {
                    return $user;
                }
                return null; // Admin users cannot login via normal route
            }

            return $user; // Default fallback
        });



        // Rate limiter for login
        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())) . '|' . $request->ip());
            return Limit::perMinute(5)->by($throttleKey);
        });

        // Rate limiter for two-factor authentication
        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });
    }
}
