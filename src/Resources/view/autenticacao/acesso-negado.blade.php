@extends($template)
@section('content')

@if($template == 'app')
<div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2">
    <div class="box box-danger">
        <div class="box-header">
@endif
            <h2 class="box-title text-danger">Acesso negado!</h2>
@if($template == 'app')
        </div>
        <div class="box-body">
@endif
            <div class="col-sm-3 hidden-xs text-center text-red">
                <i class="fa fa-lock fa-5x" style="padding-top: 0.1em"></i>
            </div>
            <div class="col-sm-9 col-xs-12 text-danger text-justify">
                <h4 class="">
                    Você não possui permissão para acessa a página solicitada.
                </h4>

                <h5>
                    Para solucionar este problema, solicite permissão para visualizar esta página ou entre em contato
                    com o administrador do sistema!
                </h5>
            </div>

@if($template == 'app')
            <div class="col-xs-12 padding-top-2x">
                <a href="{{url()}}" class="btn btn-flat btn-default">
                    <i class="fa fa-chevron-circle-left fa-fw"></i>
                    Voltar para o site
                </a>
            </div>
        </div>
    </div>
</div>
@endif
@stop
