<?php

namespace Igorwanbarros\Autenticacao\Widgets;

use Igorwanbarros\Autenticacao\Models\User;
use Igorwanbarros\Php2HtmlLaravel\Form\FormViewLaravel;
use Igorwanbarros\Php2HtmlLaravel\Form\Fields\HiddenField;
use Igorwanbarros\Php2HtmlLaravel\Form\Fields\AutocompleteField;

class FormPerfisUsuario extends FormViewLaravel
{

    public function personalize($perfilId)
    {
        $template = '<span class="col-sm-">' .
                '{{name}} <span class="pull-right text-muted">{{razao_social}}</span>' .
            '</span>';

        return $this->setMethod('POST')
            ->addAttribute('data-target', '#tabs-usuarios')
            ->addAttribute('class', 'submit ajax')
            ->addField(HiddenField::create('perfil_id', '', $perfilId))
            ->addField(HiddenField::create('empresa_id'))
            ->addField(
                AutocompleteField::create('user_id', 'Usuário', User::class)
                    ->sourceDynamic(url("perfis/{$perfilId}/usuarios/autocomplete"), 'name')
                    ->optionTemplate($template)
                    ->callbackScript('onClick', "$('#empresa_id').val(item.empresa_id)", true)
                    ->addRule('required')
                    ->setLabelRequired()
            );
    }
}
