<?php
$url = 'autenticacao/perfil-usuario/' . $perfil->user_id . '/' . $perfil->perfil_id . '/' . $perfil->empresa_id;
?>

<div class="row" style="padding-bottom: 2.5em;">
    <div class="col-xs-4 text-center">
        <a href="{{url($url)}}">
            <i class="fa fa-4x fa-address-card text-light-blue"></i>
        </a>
    </div>
    <div class="col-xs-8">
        <div class="profile-username">
            <a href="{{url($url)}}" class="text-light-blue">
                {{$perfil->nome}}
            </a>

        </div>
        <p>
            <a href="{{url($url)}}" class="text-light-blue">
            <span class="text-muted">
            Empresa:
            </span>
                {{$perfil->nome_fantasia}}
            </a>
        </p>
    </div>
</div>
