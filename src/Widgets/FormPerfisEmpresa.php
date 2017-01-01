<?php

namespace Igorwanbarros\Autenticacao\Widgets;

use Igorwanbarros\Autenticacao\Models\Perfil;
use Igorwanbarros\Php2HtmlLaravel\Form\FormViewLaravel;
use Igorwanbarros\Php2HtmlLaravel\Form\Fields\HiddenField;
use Igorwanbarros\Php2HtmlLaravel\Form\Fields\AutocompleteField;

class FormPerfisEmpresa extends FormViewLaravel
{

    public function personalize($empresaId)
    {
        $this->setMethod('POST')
             ->addAttribute('data-target', '#tabs-perfil')
             ->addAttribute('class', 'submit ajax');

        $this->addField(
            AutocompleteField::create('perfil_id', 'Perfil', Perfil::class)
                ->sourceDynamic(url("empresas/{$empresaId}/perfis/autocomplete"), 'nome')
                ->addRule('required')
                ->setLabelRequired()
        );

        $this->addField(
            HiddenField::create('empresa_id', '', $empresaId)
        );

        return $this;
    }
}
