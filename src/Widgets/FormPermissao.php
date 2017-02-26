<?php

namespace Igorwanbarros\Autenticacao\Widgets;

use Illuminate\Support\Collection;
use Igorwanbarros\Php2Html\Table\RowTableView;
use Igorwanbarros\Php2HtmlLaravel\Form\FormViewLaravel;
use Igorwanbarros\Php2HtmlLaravel\Form\Fields\HtmlField;
use Igorwanbarros\Php2HtmlLaravel\Table\TableViewLaravel;
use Igorwanbarros\Php2HtmlLaravel\Form\Fields\HiddenField;
use Igorwanbarros\Php2HtmlLaravel\Form\Fields\CheckboxField;

class FormPermissao extends FormViewLaravel
{

    public function editar(TableViewLaravel $table, $perfilId, Collection $permissoesSelecionadas)
    {
        $this->setAction(url("perfis/{$perfilId}/permissoes/salvar"))
            ->addAttribute('class', 'submit ajax close-modal')
            ->addAttribute('data-target', '#tabs-permissoes');

        unset($this->fields['group']);
        unset($this->fields['title']);
        unset($this->fields['slug']);
        unset($this->fields['description']);
        $table->callback($this->_rowTableView($permissoesSelecionadas))
              ->checkHeader();
        $this->addField(HtmlField::create('table', 'div', $table));

        $arrayGroup = array_column($table->getCollection()->get()->toArray(), 'id');
        $this->addField(HiddenField::create('group', '', implode(',', $arrayGroup)));

        return $this;
    }

    protected function _rowTableView(Collection $permissoesSelecionadas)
    {
        return function (RowTableView $row) use ($permissoesSelecionadas) {
            $data = $row->getData();
            $checkbox = CheckboxField::create("permissoes[]", '', $data->id);

            if ($permissoesSelecionadas->where('id', $data->id)->count() > 0) {
                $checkbox->addAttribute('checked', 'checked');
            }

            $data->id = $checkbox->icheck();
        };
    }
}