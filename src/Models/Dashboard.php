<?php

namespace Igorwanbarros\Autenticacao\Models;

use Igorwanbarros\BaseLaravel\Models\BaseModel;

class Dashboard extends BaseModel
{

    protected $table = 'autenticacao_dashboard';


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}