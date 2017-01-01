<a href="{{url('/perfil/permissoes/' . $data->id)}}"
   class="btn btn-primary btn-xs" target="_blank">
    <span class="fa fa-unlock-alt fa-fw"></span>
    <span class="hidden-xs">Permissoes</span>
</a>

<a href="{{url('empresas/' . $empresaId . '/perfis/excluir/' . $data->id . '/')}}"
   class="btn btn-danger btn-xs click ajax" data-target="#tabs-perfil">
    <span class="fa fa-trash fa-fw"></span>
    <span class="hidden-xs">Excluir</span>
</a>
