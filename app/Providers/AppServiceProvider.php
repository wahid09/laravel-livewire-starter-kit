<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::if('role', function ($role) {
            return Auth::user()->role->slug == $role;
        });

        Blade::if('permission', function ($permission) {
            //dd($permission);
            return Auth::user()->hasPermission($permission);
        });
    }
}