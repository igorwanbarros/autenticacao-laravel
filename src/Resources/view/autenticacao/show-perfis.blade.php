@extends('base')
@section('content')
    <div class="col-xs-12 col-sm-offset-3 col-sm-6">
        <div class="col-xs-12">
            <div style="margin-bottom: 3em;">
                <h4 class="pull-left text-light-blue">{{$user->name}}</h4>
                <h4 class="pull-right">Selecione um perfil abaixo</h4>
            </div>
            <br/>
        </div>
        <div class="clearfix"></div>
        {!! $widget !!}
    </div>
@stop
