<?php

namespace App\Providers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    protected $policies = [

        'App\Models\User' => 'App\Policies\UserPolicy',
    ];

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
                // Custom validation message
                Validator::extend('unique', function ($attribute, $value, $parameters, $validator) {
                    return \Illuminate\Support\Facades\DB::table($parameters[0])
                        ->where($parameters[1], $value)
                        ->count() == 0;
                });

                // Custom message for 'unique'
                Validator::replacer('unique', function ($message, $attribute, $rule, $parameters) {
                    return 'Data yang anda input sudah ada!';
                });
    }
}
