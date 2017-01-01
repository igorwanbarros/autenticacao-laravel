<?php

namespace Igorwanbarros\Autenticacao\Http\Controllers;

use Illuminate\Http\Request;
use Igorwanbarros\Php2Html\TagHtml;
use Igorwanbarros\Php2Html\Table\RowTableView;
use Igorwanbarros\Autenticacao\Models\Dashboard;
use Igorwanbarros\Autenticacao\Widgets\FormDashboard;
use Igorwanbarros\BaseLaravel\Http\Support\FormHelper;
use Igorwanbarros\BaseLaravel\Http\Support\IndexHelper;
use Igorwanbarros\BaseLaravel\Http\Support\StoreHelper;
use Igorwanbarros\Php2HtmlLaravel\Table\TableViewLaravel;
use Igorwanbarros\BaseLaravel\Http\Support\DestroyHelper;
use Igorwanbarros\BaseLaravel\Http\Controllers\BaseController;

class DashboardController extends BaseController
{
    public function __construct(Request $request, Dashboard $model)
    {
        parent::__construct($request, $model);
        $this->headers = [
            'id'        => 'Código',
            'titulo'    => 'Titulo',
            'tamanho'   => 'Tamanho',
            'actions'   => '',
        ];

        $this->title = '<i class="fa fa-tachometer"></i> %s Dashboard';
        $this->view->urlBase = 'configuracoes/dashboard';
        $this->form = new FormDashboard(url("{$this->view->urlBase}/salvar"), Dashboard::class);
    }


    public function index()
    {
        $this->model = $this->model->where('user_id', '=', app_session('user_id'));
        $this->view->table = TableViewLaravel::source($this->headers, $this->model)
            ->callback($this->_indexRowTable())
            ->setLineLink(url('configuracoes/dashboard/editar/%s'));

        return IndexHelper::support($this);
    }


    protected function _indexRowTable()
    {
        return function (RowTableView $row) {
            $data = $row->getData();
            $excluir = '<a href="' . url($this->view->urlBase . '/excluir/' . $data->id) . '" ' .
                'class="btn btn-xs btn-danger" ' .
                'title="Excluir">' .
                '<i class="fa fa-trash fa-fw"></i>' .
                '<span class="hidden-xs">Excluir</span>' .
                '</a>';
            $attr = [
                'class' => 'btn bg-blue-active click-modal btn-xs',
                'title' => 'Visualizar Dashboard',
                'href' => url("configuracoes/dashboard/visualizar/{$data->id}")
            ];
            $visualizar = TagHtml::source('a', '<i class="fa fa-external-link fa-fw"></i> Visualizar', $attr);
            $data->actions = "{$visualizar} {$excluir}";
        };
    }


    public function form($id = null)
    {
        return FormHelper::support($this, compact('id'));
    }


    public function store()
    {
        return StoreHelper::support($this);
    }


    public function destroy($id = null)
    {
        return DestroyHelper::support($this, compact('id'));
    }


    public function dashboard()
    {
        $userId = app_session('user_id');
        $dashboards = Dashboard::where('user_id', '=', $userId)->get();
        $manager = app('dashboard')->lists(null, 'name');
        $dashboardsHtml = '';
        $isRow = 0;
        $max = $dashboards->count();

        foreach ($dashboards as $key => $dashboard) {
            $dashboardsHtml .= $this->_renderHtmlDashboard(
                $dashboard,
                $manager,
                $isRow,
                $key,
                $max,
                $this->_getClassHtmlDashboard($dashboard, $isRow)
            );

            if ($isRow > 11) {
                $isRow = 0;
            }
        }

        return view('autenticacao-laravel::dashboard.index', compact('dashboardsHtml'));
    }


    public function visualizar($id)
    {
        $dashboard = Dashboard::findOrNew($id);
        $manager = app('dashboard')->lists(null, 'name');
        $isRow = 12;

        return $this->_renderHtmlDashboard($dashboard, $manager, $isRow, 0, 1);
    }


    protected function _renderHtmlDashboard($dashboard, $manager, $isRow, $key, $max, $class = 'col-xs-12')
    {
        if (!array_key_exists($dashboard->dashboard_name, $manager)) {
            return '';
        }

        $current = $manager[$dashboard->dashboard_name];

        if (!isset($current['class']) || !isset($current['method'])) {
            return '';
        }

        $html = app($current['class'])->{$current['method']}($dashboard->titulo);
        $data = compact('html', 'class', 'isRow', 'key', 'max');

        return view('autenticacao-laravel::dashboard.render', $data);
    }


    protected function _getClassHtmlDashboard($dashboard, &$isRow)
    {
        $class = 'col-xs-12';

        if ($dashboard->tamanho == 'PEQUENO') {
            $class .= ' col-sm-4';
            $isRow += 4;
        }

        if ($dashboard->tamanho == 'MEDIO') {
            $class .= ' col-sm-8';
            $isRow += 8;
        }

        if ($dashboard->tamanho == 'GRANDE') {
            $class .= ' col-sm-12';
            $isRow += 12;
        }

        return $class;
    }
}
