<?php

namespace Igorwanbarros\Autenticacao\Widgets;

use Igorwanbarros\Php2HtmlLaravel\Form\FormViewLaravel;

class FormEmpresa extends FormViewLaravel
{

    public function afterCreate()
    {
        $this->setAction('empresas/salvar')
            ->setMethod('POST');
    }


    public function search($action = null)
    {
        unset($this->fields['inscricao_estadual']);
        unset($this->fields['inscricao_municipal']);
        unset($this->fields['email_principal']);
        unset($this->fields['ddd']);
        unset($this->fields['telefone_principal']);

        return parent::search($action);
    }

}
