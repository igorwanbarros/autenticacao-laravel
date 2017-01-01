<?php

namespace Igorwanbarros\Autenticacao\Providers;

use Igorwanbarros\Autenticacao\Commands\AclsCommand;
use Igorwanbarros\Autenticacao\Managers\DashboardManager;
use Illuminate\Support\ServiceProvider;

class AutenticacaoServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register()
    {
        $this->registerMenu();
    }


    /**
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../Migrations'  => base_path('database/migrations/'),
            __DIR__ . '/../assets'      => base_path('public/assets/autenticacao-laravel/'),
        ]);

        $this->app->singleton('dashboard', function ($app) {
            return new DashboardManager();
        });

        $this->_bootViews();

        $this->app['tabs']->add(include_once __DIR__ . '/../Config/tabs.php');
        $this->app['acls']->add(include_once __DIR__ . '/../Config/acls.php');
        $this->app['dashboard']->add(include_once __DIR__ . '/../Config/dashboards.php');

        $this->commands([
            AclsCommand::class,
        ]);
    }


    /**
     * @param $index
     *
     * @return bool removido
     */
    public static function removeAcl($index)
    {
        $removido = false;

        if (array_key_exists($index, self::$acls)) {
            unset(self::$acls[$index]);
            $removido = true;
        }

        return $removido;
    }


    protected function registerMenu()
    {
        require_once __DIR__ . '/../Config/menu.php';
    }


    protected function _bootViews()
    {
        $this->loadViewsFrom(__DIR__ . '/../Resources/view', 'autenticacao-laravel');

        $this->app->group([
                'namespace' => 'Igorwanbarros\Autenticacao\Http\Controllers'
            ],
            function ($app) {
                require __DIR__ . '/../Http/routes.php';
            }
        );
    }
}
