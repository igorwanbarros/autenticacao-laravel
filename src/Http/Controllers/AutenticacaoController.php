<?php

namespace Igorwanbarros\Autenticacao\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Igorwanbarros\Autenticacao\Models\User;
use Igorwanbarros\Autenticacao\Models\Perfil;
use Igorwanbarros\Autenticacao\Models\Empresa;
use Igorwanbarros\Php2HtmlLaravel\Panel\PanelViewLaravel;
use Igorwanbarros\BaseLaravel\Http\Controllers\BaseController;

class AutenticacaoController extends BaseController
{
    protected $keySession;

    protected $routeSuccess = 'home';


    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->keySession = env('APP_KEY_SESSION', 'app.session');
    }


    public function index()
    {
        return view('autenticacao-laravel::autenticacao.login');
    }


    public function login()
    {
        $attempt = Auth::attempt([
            'email'     => $this->request->input('email'),
            'password'  => $this->request->input('password')
        ]);

        if ($attempt) {
            $this->_configurarSession();
            return redirect($this->routeSuccess);
        }

        return redirect()->back()
            ->withInput($this->request->only('email'))
            ->withErrors([
                'email' => 'Não consegui encontrar um usuário que contenha os dados informados.',
            ]);
    }


    public function logout()
    {
        $this->_configurarSession(false);
        $this->request->session()->forget('login');
        Auth::logout();
        return redirect()->route('login');
    }


    public function perfis($userId = null)
    {
        $user = User::findOrNew($userId);
        $perfis = DB::table('autenticacao_users')
            ->join('autenticacao_users_perfis', 'autenticacao_users_perfis.user_id', '=', 'autenticacao_users.id')
            ->join('autenticacao_perfis', 'autenticacao_users_perfis.perfil_id', '=', 'autenticacao_perfis.id')
            ->join('autenticacao_empresas', 'autenticacao_users_perfis.empresa_id', '=', 'autenticacao_empresas.id')
            ->where('autenticacao_users.id', '=', $userId)
            ->get();
        $widget = '';

        foreach($perfis as $perfil) {
            $body = view('autenticacao-laravel::autenticacao.perfil', compact('user', 'perfil'));
            $widget .= new PanelViewLaravel(null, $body);
        }

        return view('autenticacao-laravel::autenticacao.show-perfis', compact('widget', 'user'));
    }


    public function selecionarPerfil($userId, $perfilId, $empresaId)
    {
        $user = User::findOrNew($userId);
        $perfil = Perfil::findOrNew($perfilId);
        $empresa = Empresa::findOrNew($empresaId);
        $this->_writeInSession($user, $perfil, $empresa);

        return redirect()->route($this->routeSuccess);
    }


    protected function _configurarSession($setSession = true)
    {
        if (!$setSession) {
            $this->request->session()->forget($this->keySession);
            return $this;
        }

        $this->_setDataSession();

        return $this;
    }


    protected function _setDataSession()
    {
        $user = Auth::getLastAttempted();

        if (!method_exists($user, 'perfis')) {
            return;
        }

        if ($user->perfis()->count() > 1) {
            $this->routeSuccess = 'autenticacao/perfil-usuario/' . $user->id;
            return;
        }

        $perfil = $user->perfis->first();
        $empresa = $user->empresas->first();

        if ($perfil && $empresa) {
            $this->_writeInSession($user, $perfil, $empresa);
        }
    }


    protected function _writeInSession(User $user, Perfil $perfil, Empresa $empresa)
    {
        $session = [
            'user_id'                   => $user->id,
            'user_name'                 => $user->name,
            'user_email'                => $user->email,

            'empresa_id'                => $empresa->id,
            'empresa_razao_social'      => $empresa->razao_social,
            'empresa_nome_fantasia'     => $empresa->nome_fantasia,
            'empresa_cnpj'              => $empresa->cnpj,

            'perfil_id'                 => $perfil->id,
            'perfil'                    => $perfil->nome,

            'permissoes'                => null,
        ];

        $permissoes = $perfil->permissoes;

        if ($permissoes) {
            $permissoes = array_column($permissoes->toArray(), 'slug', 'slug');
            $session['permissoes'] = $permissoes;
        }

        $this->request->session()->put($this->keySession, $session);
        $this->request->session()->save();
    }
}
