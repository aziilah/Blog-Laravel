<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

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
        //letak Bootstrap template sebagai pagination 
        Paginator::useBootstrap();

        //Gates
        //definisi sebuah Gate yg bernama'admin'..
        //..yg boleh diakses oleh user yg username dia ialah ilah
        Gate::define('admin', function(User $user) {
        //    return $user->username === 'ilah';  //utk manual

        //cek di field 'is_admin' dalam table Users 
        //if true (1) = admin
        return $user->is_admin; 

        });

    }
}
