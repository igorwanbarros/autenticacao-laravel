<?php

namespace Igorwanbarros\Autenticacao\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table    = 'autenticacao_users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'login_count',
        'login_attempt',
        'remenber_token',
    ];
}