<?php

namespace Igorwanbarros\Autenticacao\Widgets;

use Igorwanbarros\Php2HtmlLaravel\Form\FormViewLaravel;
use Igorwanbarros\Php2HtmlLaravel\Form\Fields\HiddenField;
use Igorwanbarros\Php2HtmlLaravel\Form\Fields\AutocompleteField;

class FormDashboard extends FormViewLaravel
{
    public function beforeCreate()
    {
        $this->convertTypeFieldsByName['user_id'] = HiddenField::class;
        $this->convertTypeFieldsByName['dashboard_name'] = HiddenField::class;
        $this->addField(AutocompleteField::create('dashboard_titulo', 'Dashboard')
             ->setLabelRequired()
             ->sourceStatic(app('dashboard')->toArray(), 'alias')
             ->callbackScript('onClick', "$('#dashboard_name').val(item.name);$('#titulo').val(item.alias);", true)
        );
    }


    public function afterCreate()
    {
        $this->getField('user_id')->setValue(app_session('user_id'));
        $this->getField('tamanho')->setDefaultOption(false);
    }


    public function fill($data)
    {
        parent::fill($data);

        if (($dashboardName = $this->getField('dashboard_name')) && $this->getField('dashboard_titulo')) {
            $dashboard = app('dashboard')->lists('alias');
            if (array_key_exists($dashboardName->getValue(), $dashboard)) {
                $this->getField('dashboard_titulo')->setValue($dashboard[$dashboardName->getValue()]);
            }
        }

        return $this;
    }


    public function search($action = null)
    {
        parent::search($action);

        $this->getField('tamanho')->setDefaultOption('[selecione]');
        $this->getField('dashboard_titulo')
             ->callbackScript('onClick', "$('#dashboard_name').val(item.name);", false);

        return $this;
    }
}
