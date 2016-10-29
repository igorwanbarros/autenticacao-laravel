<?php

namespace Igorwanbarros\Autenticacao\Providers;

use Illuminate\Support\ServiceProvider;

class AutenticacaoServiceProvider extends ServiceProvider
{
    protected static $acls = [];


    /**
     * @return void
     */
    public function register()
    {

    }


    /**
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../Migrations' => base_path('database/migrations/'),
        ]);
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
}
