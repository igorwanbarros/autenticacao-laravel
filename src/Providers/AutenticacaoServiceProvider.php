<?php

namespace Igorwanbarros\Autenticacao\Providers;

use Illuminate\Support\ServiceProvider;
use Igorwanbarros\Php2Html\Menu\ItemMenu;

class AutenticacaoServiceProvider extends ServiceProvider
{
    protected static $acls = [];


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
            __DIR__ . '/../Migrations' => base_path('database/migrations/'),
        ]);

        $this->app->group(['namespace' => 'Igorwanbarros\Autenticacao\Http\Controllers'], function ($app) {
            require __DIR__ . '/../Http/routes.php';
        });
    }


    /**
     * @param array       $acl
     * @param string|null $nome
     *
     * @return string index
     */
    public static function addAcl(array $acl, $nome = null)
    {
        $index = $nome ?: count(self::$acls);
        self::$acls[$index] = $acl;

        return $index;
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


    /**
     * @return array
     */
    public static function acls()
    {
        return self::$acls;
    }


    protected function registerMenu()
    {
        app('menu')
            ->createSubNivel('autenticacao', new ItemMenu('Autenticação', '#', 'fa fa-lock'))
            ->addItemSubNivel(
                'autenticacao',
                'usuarios',
                new ItemMenu(
                    'Usuários',
                    url('autenticacao/usuarios'),
                    'fa fa-circle-o'
                )
            )
            ->addItemSubNivel(
                'autenticacao',
                'perfis',
                new ItemMenu(
                    'Perfis',
                    url('autenticacao/perfis'),
                    'fa fa-circle-o'
                )
            );
    }
}
