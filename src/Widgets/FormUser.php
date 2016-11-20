<?php

namespace Igorwanbarros\Autenticacao\Widgets;

use Igorwanbarros\Php2HtmlLaravel\Form\FormViewLaravel;
use Igorwanbarros\Php2HtmlLaravel\Form\Fields\PasswordField;

class FormUser extends FormViewLaravel
{

    public function beforeCreate()
    {
        $this->removeFieldsByName['login_count'] = 'login_count';
        $this->removeFieldsByName['login_attempt'] = 'login_attempt';
        $this->removeFieldsByName['remember_token'] = 'remember_token';
        $this->convertTypeFieldsByName['password'] = PasswordField::class;
    }


    public function afterCreate()
    {
        $this->setAction('autenticacao/usuarios');

        $this->setAction('autenticacao/usuarios/salvar')
            ->setMethod('POST');

        $this->addField(
            PasswordField::create('retype_password', 'Redigitar Senha')
            ->addRule('required_with:password|same:password|')
        );

        $this->getField('password')
            ->setRule('required_with:retype_password|')
            ->setLabel('Senha');

        $this->getField('name')
            ->setLabel('Nome')
            ->setSize(8);

        $this->getField('email')->setSize(4);
    }


    public function search($action = null)
    {
        unset($this->fields['password']);
        unset($this->fields['retype_password']);

        return parent::search($action);
    }


    public function fill($data)
    {
        if (is_object($data) && isset($data->password)) {
            unset($data->password);
        }
        if (is_object($data) && isset($data->retype_password)) {
            unset($data->retype_password);
        }

        if (is_array($data) && array_key_exists('password', $data)) {
            unset($data['password']);
        }
        if (is_array($data) && array_key_exists('retype_password', $data)) {
            unset($data['retype_password']);
        }

        return parent::fill($data);
    }
}
