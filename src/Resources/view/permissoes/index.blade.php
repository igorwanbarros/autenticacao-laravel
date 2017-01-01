@extends('app-ajax')
@section('content')
    <div class="row">
        @foreach ($acls as $acl)
        <?php
            $percent = round(($acl->qtd_adicionada * 100) / $acl->qtd_permissoes, 2);
            $percentual = number_format($percent, 2, ',', '.');
            $classColor = 'bg-yellow-active';

            if ($percent > 25) {
                $classColor = 'bg-teal-active';
            }

            if ($percent > 50) {
                $classColor = 'bg-olive';
            }

            if ($percent > 75) {
                $classColor = 'bg-green-active';
            }
            $group = urlencode($acl->group);
            $title = ucwords(str_replace(['_', '-'], ' ', $acl->group));
        ?>
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="info-box {{$classColor}}">
                <a href="{{url('perfis/' . $perfilId . '/permissoes/grupo/' . $group)}}"
                   class="info-box-icon click-modal" data-title="Editar Permissões - Grupo {{$title}}">
                    <span title="Total de Permissões" data-toggle="tooltip">{{$acl->qtd_permissoes}}</span>
                </a>

                <div class="info-box-content">
                    <a href="{{url('perfis/' . $perfilId . '/permissoes/grupo/' . $group)}}"
                       class="info-box-text click-modal" data-title="Editar Permissões - Grupo {{$title}}">
                        {{$title}}
                    </a>

                    <a href="{{url('perfis/' . $perfilId . '/permissoes/grupo/' . $group)}}"
                       class="info-box-number click-modal" data-title="Editar Permissões - Grupo {{$title}}">
                        {{$acl->qtd_adicionada}} / {{$acl->qtd_permissoes}}
                    </a>

                    <div class="progress">
                        <div class="progress-bar" style="width: {{$percent}}%"></div>
                    </div>

                    <a href="{{url('perfis/' . $perfilId . '/permissoes/grupo/' . $group)}}"
                       class="progress-description  click-modal" data-title="Editar Permissões - Grupo {{$title}}">
                        Adicionado: {{$percentual}}%
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@stop
