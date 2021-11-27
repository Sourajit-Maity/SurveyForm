<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
         'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('isDirector', function($user) {
            return $user->company_id == '1';
         });
        
         /* define a manager user role */
         Gate::define('isManager', function($user) {
             return $user->company_id == 'manager';
         });
       
         /* define a user role */
         Gate::define('isUser', function($user) {
             return $user->company_id == 'user';
         });
    }
}
