'use strict';

var autenticacaoLaravel;

function AutenticacaoLaravel ()
{
    this.beforeClickPerfilUsuario = function () {
        $('#autocomplete_user_id, .button_autocomplete_user_id')
            .removeAttr('disabled')
            .removeClass('disabled');
    };

    this.getPerfilEmpresaId = function () {
        return $('#perfil_empresa_id').val();
    };
}

$(document).ready(function () {
    autenticacaoLaravel = new AutenticacaoLaravel();
});
