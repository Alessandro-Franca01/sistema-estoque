<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PublicServant extends Model
{
    protected $fillable = [
        'name',
        'registration',
        'cpf',
        'email',
        'phone',
        'role',
        'active',
    ];
}

