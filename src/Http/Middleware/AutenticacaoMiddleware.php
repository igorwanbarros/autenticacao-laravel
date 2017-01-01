<?php

namespace Igorwanbarros\Autenticacao\Http\Middleware;

use Illuminate\Http\Request;

class AutenticacaoMiddleware
{

    public function handle(Request $request, \Closure $next, $parametros = null)
    {
        if (is_null($parametros)) {
            return $next($request);
        }

        $keyPermissoes = env('APP_KEY_SESSION', 'app.session') . '.permissoes';

        if (!$request->session()->has($keyPermissoes)) {
            return redirect()->route('logout');
        }

        $permissoes = $request->session()->get($keyPermissoes);
        $parametrosArray = explode('+', $parametros);

        if ($this->_naoPossuiAcesso($parametrosArray, $permissoes)) {
            $template = $request->ajax() ? 'app-ajax' : 'app';
            $page = view('autenticacao-laravel::autenticacao.acesso-negado', compact('template'));
            return response($page, 401);
        }

        return $next($request);
    }


    protected function _naoPossuiAcesso(array $parametros, array $permissoes)
    {
        foreach ($parametros as $parametro) {
            if (!array_key_exists($parametro, $permissoes)) {
                return true;
            }
        }

        return false;
    }
}
