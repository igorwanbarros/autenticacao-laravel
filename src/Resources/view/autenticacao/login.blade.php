@extends('app-login')
@section('content')
    <p class="login-box-msg">
        Preencha os campos para iniciar sua sessão.
    </p>

    <form action="{{url('/autenticacao/login')}}" method="POST">
        <input type="hidden" name="_token" value="{{csrf_token()}}" />
        <div class="form-group has-feedback">
            <input type="email" class="form-control" placeholder="Email" name="email" value="{{old('email')}}">
            <span class="fa fa-envelope-o form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <input type="password" class="form-control" placeholder="Senha" name="password">
            <span class="fa fa-lock form-control-feedback"></span>
        </div>
        <div class="row">
            <div class="col-xs-offset-8 col-xs-4">
                <button type="submit" class="btn btn-primary btn-block btn-flat">
                    <span class="fa fa-sign-in fa-fw"></span> Entrar
                </button>
            </div>
        </div>
    </form>

    {{--<div class="social-auth-links text-center">--}}
        {{--<a href="{{url('/')}}" class="">Esqueci minha Senha</a><br>--}}
    {{--</div>--}}

    <br />
    <br />
    @if (count($errors) > 0)
        <div class="callout callout-warning">
            <i class="close icon"></i>

            <h4>Acesso negado</h4>
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif
@stop