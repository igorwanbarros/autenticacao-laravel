<?php

namespace Igorwanbarros\Autenticacao\Providers;

use App\Providers\AuthServiceProvider;

class AutenticacaoServiceProvider extends AuthServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        parent::register();
    }


    public function boot()
    {
        parent::boot();
    }
}
