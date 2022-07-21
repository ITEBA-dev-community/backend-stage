<?php

namespace App\Providers;

use App\Guard\ApiTokenGuard;
use App\Extension\TokenUserProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // extend field api_token in table user_active, we can use this field to validate the user token
        Auth::extend('api_token', function ($app, $name, array $config) {
            
            // propery $config is from auth.guard.api
            // example of property $config,
            // driver, provider or something else we put in array auth.guard.api
            // for now we just put driver

			// build object of TokenUserProvider and request
			$TokenUserProvider = app(TokenUserProvider::class);
			$request = app('request');
            
			return new ApiTokenGuard($TokenUserProvider, $request, $config);
		});
    }
}
