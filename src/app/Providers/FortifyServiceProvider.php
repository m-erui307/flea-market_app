<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;
use Laravel\Fortify\Contracts\LogoutResponse as LogoutResponseContract;
use App\Responses\CustomLoginResponse;
use App\Responses\CustomRegisterResponse;
use App\Responses\LogoutResponse;


class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(
        CreatesNewUsers::class,
        CreateNewUser::class
        );

        $this->app->singleton(LoginResponseContract::class, \App\Responses\LoginResponse::class);
        $this->app->singleton(RegisterResponseContract::class, \App\Responses\RegisterResponse::class);

        $this->app->singleton(LogoutResponseContract::class, LogoutResponse::class);
    }


    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::registerView(function () {
        return view('auth.register');
        });

        Fortify::loginView(function () {
        return view('auth.login');
        });

    }
}